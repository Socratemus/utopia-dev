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
use Engine\Service\EntityManagerAwareInterface;

class UserService implements EntityManagerAwareInterface {

    /**
     * @var type \Doctrine\ORM\EntityManager
     */
    protected $EntityManager;

    public function getServiceLocator() {
        ;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $ServiceLocator) {
        $this->setEntityManager($ServiceLocator->get('doctrine.entitymanager.orm_default'));
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $EntityManager) {
        $this->EntityManager = $EntityManager;
    }

    public function fetchAllUsers() {
        return $this->EntityManager->getRepository('UserModule\Entity\User')->findAll();
    }

    public function getUserByPk($Id) {
        $user = $this->EntityManager->getRepository('UserModule\Entity\User')->find($Id);
        if (!$user) {
            return false;
        } else {
            return $user;
        }
    }

    public function getUserForm($user) {
        
        $builder = new AnnotationBuilder();
        $form = $builder->createForm($user);

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

        $form->bind($user);
        
        $validator = new \DoctrineModule\Validator\UniqueObject(array(
            'object_repository' => $this->EntityManager->getRepository('UserModule\Entity\User'),
            'object_manager' => $this->EntityManager,
            'fields' => 'email',
            'messageTemplates' => array(
                'objectNotUnique' => 'A user with this email already exists !'
            ),
        ));

        $form->getInputFilter()->get('email')->getValidatorChain()->addValidator($validator);

        return $form;
    }
    
    public function getAddressesForm($BillAddress, $ShippAddress)
    {
        $builder = new AnnotationBuilder();
        $form = $builder->createForm($BillAddress);
        //$formShipp = $builder->createForm($ShippAddress);
        
        foreach ($form->getElements() as $element) {
            if (method_exists($element, 'getProxy')) {
                $proxy = $element->getProxy();
                if (method_exists($proxy, 'setObjectManager')) {
                    $proxy->setObjectManager($this->EntityManager);
                }
            }
        }
//        foreach ($formShipp->getElements() as $element) {
//            if (method_exists($element, 'getProxy')) {
//                $proxy = $element->getProxy();
//                if (method_exists($proxy, 'setObjectManager')) {
//                    $proxy->setObjectManager($this->EntityManager);
//                }
//            }
//            $form->add($element);
//        }
        
        $form->bind($BillAddress);
        //$form->bind($ShippAddress);
        return $form;
    }

    public function saveUser(\UserModule\Entity\User $User, $Options = array()) {
        $newRole = false;
        if (isset($Options['role']) && !empty($Options['role'])) {
            $roleId = $Options['role'][0];
            $newRole = $this->EntityManager->getRepository('\UserModule\Entity\Role')->find($roleId);
        }

        if ($newRole) {
            $oldRoles = $User->getRoles();
            $User->removeRole($oldRoles[0]->getId());
            $User->addRole($newRole);
        }
        //And then add the new role :)

        $this->EntityManager->persist($User);
        $this->EntityManager->flush();

        return true;
    }

//    public function getUserAddresses($User)
    
}
