<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\PanierRepository")
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="idn", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idn;

    /**
     * @var int
     *
     * @ORM\Column(name="somme", type="integer", length=255)
     */
    private $somme;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", length=255)
     */
    private $quantite;




    /**
     * Get idn
     *
     * @return int
     */
    public function getIdn()
    {
        return $this->idn;
    }

    /**
     * Set somme
     *
     * @param int $somme
     *
     * @return Panier
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;

        return $this;
    }

    /**
     * Get somme
     *
     * @return int
     */
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * Set quantite
     *
     * @param int $quantite
     *
     * @return Panier
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }


    /**
     * @var
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */
    private $User;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param mixed $User
     */
    public function setUser($User)
    {
        $this->User = $User;
    }


}

