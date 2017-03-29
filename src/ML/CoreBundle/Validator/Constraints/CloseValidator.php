<?php

namespace ML\CoreBundle\Validator\Constraints;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CloseValidator extends ConstraintValidator
{
    /**
     * @var Registry
     */
    private $registry;

    public function __construct(Registry $registry)
    {

        $this->registry = $registry;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($value->getJourVisite()->format('w') == 0
            OR ($value->getJourVisite()->format('m') == 11 && $value->getJourVisite()->format('j') == 1)
            OR ($value->getJourVisite()->format('m') == 12 && $value->getJourVisite()->format('j') == 25)
            OR ($value->getJourVisite()->format('m') == 05 && $value->getJourVisite()->format('j') == 1)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
        if ($value->getJourVisite()->format('w') == 2) {
            $this->context->buildViolation($constraint->message2)
                ->addViolation();
        }

        $repository = $this->registry->getManager()->getRepository('MLTicketingBundle:OrderTicketing');
        $nombreBillets = $repository->findByJourVisite($value->getJourVisite());
        $billet = 0;
        for ($i = 0; $i < count($nombreBillets); $i++) {
            $billet1 = $nombreBillets[$i]->getNombreBillets();
            $billet = $billet + $billet1;
        }

        if ($billet == 1000) {
            $this->context->buildViolation($constraint->message3)
                ->addViolation();
        } elseif ($value->getNombreBillets() + $billet > 1000) {
            $billetRestant = 1000 - $billet;
            $this->context->buildViolation($constraint->message4)
                ->setParameter('%string%', $billetRestant)
                ->addViolation();
        }
    }
}