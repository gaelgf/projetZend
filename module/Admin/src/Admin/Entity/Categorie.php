<?php
/**
 * Categorie
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
 * Représentation d'un categorie
 *
 * @ORM\Entity
 * @ORM\Table(name="categorie")
 *
 * @author
 */
class Categorie implements InputFilterAwareInterface
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
     * @var string nom
     * @ORM\Column(type="string", length=255, unique=true, nullable=true, name="nom")
     */
    protected $nom;

    protected $inputFilter;


 
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
        return $this->id;
    }
     
    /**
     * Obtient l'nom
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
     
   
    /*********** SETTERS ************/
     
    /**
     * Définit l'id du comment
     * @param int $id L'identifiant
     * @return Categorie
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }
     
    /**
     * Définit le nom
     * @param $nom 
     * @return Categorie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
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
        $this->nom = (isset($data['nom']))? $data['nom'] : null;
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
            /*$inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                     array('name' => 'Int'),
                  ),
             ));*/
            $inputFilter->add($factory->createInput(array(
                'name'     => 'nom',
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
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }


}