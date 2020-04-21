<?php


namespace GuideBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Guide
 * @ORM\Table(name="Guide")
 * @ORM\Entity(repositoryClass="GuideBundle\Repository\GuideRepository")
 */

class Guide
{
    /**
     * @return mixed
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @param mixed $regions
     */
    public function setRegions($regions)
    {
        $this->regions = $regions;
    }
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ nom est obligatoire")
     * @Assert\Length(min=3, max=15)
     */
    private $nom;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ prenom est obligatoire")
     * @Assert\Length(min=3, max=15)
     */
    private $prenom;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;
    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotBlank(message="Le champ région est obligatoire")
     */
    private $regions;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Le champ telephone est obligatoire")
     * @Assert\Length(min=8, max=8)
     */
    private $telephone;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ password est obligatoire")
     * @Assert\Length(min=10, max=20)
     */
    private $password;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ image est obligatoire")
     * @Assert\Length(min=1, max=20)
     */
    private $image;

    /**
     * @return mixed
     */
    public function getDispo()
    {
        return $this->dispo;
    }

    /**
     * @param mixed $dispo
     */
    public function setDispo($dispo)
    {
        $this->dispo = $dispo;
    }
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ disponinilité est obligatoire")
     * @Assert\Length(min=3, max=25)
     */
    private $dispo;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ description est obligatoire")
     * @Assert\Length(min=100, max=500)
     */
    private $description;



    /**
     * @return mixed
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * @param mixed $specialite
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Specialite")
     * @ORM\JoinColumn(name="id_specialite",referencedColumnName="id")
     */
    private $specialite;
    /*
     * Get id
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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */

}