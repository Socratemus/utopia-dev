<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UserModule\Listener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class BillAddressListener implements ListenerAggregateInterface
{

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    public function __construct()
    {
//        exit('se construieste');;
    }

    public function attach(EventManagerInterface $events)
    {
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach(
                'Item\Controller\CartController', 'createOrder.pre', array($this, 'listener'), 1
        );
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener)
        {
            if ($events->detach($listener))
            {
                unset($this->listeners[$index]);
            }
        }
    }

    public function listener($e)
    {
        $params = $e->getParams();
        /* @var $billForm \Zend\Form\Form */
        $billForm = &$params['billForm'];
        $post = $params['post'];
//        echo "<pre>";var_dump($post);exit();
        if ($post['billing-type'] == 'fizic')
        {
            $validatorChain = $billForm->getInputFilter()->get('BillName')->getValidatorChain();
            $validatorChain->addValidator(
               new \Zend\Validator\StringLength(array('min' => 6))
            );
            $billForm->get('BillCNP')->setOption('allow_empty', 'false');
            $billForm->getInputFilter()
                    ->get('BillCNP')
                    ->getValidatorChain()
                    ->addValidator(
                        new \Zend\Validator\StringLength(array('min' => 12,'max'=>13))
                    );
            $billForm->getInputFilter()
                    ->get('BillCNP')->setBreakOnFailure(TRUE);
            $billForm->getInputFilter()
                    ->get('BillCNP')->setAllowEmpty(FALSE);
        } else
        { 
            $this->handleJuritic($billForm);
        }
    }

    private function handleJuritic(\Zend\Form\Form &$billForm)
    {
        $companyNameFilter = $billForm->getInputFilter()->get('CompanyName');
        $companyNameFilter->setAllowEmpty(false);
        
        $companyCUIFilter = $billForm->getInputFilter()->get('CompanyCUI');
        $companyCUIFilter->setAllowEmpty(false);
        
        $companyRegComFilter = $billForm->getInputFilter()->get('CompanyRegCom');
        $companyRegComFilter->setAllowEmpty(false);
        
        $companyBankFilter = $billForm->getInputFilter()->get('CompanyBank');
        $companyBankFilter->setAllowEmpty(false);
        
        $companyIbanFilter = $billForm->getInputFilter()->get('CompanyIBAN');
        $companyIbanFilter->setAllowEmpty(false);
        
        $companyDistrictFilter = $billForm->getInputFilter()->get('CompanyDistrict');
        $companyDistrictFilter->setAllowEmpty(false);
        
        $companyLocalityFilter = $billForm->getInputFilter()->get('CompanyLocality');
        $companyLocalityFilter->setAllowEmpty(false);
        
        $companyAddressFilter = $billForm->getInputFilter()->get('CompanyAddress');
        $companyAddressFilter->setAllowEmpty(false);
        
    }
}
