<?php
/**
 * Created by PhpStorm.
 * User: sMunkKK
 * Date: 05/03/2017
 * Time: 16:32
 */

namespace ML\CoreBundle\Services;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $swift_Mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig_Environment;

    public function __construct(\Swift_Mailer $swift_Mailer, \Twig_Environment $twig_Environment)
    {
        $this->swift_Mailer = $swift_Mailer;
        $this->twig_Environment = $twig_Environment;
    }

    public function mailer($commande, $email)
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

            $message = new \Swift_Message();
            $message
                ->setSubject('Billetterie Musée du Louvre')
                ->setFrom('bottomgaming@outlook.com')
                ->setTo($email)
                ->setBody(
                    $this->twig_Environment->render(
                        '@MLCore/email.html.twig',
                        array('commande' => $commande, 'code' => $generation)
                   ),
                    'text/html'
               );
          $this->swift_Mailer->send($message);
   }
}