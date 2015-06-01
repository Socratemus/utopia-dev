<?php

/**
 * @author Corneliu Iancu <corneliu.iancu27@gmail.com>
 * @Date Oct 29, 2014
 * @copyright (c) 2014, Corneliu Iancu
 */

namespace UserModule\Service;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\Form\Annotation\AnnotationBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Engine\Service\EntityManagerAwareService;
use UserModule\Entity;
use Engine\Exception as Exception;

class AddressService extends EntityManagerAwareService {

    public function getUserAddressForm($UserAddress) 
    {
        $builder = new AnnotationBuilder();
        $form = $builder->createForm($UserAddress);

        $submitButton = new \Zend\Form\Element\Submit('submit');
        $submitButton->setAttributes(array(
            'size' => '30',
            'value' => 'Save',
            'class' => 'btn btn-primary'
        ));

        $form->add($submitButton);

        foreach ($form->getElements() as $element) {
            if (method_exists($element, 'getProxy')) {
                $proxy = $element->getProxy();
                if (method_exists($proxy, 'setObjectManager')) {
                    $proxy->setObjectManager($this->EntityManager);
                }
            }
        }

        $form->bind($UserAddress);
        
        return $form;
    }
    
    public function saveUserAddress(Entity\UserAddress $UserAddress)
    {
        $auth = $this->getServiceLocator()->get('zfcuser_auth_service');
        $identity = $auth->getIdentity();
        if(!$identity)
        {
            throw new \Exception('User is not logged in.');
        }
        
        $UserAddress->setUser($identity);
        $this->getEntityManager()->persist($UserAddress);
        $this->getEntityManager()->flush();
        return true;
    }
    
    public function getUserAddressById($AddressId)
    {
        $auth = $this->getServiceLocator()->get('zfcuser_auth_service');
        $identity = $auth->getIdentity();
        if(!$identity)
        {
            throw new \Exception('User is not logged in.');
        }
        $address = $this->getEntityManager()->getRepository('\UserModule\Entity\UserAddress')->find($AddressId);
        
        if(!$address)
        {
            throw new Exception\NotFoundException('User address not found');
        }
        if($address->getUser()->getId() !== $identity->getId())
        {
            throw new Exception\AuthorizationException('Unauthorised to edit this address.');
        }
        return $address;
    }
    
    public function removeUserAddress($AddressId)
    {
        $auth = $this->getServiceLocator()->get('zfcuser_auth_service');
        $identity = $auth->getIdentity();
        if(!$identity)
        {
            throw new \Exception('User is not logged in.');
        }
        $address = $this->getEntityManager()->getRepository('\UserModule\Entity\UserAddress')->find($AddressId);
        
        if(!$address)
        {
            throw new Exception\NotFoundException('User address not found');
        }
        if($address->getUser()->getId() !== $identity->getId())
        {
            throw new Exception\AuthorizationException('Unauthorised to edit this address.');
        }
        
        $this->getEntityManager()->remove($address);
        $this->getEntityManager()->flush();
        return TRUE;
    }
    
}
