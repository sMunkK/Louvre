<?php

namespace ML\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class Hourly extends Constraint
{
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    public $message = 'Vous ne pouvez pas réserver une journée entière après 13h.';
}