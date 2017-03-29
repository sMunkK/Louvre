<?php
/**
 * Created by PhpStorm.
 * User: sMunkKK
 * Date: 05/03/2017
 * Time: 14:31
 */

namespace ML\CoreBundle\Services;

class Calculator
{
    public function calcul($tickets)
    {
        $date = new \DateTime();

        foreach ($tickets as $ticket) {

            $dateNaissance = $ticket->getDateNaissance();
            $année = $date->format('Y') - $dateNaissance->format('Y');

            if ($dateNaissance->format('j') >= $date->format('j') AND $dateNaissance->format('n') == $date->format('n')
                OR $dateNaissance->format('n') < $date->format('n')
            ) {
                $année++;
            }
            if ($année >= 12 AND $année <= 59) {
                $ticket->setPrix('16');
            } elseif ($année >= 4 AND $année <= 11) {
                $ticket->setPrix('8');
            } elseif ($année >= 60) {
                $ticket->setPrix('12');
            } elseif ($année < 4) {
                $ticket->setPrix('0');
            }
            if ($ticket->getTarifReduit() == true AND $année >= 12) {
                $ticket->setPrix(10);
            }
        }
        return $tickets;
    }
}