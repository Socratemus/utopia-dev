<?php

/**
 * @author Corneliu Iancu <corneliu.iancu27@gmail.com>
 * @Date Oct 25, 2014
 * @copyright (c) 2014, Corneliu Iancu
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 */
class Address extends Entity {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $AddressId;
    
    /**
     * @ORM\Column(type="string" , length=255)
     */
    protected $Contact;
    
    /**
     * @ORM\Column(type="string" , length=10)
     */
    protected $Phone;
    
    /**
     * @ORM\Column(type="string" , length=255)
     */
    protected $Email;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $Address;
    
    /**
     * Aka Judet 
     * @ORM\Column(type="string" , length=255)
     */
    protected $District;
    
    /**
     * Aka Localitate (Eg. Com. XXXXXX)
     * @ORM\Column(type="string" , length=255)
     */
    protected $Locality;
    
    public function __construct(){
        
        parent::__construct();
        
    }
    
}