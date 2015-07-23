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
 * @ORM\Table(name="category")
 */
class Category extends Entity implements AbstractEntity {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $CategoryId;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Title;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Slug;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $Created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $Updated;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $Status;
    
    protected $Depth;
    
    /**
     * @ORM\Column(type="integer",nullable=true) @var string 
     */
    protected $ParentId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="Children")
     * @ORM\JoinColumn(name="ParentId", referencedColumnName="CategoryId")
     **/
    private $Parent;
    
    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="Parent")
     **/
    private $Children;
    
    public function __construct(){
        $this->Created = new \DateTime('now');
        $this->Updated = new \DateTime('now');
    }
    
    public function getCategoryId(){
        return $this->CategoryId;
    }
    public function getTitle(){
        return $this->Title;
    }
    public function getSlug(){
        return $this->Slug;
    }
    public function getCreated(){
        return $this->Created;
    }
    public function getUpdated(){
        return $this->Updated;
    }
    public function getStatus(){
        return $this->Status;
    }
    public function getParent(){
        return $this->Parent;
    }
    public function getDepth(){
        return $this->Depth;
    }
    
    public function setTitle($Title){
        $this->Title = $Title;
    }
    public function setCreated($Created){
        $this->Created = $Created;
    }
    public function setUpdated($Updated){
        $this->Updated = $Updated;
    }
    public function setStatus($Status){
        $this->Status = $Status;
    }
    
    public function setParent($Parent){
        $this->Parent = $Parent;
    }
    
    public function setDepth($Depth){
        $this->Depth = $Depth;
    }
    
    public function toJson(){
        
        $jsonArr  = $this->toArray();
        
        return json_encode($jsonArr);
    }
    
    public function toArray(){
        
        $array  = array(
            'CategoryId' => $this->getCategoryId(),
            'Title' => $this->getTitle(),
            'Slug' => $this->getSlug(),
            'Created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'Updated' => $this->getUpdated()->format('Y-m-d H:i:s'),
            'Status'  => $this->getStatus()
        );
        
        return $array;
    }
}