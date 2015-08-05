<?php

namespace Application\Entity;

interface AbstractEntity {
    
    public function toJSON();
    
    /**
     * Returns the entity in array format
     */
    public function toArray();
    
}