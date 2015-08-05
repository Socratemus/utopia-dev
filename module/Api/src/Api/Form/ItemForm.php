<?php

namespace Api\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter;

class ItemForm extends Form
{
    protected $captcha;
    protected $inputFilter;
    
    public function __construct(/*CaptchaAdapter $captcha*/)
    {
        parent::__construct();
        
        $this->add(array(
            'name' => 'ItemId',
            'options' => array(
              
            ),
            'type'  => 'Text',
            'required'    => false,
            'allow_empty' => true,
        ));
        
        $this->add(array(
            'name' => 'Title',
            'options' => array(
                
            ),
            'type'  => 'Text'
        ));
        
        $this->add(array(
            'name' => 'Slug',
            'options' => array(
                'required' => false
            ),
            'type'  => 'Text'
        ));
        
        $this->add(array(
            'name' => 'Description',
            'options' => array(
                'required' => false
            ),
            'type'  => 'Text'
        ));
        
        $this->add(array(
            'name' => 'Product[Price]',
            'options' => array(
                'required' => false
            ),
            'type'  => 'Text'
        ));
        
        $this->add(array(
            'name' => 'Product[Stock]',
            'options' => array(
                'required' => false
            ),
            'type'  => 'Text'
        ));
        
    }
    
     public function getInputFilter()
     {
        if($this->InputFilter) {
            return $this->InputFilter;
        }
        $inputFilter = new InputFilter(); 
        $factory = new InputFactory(); 
        
        $inputFilter->add($factory->createInput([ 
            'name' => 'ItemId', 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ),
            'required' => false,
            'validators' => array( )
        ]));
        
        $inputFilter->add($factory->createInput([ 
            'name' => 'Title', 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ), 
            'validators' => array( 
               
                array ( 
                    'name' => 'NotEmpty', 
                    'options' => array( 
                        'messages' => array( 
                            'isEmpty' => 'Title is required', 
                        ) 
                    ), 
                ), 
                array ( 
                    'name' => 'StringLength', 
                    'options' => array( 
                        'min' => 3,
                        'max' => 50,
                        // 'messages' => array( 
                        //     'stringLengthTooShort' => 'Title min length is 20',
                        //     'stringLengthTooLong' => 'Title max length is 30'
                        // ) 
                    ), 
                ), 
            ), 
        ]));
        
        $inputFilter->add($factory->createInput([ 
            'name' => 'Slug', 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            )
        ]));
        
        $inputFilter->add($factory->createInput([ 
            'name' => 'Description', 
            'filters' => array( 
                // array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            )
        ]));
        
        $productFilter = new InputFilter();
        
        $productFilter->add($factory->createInput(array(
            'name'     => 'Price',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
               
            ),
        )));
        
        $productFilter->add($factory->createInput(array(
            'name'     => 'Stock',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
               
            ),
        )));
            
        $inputFilter->add($productFilter , 'Product');
        
        $this->InputFilter = $inputFilter;
        return $this->InputFilter;
     }
    
}