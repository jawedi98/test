<?php


namespace GuideBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 */




class AffectationGuide
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Guide")
     * @ORM\JoinColumn(name="id_guide",referencedColumnName="id")
     */
    private $guide;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getGuide()
    {
        return $this->guide;
    }

    /**
     * @param mixed $guide
     */
    public function setGuide($guide)
    {
        $this->guide = $guide;
    }

    /**
     * @return mixed
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @param mixed $evenements
     */
    public function setEvenements($evenements)
    {
        $this->evenements = $evenements;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Evenements")
     * @ORM\JoinColumn(name="id_event",referencedColumnName="id")
     */
   private $evenements;



}