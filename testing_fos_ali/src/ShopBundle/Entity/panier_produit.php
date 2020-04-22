<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * panier_produit
 *
 * @ORM\Table(name="panier_produit")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\panier_produitRepository")
 */
class panier_produit
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
     * @var float
     *
     * @ORM\Column(name="qte", type="float")
     */
    private $qte;


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
     * Set qte
     *
     * @param float $qte
     *
     * @return Panier_Produit
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return float
     */
    public function getQte()
    {
        return $this->qte;
    }



    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Panier")
     * @ORM\JoinColumn(name="panier_id", referencedColumnName="idn")
     */
    private $panier;


    /**
     * @return mixed
     */
    public function getPanier()
    {
        return $this->panier;
    }

    /**
     * @param mixed $panier
     */
    public function setPanier($panier)
    {
        $this->panier = $panier;
    }




    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumn(name="produit_id", referencedColumnName="idp")
     */
    private $produit;



    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }


}

