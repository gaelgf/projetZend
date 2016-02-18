<?php
/**
 * Post
 * @author us
 *
 */
namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Représentation d'un post
 *
 * @ORM\Entity
 * @ORM\Table(name="post")
 *
 * @author
 */
class Post implements InputFilterAwareInterface
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
    * @ORM\ManyToMany(targetEntity="Admin\Entity\Categorie", mappedBy="Post", cascade={"persist"})
    */
    private $_categorie;
    protected $inputFilter;
 
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
  
    /**
    * obtient categorie
    *
    * @return Admin\Entity\Categorie
    */
    public function getCategorie()
    {
        return $this->_categorie;
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

       /**
    * Définit la categorie
    *
    * @param Admin\Entity\Categorie 
    * @return Post
    */
    public function setCategorie(Admin\Entity\Categorie $categorie = null)
    {
        $this->_categorie = $categorie;
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
   
    /**
    * Exchange array - used in ZF2 form
    *
    * @param array $data An array of data
    */
    public function exchangeArray($data)
    {
        $this->_id = (isset($data['_id']))? $data['_id'] : null;
        $this->_titre = (isset($data['_titre']))? $data['_titre'] : null;
        $this->_contenu = (isset($data['_contenu']))? $data['_contenu'] : null;
        $this->_categorie = (isset($data['_categorie']))? $data['_categorie'] : null;
    }
    /**
    * Get an array copy of object
    *
    * @return array
    */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    /**
    * Set input method
    *
    * @param InputFilterInterface $inputFilter
    */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    /**
    * Get input filter
    *
    * @return InputFilterInterface
    */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            $inputFilter->add($factory->createInput(array(
                'name'     => '_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => '_titre',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => '_contenu',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                        ),
                    ),
                ),
            )));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }


}//end class