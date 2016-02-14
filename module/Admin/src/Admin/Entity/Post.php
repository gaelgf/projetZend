<?php
/**
 * Post
 * @author us
 *
 */
namespace Admin\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Représentation d'un post
 *
 * @ORM\Entity
 * @ORM\Table(name="post")
 *
 * @author
 */
class Post 
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
     * @var string titre
     * @ORM\Column(type="string", length=255, unique=true, nullable=true, name="titre")
     */
    protected $_titre;
    /**
     * @var string contenu
     * @ORM\Column(type="string", unique=true,  length=255, name="contenu")
     */
    protected $_contenu;
    /**
    * @ORM\OneToOne(targetEntity="Admin\Entity\User", cascade={"persist"})
    * @JoinColumn(name="user_id", referencedColumnName="user_id")
    */
    private $_user;

    /**
    * @ORM\OneToOne(targetEntity="Admin\Entity\Photo", cascade={"persist"})
    */
    private $_photo;
    
    /**
    * @ORM\OneToOne(targetEntity="Admin\Entity\Comment", cascade={"persist"})
    */
    private $_comment;

    /**
    * @ORM\ManyToMany(targetEntity="Admin\Entity\Categorie", cascade={"persist"})
    */
    private $_categorie;
 
    /*********************************
     * ACCESSEURS
    *********************************/
     
    /*********** GETTERS ************/
     
    /**
     * Obtient l'identifiant post
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
     
    /**
     * Obtient le titre
     * @return string
     */
    public function getTitre()
    {
        return $this->_titre;
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
     * Obtient le user
     * @return Admin\Entity\User
     */
    public function getUser()
    {
        return $this->_user;
    }
     
    /**
     * Obtient la photo
     * @return Admin\Entity\Photo
     */
    public function getPhoto()
    {
        return $this->_photo;
    }   
     
    /**
     * Obtient le commentaire
     * @return Admin\Entity\Comment
     */
    public function getComment()
    {
        return $this->_comment;
    }


  public function getCategorie()
  {
    return $this->categorie;
  }
       
     
     
    /*********** SETTERS ************/
     
    /**
     * Définit l'id du post
     * @param int $id L'identifiant
     * @return Post
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
     
    /**
     * Définit le titre
     * @param $titre 
     * @return Post
     */
    public function setTitre($titre)
    {
        $this->_titre = $titre;
        return $this;
    }
     
    /**
     * Définit le contenu
     * @param $contenu
     * @return Post
     */
    public function setContenu($contenu)
    {
        $this->_contenu = $contenu;
        return $this;
    }
     
    /**
     * Définit le user
     * @param Admin\Entity\User
     * @return Post
     */
    public function setUser(Admin\Entity\User $user = null)
    {
        $this->_user = $user;
        return $this;
    }
     
    /**
     * Définit la photo
     * @param Admin\Entity\Photo
     * @return Post
     */
    public function setPhoto(Admin\Entity\Photo $photo = null)
    {
        $this->_photo = $photo;
        return $this;
    }   
     
    /**
     * Définit le commentaire
     * @param Admin\Entity\Comment
     * @return Post
     */
    public function setComment(Admin\Entity\Comment $comment = null)
    {
        $this->_comment = $comment;
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
        $this->categorie = new ArrayCollection();
    }
 
    /*********************************
     * METHODES
    *********************************/
     
    /************ PUBLIC ************/
    // on ajoute une seule catégorie à la fois
  public function addCategorie(Categorie $categorie)
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau
    $this->categorie[] = $categorie;

    return $this;
  }

  public function removeCategorie(Categorie $categorie)
  {
    // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
    $this->categories->removeElement($categorie);
  }
  
    /*********** PROTECTED **********/
     
    /************ PRIVATE ***********/
}