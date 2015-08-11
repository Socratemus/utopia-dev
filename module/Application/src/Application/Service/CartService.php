<?php

namespace Application\Service;

class CartService extends ModelService {
    
    private $_cartKey = '_usr_cart';
    private $_ttl = 7; //Days
    
    
    public function __construct(){
        //echo 'constructed!';
    }
    
    /**************************************************************************/
    //All business methods for category will be stored in here.
    
    public function verify(){
        
        if(!isset($_COOKIE[$this->_cartKey]))
        {
            $guid = $this->generateToken();
            $ttl = time()+60*60*24*$this->_ttl;
            $expire = new \DateTime(date('Y-m-d H:i:s' , $ttl));
            
            //Generate new database cart.
            $cart = new \Application\Entity\Cart();
            $cart->setGUID($guid);
            $cart->setTtl($ttl);
            $cart->setExpire($expire);
            var_dump($cart);
            exit;
        }
        
        
        
        echo 'checking if there is any cart service in place';
        exit();
    }
    
    /**
     * Returns the cart.
     */
    public function getCart()
    {
        
    }
    
    /**
     * Returns the GUID stored in the browser.
     */
    private function getBrowserGUID()
    {
            
    }
    
    private function generateToken(){
        $chars = array(
            0,1,2,3,4,5,6,7,8,9,
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N',
            'O','P','Q','R','S','T','U','V','W','X','Y','Z',
            // 'a','b','c','d','e','f','g','h','i','j','k','l','m','n',
            // 'o','p','q','r','s','t','u','v','w','x','y','z'
            );
        $serial = '';
        $max = count($chars)-1;
        for($i=0;$i<30;$i++){
            $serial .= (!($i % 5) && $i ? '-' : '').$chars[rand(0, $max)];
        }
       
        return $serial;
    }
    
    
    /**************************************************************************/
    
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Cart');
    }
}