<?php

namespace Application\Entity;

abstract class Entity {
    
    final public function exchange($Data){
        
        $reflect = new \ReflectionClass($this);

        $props = $reflect->getProperties(\ReflectionProperty::IS_PROTECTED);

        foreach ($props as $prop) {

            if (isset($Data[$prop->getName()])) {
                $this->{$prop->getName()} = $Data[$prop->getName()];
            }
        }
        
    }
    
}