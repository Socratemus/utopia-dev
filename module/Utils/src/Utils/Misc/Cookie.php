<?php

namespace Utils\Misc;

class Cookie {
    
    protected static $Instance = null;
    
    public static function getInstance(){
        if(!self::$Instance){
            self::$Instance = new Cookie();
        }
        return self::$Instance;
    }
    
    public function set($Key , $Value , $Ttl = false){
        
        $setval = serialize($Value);
        setcookie($Key, serialize($Value), $Ttl ? $Ttl : mktime(0, 0, 0, 12, 31, 2015), '/');
        if(!isset($_COOKIE[$Key])){
            $_COOKIE[$Key] = $setval;
        }
    }
    
    public function get($Key) {
        
        if (isset($_COOKIE[$Key]))
            return unserialize(stripslashes($_COOKIE[$Key]));
        else
            return false;
    }
    
    public function remove($Key){
        if (isset($_COOKIE[$Key])) {
            setcookie($Key, "false", time() - 3600, '/');
        }
    }
}