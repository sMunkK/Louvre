<?php

namespace ML\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class Close extends Constraint
{
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    public $message = "Vous ne pouvez pas réserver de tickets pour ce jour-là, car c'est le jour de fermeture du musée.";
    public $message2 = 'La billeterie en ligne est fermé tous les mardis.';
    public $message3 = "Il n'y a plus de billets disponibles pour ce jour-là.";
    public $message4 = "Il ne reste seulement que %string% billet(s) de disponible pour ce jour-là.";
}