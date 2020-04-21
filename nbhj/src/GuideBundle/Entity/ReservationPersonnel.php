<?php


namespace GuideBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Guide
 * @ORM\Table(name="reservation_personnel")
 * @ORM\Entity(repositoryClass="GuideBundle\Repository\ReservationPersonnelRepository")
 */


class ReservationPersonnel
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $user;
    /**
     * @ORM\Column(type="date")
     * @Assert\Date
     * @Assert\GreaterThanOrEqual("today")
     */
    private $dateDebut;
    /**
     * @ORM\Column(type="date")
     * @Assert\Date
     * @Assert\GreaterThanOrEqual(propertyPath="dateDebut" ,message="la date du fin doit etre superieure à la date debut")
     */
    private $dateFin;




    /**
     * @ORM\ManyToOne(targetEntity="Guide")
     * @ORM\JoinColumn(name="id_guide",referencedColumnName="id")
     */
    private $guide;



}