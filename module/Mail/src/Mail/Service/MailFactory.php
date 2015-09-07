<?php

namespace Mail\Service;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;
    //Mailer\Mailer;

class MailFactory implements FactoryInterface
{

    /**
     * Create and return a Mailer instance
     *
     * @param  ServiceLocatorInterface $ServiceLocator
     * @return Mailer
     */
    public function createService(ServiceLocatorInterface $ServiceLocator)
    {
        //somehow pass config in here
        $mail = new \Mail\Mailer();
        
        return $mail;
    }

}