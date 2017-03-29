<?php

namespace ML\CoreBundle\Controller;

use ML\TicketingBundle\Entity\OrderTicketing;
use ML\TicketingBundle\Form\OrderTicketingType;
use ML\TicketingBundle\Form\TicketingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CoreController extends Controller
{
    public function indexAction(Request $request)
    {
        $order = new OrderTicketing();

        $form = $this->createForm(OrderTicketingType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = $request->getSession();
            $session->set('commande', $order);
            return $this->redirectToRoute('ml_ticketing_homepage');
        }

        return $this->render('@MLCore/home.html.twig', array('form' => $form->createView(),
        ));
    }

    public function ticketAction(Request $request)
    {
        if ($request->getSession()->get('commande') === null) {

            return $this->redirectToRoute('ml_core_homepage');

        }
            $session = $request->getSession();
            $nombreBillets = $session->get('commande')->getNombreBillets();
            $form = $this->createFormBuilder();

            for ($i = 0; $i < $nombreBillets; $i++) {
                $form->add($i, TicketingType::class, ['label' => 'Visiteur ' . ($i + 1)]);
            }

            $form->add('save', SubmitType::class, array('label' => 'Commander'));
            $form = $form->getForm();
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tickets = $form->getData();

                $this->get('ml_core.services.calculator')->calcul($tickets);

                foreach ($tickets as $ticket) {
                    $ticket->setOrder($session->get('commande'));
                }
                return $this->redirectToRoute('ml_ticketing_payment');
            }

            return $this->render('@MLTicketing/Default/ticket.html.twig', array('form' => $form->createView()
            ));
    }

    public function paymentAction(Request $request)
    {
        if ($request->getSession()->get('commande') === null) {

            return $this->redirectToRoute('ml_core_homepage');

        }
        $commande = $request->getSession()->get('commande');
        $prixTotal = 0;

        for ($i = 0; $i < count($commande->getTickets()); $i++) {
            $prix = $request->getSession()->get('commande')->getTickets()[$i]->getPrix();
            $prixTotal = $prixTotal + $prix;
        }

        $prixTotalStripe = $prixTotal * 100;
        $request->getSession()->set('prix', $prixTotalStripe);
        $request->getSession()->set('prixNonStrip', $prixTotal);

        return $this->render('MLTicketingBundle::payment.html.twig', array(
                'public_key' => $this->getParameter("public_key"),
                'prixTotal' => $prixTotalStripe)
        );
    }

    public function checkoutAction(Request $request)
    {
        if ($request->getSession()->get('commande') === null) {

            return $this->redirectToRoute('ml_core_homepage');

        }

        $prix = $request->getSession()->get('prix');
        \Stripe\Stripe::setApiKey($this->getParameter("private_key"));

        $token = $_POST['stripeToken'];

        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $prix,
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - Billet(s) Musée Du Louvre"
            ));

            $this->addFlash("success", "Paiement accepté !");
            $email = $request->getSession()->get('commande')->getEmail();

            $commande = $request->getSession()->get('commande');

            $this->get('ml_core.services.mailer')->mailer($commande, $email);

            $commande->setStatus('1');

            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            $request->getSession()->remove('commande');
            return $this->redirectToRoute("ml_core_homepage");

        } catch (\Stripe\Error\Card $e) {

            $this->addFlash("error", "Paiment refusé.");
            return $this->redirectToRoute("ml_ticketing_payment", array(
                'public_key' => $this->getParameter("public_key")
            ));
        }
    }

    public function testAction(Request $request)
    {
        $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789';
        $nb_car = 8;

            $nb_lettres = strlen($chaine) - 1;
            $generation = '';
            for($i=0; $i < $nb_car; $i++)
            {
                $pos = mt_rand(0, $nb_lettres);
                $car = $chaine[$pos];
                $generation .= $car;
            }

        return $this->render('@MLCore/email.html.twig', array('code' => $generation));
    }
}

