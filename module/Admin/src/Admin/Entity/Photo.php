<?php
/**
 * Photo
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
 * Représentation d'une photo
 *
 * @ORM\Entity
 * @ORM\Table(name="photo")
 *
 * @author
 */
class Photo implements InputFilterAwareInterface
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
     * @var string lien
     * @ORM\Column(type="string", length=255, unique=true, nullable=true, name="lien")
     */
    protected $lien;
    /**
     * @var string alt
     * @ORM\Column(type="string", unique=true,  length=255, name="alt")
     */
    protected $alt;

    protected $inputFilter;
    
 
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
      /**
    * Exchange array - used in ZF2 form
    *
    * @param array $data An array of data
    */
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id']))? $data['id'] : null;
        $this->lien = (isset($data['lien']))? $data['lien'] : null;
        $this->alt = (isset($data['alt']))? $data['alt'] : null;
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
                'name'     => 'lien',
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
                'name'     => 'alt',
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