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
    protected $id;
    /**
     * @var string titre
     * @ORM\Column(type="string", length=255, unique=true, nullable=true, name="titre")
     */
    protected $titre;
    /**
     * @var string contenu
     * @ORM\Column(type="string", unique=true,  length=255, name="contenu")
     */
    protected $contenu;
    /**
    * @ORM\ManyToOne(targetEntity="Admin\Entity\User",  cascade={"persist"})
    * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
    */
    private $user;

    /**
    * @ORM\OneToOne(targetEntity="Admin\Entity\Photo", cascade={"persist"})
    */
    private $photo;
    
    /**
    * @ORM\OneToMany(targetEntity="Admin\Entity\Comment", mappedBy="post", cascade={"persist"})
    */
    private $comment;

    /**
    * @ORM\OneToMany(targetEntity="Admin\Entity\Categorie", mappedBy="post", cascade={"persist"})
    * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
    */
    private $categorie;
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
        return $this->id;
    }
     
    /**
     * Obtient le titre
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }
     
    /**
     * Obtient le contenu
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }
     
    /**
     * Obtient le user
     * @return Admin\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
     
    /**
     * Obtient la photo
     * @return Admin\Entity\Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }   
     
    /**
     * Obtient le commentaire
     * @return Admin\Entity\Comment
     */
    public function getComment()
    {
        return $this->comment;
    }
  
    /**
    * obtient categorie
    *
    * @return Admin\Entity\Categorie
    */
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
        $this->id = (int) $id;
        return $this;
    }
     
    /**
     * Définit le titre
     * @param $titre 
     * @return Post
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }
     
    /**
     * Définit le contenu
     * @param $contenu
     * @return Post
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
        return $this;
    }
     
    /**
     * Définit le user
     * @param Admin\Entity\User
     * @return Post
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
        return $this;
    }
     
    /**
     * Définit la photo
     * @param Admin\Entity\Photo
     * @return Post
     */
    public function setPhoto(Photo $photo = null)
    {
        $this->photo = $photo;
        return $this;
    }   
     
    /**
     * Définit le commentaire
     * @param Admin\Entity\Comment
     * @return Post
     */
    public function setComment(Comment $comment = null)
    {
        $this->comment = $comment;
        return $this;
    }

       /**
    * Définit la categorie
    *
    * @param Admin\Entity\Categorie 
    * @return Post
    */
    public function setCategorie(Categorie $categorie = null)
    {
        $this->categorie = $categorie;
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
        $this->id = (isset($data['id']))? $data['id'] : null;
        $this->titre = (isset($data['titre']))? $data['titre'] : null;
        $this->contenu = (isset($data['contenu']))? $data['contenu'] : null;
        $this->categorie = (isset($data['categorie']))? $data['categorie'] : null;
    }
    /**
    * Get an array copy of object
    *
    * @return array
    */
    public function getArrayCopy()
    {
        return getobjectvars($this);
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
            /*$inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));*/
            $inputFilter->add($factory->createInput(array(
                'name'     => 'titre',
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
                'name'     => 'contenu',
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