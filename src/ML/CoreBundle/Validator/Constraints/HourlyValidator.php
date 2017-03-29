<?php

namespace ML\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HourlyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $date = new \DateTime();

        if ($date->format('H') >= 14
            AND $value->getJourVisite()->format('w-n-Y') == $date->format('w-n-Y')
            AND $value->getTypeBillet() == 1) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}