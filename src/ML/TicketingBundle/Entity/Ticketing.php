<?php

namespace ML\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ML\CoreBundle\Validator\Constraints as AcmeAssert;

/**
 * Ticketing
 *
 * @ORM\Table(name="ticketing")
 * @ORM\Entity(repositoryClass="ML\TicketingBundle\Repository\TicketingRepository")
 */
class Ticketing
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
     * @Assert\Length(
     *     min = 1,
     *     max = 255,
     *     minMessage = "Votre NOM ne peut pas contenir moin de 1 caractère.",
     *     maxMessage = "Votre NOM ne peut pas contenir plus de 255 caractères."
     * )
     * @AcmeAssert\ContainsAlphanumeric()
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     * @Assert\Length(
     *     min = 1,
     *     max = 255,
     *     minMessage = "Votre Prénom ne peut pas contenir moin de 1 caractère.",
     *     maxMessage = "Votre Prénom ne peut pas contenir plus de 255 caractères."
     * )
     * @AcmeAssert\ContainsAlphanumeric()
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     * @Assert\Country()
     *
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var \DateTime
     * @Assert\Date()
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var bool
     * @Assert\Type(
     *     type="bool",
     *     message="La case doit être cochée ou non"
     * )
     *
     * @ORM\Column(name="tarifReduit", type="boolean")
     */
    private $tarifReduit;

    /**
     *
     * @var OrderTicketing
     *
     * @ORM\ManyToOne(targetEntity="ML\TicketingBundle\Entity\OrderTicketing", inversedBy="tickets")
     */
    private $order;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Ticketing
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Ticketing
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Ticketing
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Ticketing
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set categorie
     *
     * @param integer $categorie
     *
     * @return Ticketing
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return int
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Ticketing
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set tarifReduit
     *
     * @param boolean $tarifReduit
     *
     * @return Ticketing
     */
    public function setTarifReduit($tarifReduit)
    {
        $this->tarifReduit = $tarifReduit;

        return $this;
    }

    /**
     * Get tarifReduit
     *
     * @return bool
     */
    public function getTarifReduit()
    {
        return $this->tarifReduit;
    }

    /**
     * Set order
     *
     * @param \ML\TicketingBundle\Entity\OrderTicketing $order
     *
     * @return Ticketing
     */
    public function setOrder(\ML\TicketingBundle\Entity\OrderTicketing $order = null)
    {
        $this->order = $order;
        $order->addTicket($this);

        return $this;
    }

    /**
     * Get order
     *
     * @return \ML\TicketingBundle\Entity\OrderTicketing
     */
    public function getOrder()
    {
        return $this->order;
    }
}
