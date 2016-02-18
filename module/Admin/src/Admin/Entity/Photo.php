<?php
/**
 * Photo
 * @author us
 *
 */
namespace Admin\Entity;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * Représentation d'une photo
 *
 * @ORM\Entity
 * @ORM\Table(name="photo")
 *
 * @author
 */
class Photo 
{
    /*********************************
     * ATTRIBUTS
    *********************************/
     
    /**
     * @var int L'identifiant utilisateur
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string lien
     * @ORM\Column(type="string", length=255, unique=true, nullable=true, name="lien")
     */
    protected $lien;
    /**
     * @var string alt
     * @ORM\Column(type="string", unique=true,  length=255, name="alt")
     */
    protected $alt;
    
 
    /*********************************
     * ACCESSEURS
    *********************************/
     
    /*********** GETTERS ************/
     
    /**
     * Obtient l'identifiant photo
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
     
    /**
     * Obtient le lien
     * @return string
     */
    public function getLien()
    {
        return $this->lien;
    }
     
    /**
     * Obtient le alt
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
     
    
     
    /*********** SETTERS ************/
     
    /**
     * Définit l'id du post
     * @param int $id L'identifiant
     * @return Photo
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }
     
    /**
     * Définit le lien
     * @param $lien 
     * @return Photo
     */
    public function setLien($lien)
    {
        $this->lien = $lien;
        return $this;
    }
     
    /**
     * Définit le alt
     * @param $alt
     * @return Photo
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
        return $this;
    }
     
    
    /*********************************
     * CONSTRUCTEUR / DESTRUCTEUR
    *********************************/
     
    /**
     * Constructeur
     */
    public function __construct()
    {
         
    }
 
    /*********************************
     * METHODES
    *********************************/
     
    /************ PUBLIC ************/
         
    /*********** PROTECTED **********/
     
    /************ PRIVATE ***********/
}