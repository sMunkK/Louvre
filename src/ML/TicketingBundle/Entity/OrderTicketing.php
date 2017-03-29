<?php

namespace ML\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ML\CoreBundle\Validator\Constraints as AcmeAssert;

/**
 * OrderTicketing
 * @AcmeAssert\Hourly()
 * @AcmeAssert\Close()
 *
 * @ORM\Table(name="order_ticketing")
 * @ORM\Entity(repositoryClass="ML\TicketingBundle\Repository\OrderTicketingRepository")
 */
class OrderTicketing
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\Email(
     *     message = "L'email entré {{ value }} n'est pas valide.",
     *     checkMX = true
     *     )
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime
     * @Assert\GreaterThanOrEqual(
     *     value = "today",
     *     message = "Vous ne pouvez pas commander de billet pour une date inférieur à aujourd'hui."
     * )
     * @Assert\LessThanOrEqual(
     *     value = "now + 90 day",
     *     message = "Vous ne pouvez pas commander de billet plus tard que les 3 prochains mois."
     * )
     *
     * @ORM\Column(name="jourVisite", type="datetime")
     */
    private $jourVisite;

    /**
     * @var int
     * @Assert\Range(
     *     min = 0,
     *     max = 1
     * )
     *
     * @ORM\Column(name="typeBillet", type="integer")
     */
    private $typeBillet;

    /**
     * @var int
     * @Assert\Type(
     *     type="integer",
     *     message="{{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\Range(
     *     min = 1,
     *     minMessage="Le nombre minimum de billet à acheter est de 1."
     * )
     *
     * @ORM\Column(name="nombreBillets", type="integer")
     */
    private $nombreBillets;

    /**
     *
     * @var array
     *
     * @ORM\OneToMany(targetEntity="ML\TicketingBundle\Entity\Ticketing", mappedBy="order", cascade={"persist"})
     */
    private $tickets;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return OrderTicketing
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return OrderTicketing
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set jourVisite
     *
     * @param \DateTime $jourVisite
     *
     * @return OrderTicketing
     */
    public function setJourVisite($jourVisite)
    {
        $this->jourVisite = $jourVisite;

        return $this;
    }

    /**
     * Get jourVisite
     *
     * @return \DateTime
     */
    public function getJourVisite()
    {
        return $this->jourVisite;
    }

    /**
     * Set typeBillet
     *
     * @param integer $typeBillet
     *
     * @return OrderTicketing
     */
    public function setTypeBillet($typeBillet)
    {
        $this->typeBillet = $typeBillet;

        return $this;
    }

    /**
     * Get typeBillet
     *
     * @return int
     */
    public function getTypeBillet()
    {
        return $this->typeBillet;
    }

    /**
     * Set nombreBillets
     *
     * @param integer $nombreBillets
     *
     * @return OrderTicketing
     */
    public function setNombreBillets($nombreBillets)
    {
        $this->nombreBillets = $nombreBillets;

        return $this;
    }

    /**
     * Get nombreBillets
     *
     * @return int
     */
    public function getNombreBillets()
    {
        return $this->nombreBillets;
    }

    /**
     * Add ticket
     * @deprecated
     * @param \ML\TicketingBundle\Entity\Ticketing $ticket
     *
     * @return OrderTicketing
     */
    public function addTicket(\ML\TicketingBundle\Entity\Ticketing $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \ML\TicketingBundle\Entity\Ticketing $ticket
     */
    public function removeTicket(\ML\TicketingBundle\Entity\Ticketing $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}
