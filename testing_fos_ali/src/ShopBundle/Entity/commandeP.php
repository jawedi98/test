<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commandeP
 *
 * @ORM\Table(name="commandep")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\commandePRepository")
 */
class commandeP
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcm", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idcm;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="somme", type="integer", length=255)
     */

    private $somme;

    /**
     * @return mixed
     */
    public function getIdn()
    {
        return $this->idn;
    }

    /**
     * @param mixed $idn
     */
    public function setIdn($idn)
    {
        $this->idn = $idn;
    }

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="Panier")
     * @ORM\JoinColumn(name="idn", referencedColumnName="idn")
     */

    private $idn;

    /**
     * @return int
     */
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * @param int $somme
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


    /**
     * Get idcm
     *
     * @return int
     */
    public function getIdcm()
    {
        return $this->idcm;
    }
}

