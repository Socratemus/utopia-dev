<?php

namespace User;

use Zend\Mvc\MvcEvent;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Listen to the bootstrap event
     *
     * @return array
     */
    public function onBootstrap(MvcEvent $e) {

        $zfcServiceEvents = $e->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        $zfcServiceEvents->attach('register', function($e) use ($sm) {
            
        });

        $eventManager = $e->getApplication()->getEventManager();
        $em = $eventManager->getSharedManager();
        $em->attach(
                'ZfcUser\Form\RegisterFilter', 'init', function( $e ) {
            $filter = $e->getTarget();
            // do your form filtering here            
        }
        );

        // custom form fields
        $em->attach(
                'ZfcUser\Form\Register', 'init', function($e) {
            /* @var $form \ZfcUser\Form\Register */
            $form = $e->getTarget();
            $form->add(
                    array(
                        'name' => 'FirstName',
                        'options' => array(
                            'label' => 'Firstname',
                        ),
                        'attributes' => array(
                            'type' => 'text',
                        ),
                    )
            );

            $form->add(
                    array(
                        'name' => 'LastName',
                        'options' => array(
                            'label' => 'Lastname',
                        ),
                        'attributes' => array(
                            'type' => 'text',
                        ),
                    )
            );
        });

        // here's the storage bit
        $zfcServiceEvents = $e->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();
        $zfcServiceEvents->attach('register', function($e) use ($sm) {
            $form = $e->getParam('form');
            /* @var $user \User\Entity\User */
            $user = $e->getParam('user');

            $em = $sm->get('Doctrine\ORM\EntityManager');
            $guestRole = $em->getRepository('User\Entity\Role')->findBy(array('roleId' => 'guest'));
            $user->addRole($guestRole[0]);
        });

        // you can even do stuff after it stores           
        $zfcServiceEvents->attach('register.post', function($e) {
            /* $user = $e->getParam('user'); */
        });
    }

}
