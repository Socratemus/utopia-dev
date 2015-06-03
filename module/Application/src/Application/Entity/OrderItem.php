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
 * @ORM\Table(name="order_item")
 */
class OrderItem {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $OrderItemId;
    
    
    
}