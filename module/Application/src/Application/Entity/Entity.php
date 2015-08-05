<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class Entity {
    
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
    
    public function __construct(){
        $this->Created = new \DateTime('now');
        $this->Updated = new \DateTime('now');
        $this->Status = 200;
    }
    
    /**************************************************************************/
    final public function exchange($Data){
        //var_dump($Data);exit;
        $reflect = new \ReflectionClass($this);

        $props = $reflect->getProperties(\ReflectionProperty::IS_PROTECTED);

        foreach ($props as $prop) {

            if (isset($Data[$prop->getName()])) {
                $this->{$prop->getName()} = $Data[$prop->getName()];
            }
        }
        
        $props = $reflect->getProperties(\ReflectionProperty::IS_PRIVATE);
        foreach ($props as $prop) {
            if (isset($Data[$prop->getName()])) {
                $method = 'get'.ucwords($prop->getName());
                //check if this has method
                if(method_exists ( $this , $method )){
                    $entity = $this->{$method}();
                    if($entity instanceof Entity){
                        $entity->exchange($Data[$prop->getName()]);
                    }
                    
                }
            }
        }
    }
    /**************************************************************************/
    
    public function setCreated($Created){
        $this->Created = $Created;
    }
    public function setUpdated($Updated){
        $this->Updated = $Updated;
    }
    public function setStatus($Status){
        $this->Status = $Status;
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
    
    public function toArray(){
        return array(
            'Created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'Updated' => $this->getUpdated()->format('Y-m-d H:i:s'),
            'Status'  => $this->getStatus()
        );
    }
    
}