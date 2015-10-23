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
        $this->Updated = new \DateTime('now');
        $exclude = array('Created' , 'Updated');
        $reflect = new \ReflectionClass($this);

        $props = $reflect->getProperties(\ReflectionProperty::IS_PROTECTED);

        foreach ($props as $prop) {

            if (isset($Data[$prop->getName()]) && ! in_array($prop->getName(),$exclude)) {
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
        
        /* return all protected values */
        $reflect = new \ReflectionClass($this);

        $props = $reflect->getProperties(\ReflectionProperty::IS_PROTECTED);
        $arr = array();
        foreach ($props as $prop) {
            //var_dump(isset($this->{$prop->getName()}));
            if (isset($this->{$prop->getName()}) && ! $this->{$prop->getName()} instanceof \DateTime) {
                //echo $this->{$prop->getName()};
                $arr[$prop->getName()] = $this->{$prop->getName()};
            }
        }
        
        //var_dump($arr);exit;
        
        $toMerge = array(
            'Created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'Updated' => $this->getUpdated()->format('Y-m-d H:i:s'),
            'Status'  => $this->getStatus()
        );
        //var_dump($toMerge);exit;
        return array_merge ( $arr , $toMerge  );
    }
    
}