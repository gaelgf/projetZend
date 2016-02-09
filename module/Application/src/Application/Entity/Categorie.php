<?php
/**
 * Categorie
 * @author us
 *
 */
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;
 
/**
 * Représentation d'un categorie
 *
 * @ORM\Entity
 * @ORM\Table(name="categorie")
 *
 * @author
 */
class Categorie 
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
    protected $_id;
    /**
     * @var string nom
     * @ORM\Column(type="string", length=255, unique=true, nullable=true, name="nom")
     */
    protected $_nom;


 
    /*********************************
     * ACCESSEURS
    *********************************/
     
    /*********** GETTERS ************/
     
    /**
     * Obtient l'identifiant categorie
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
     
    /**
     * Obtient l'nom
     * @return string
     */
    public function getNom()
    {
        return $this->_nom;
    }
     
   
    /*********** SETTERS ************/
     
    /**
     * Définit l'id du comment
     * @param int $id L'identifiant
     * @return Categorie
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
     
    /**
     * Définit le nom
     * @param $nom 
     * @return Categorie
     */
    public function setNom($nom)
    {
        $this->_nom = $nom;
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