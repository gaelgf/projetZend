<?php
/**
 * Comment
 * @author us
 *
 */
namespace Admin\Entity;
use Doctrine\ORM\Mapping as ORM;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
 
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
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var string email
     * @ORM\Column(type="string", length=255, nullable=true, name="email")
     */
    protected $email;
    /**
     * @var string contenu
     * @ORM\Column(type="string", length=255, nullable=true, name="contenu")
     */
    protected $contenu;
    /**
    * @ORM\ManyToOne(targetEntity="Admin\Entity\Post", inversedBy="comment", cascade={"persist"})
    */
    private $post;

    protected $inputFilter;

 
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
        return $this->id;
    }
     
    /**
     * Obtient l'email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Obtient le post
     * @return Admin\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
     
     
    /*********** SETTERS ************/
     
    /**
     * Définit l'id du comment
     * @param int $id L'identifiant
     * @return Comment
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }
     
    /**
     * Définit le email
     * @param $email 
     * @return Comment
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
     
    /**
     * Définit le contenu
     * @param $contenu
     * @return Comment
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
        return $this;
    }
     
    /**
     * Définit le post
     * @param Admin\Entity\Post
     * @return Comment
     */
    public function setPost(Post $post = null)
    {
        $this->post = $post;
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
     /**
    * Exchange array - used in ZF2 form
    *
    * @param array $data An array of data
    */
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id']))? $data['id'] : null;
        $this->email = (isset($data['email']))? $data['email'] : null;
        $this->contenu = (isset($data['contenu']))? $data['contenu'] : null;
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
                'name'     => 'contenu',
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
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                
            )));
            /*$inputFilter->add($factory->createInput(array(
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                    array(
                        new \Zend\Validator\EmailAddress(),
                        ),
                    ),
                ),
            ));*/
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}