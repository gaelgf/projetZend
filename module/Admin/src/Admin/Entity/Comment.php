<?php
/**
 * Comment
 * @author us
 *
 */
namespace Admin\Entity;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * Représentation d'un comment
 *
 * @ORM\Entity
 * @ORM\Table(name="comment")
 *
 * @author
 */
class Comment 
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
     * @var string email
     * @ORM\Column(type="string", length=255, unique=true, nullable=true, name="email")
     */
    protected $_email;
    /**
     * @var string contenu
     * @ORM\Column(type="string", unique=true,  length=255, name="contenu")
     */
    protected $_contenu;
    /**
    * @ORM\OneToOne(targetEntity="Admin\Entity\Post", cascade={"persist"})
    */
    private $_post;

 
    /*********************************
     * ACCESSEURS
    *********************************/
     
    /*********** GETTERS ************/
     
    /**
     * Obtient l'identifiant comment
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
     
    /**
     * Obtient l'email
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }
     
    /**
     * Obtient le contenu
     * @return string
     */
    public function getContenu()
    {
        return $this->_contenu;
    }
     
    /**
     * Obtient le post
     * @return Admin\Entity\Post
     */
    public function getPost()
    {
        return $this->_post;
    }
     
     
    /*********** SETTERS ************/
     
    /**
     * Définit l'id du comment
     * @param int $id L'identifiant
     * @return Comment
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
     
    /**
     * Définit le email
     * @param $email 
     * @return Comment
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }
     
    /**
     * Définit le contenu
     * @param $contenu
     * @return Comment
     */
    public function setContenu($contenu)
    {
        $this->_contenu = $contenu;
        return $this;
    }
     
    /**
     * Définit le post
     * @param Admin\Entity\Post
     * @return Comment
     */
    public function setPost(Admin\Entity\Post $post = null)
    {
        $this->_post = $post;
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