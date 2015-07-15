<?php

/**
 * @author Corneliu Iancu <corneliu.iancu27@gmail.com>
 * @Date Oct 25, 2014
 * @copyright (c) 2014, Corneliu Iancu
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_log")
 */
class AppLog {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $LogId;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $PriorityId;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $PriorityName;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $Message;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $Url;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $IpAddress;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $Timestamp; //The time
    
}