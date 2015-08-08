<?php

namespace Application\Form;

use Zend\Form\Form,
    Zend\Form\Element\Captcha,
    Zend\Captcha\Image as CaptchaImage;
    
class CommentForm extends Form
{
    public function __construct($urlcaptcha = null)
    {
        parent::__construct('Comment Form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'col-md-12 extended');
        
        $this->add(array(
            'name' => 'Email',
            'options' => array(
                'label' => 'Enter your email',
            ),
            'attributes' => array(
                'class' => 'form-control ',
                'placeholder' => 'Enter your email'
            ),
            'type'  => 'Email'
        ));
        
        $this->add(array(
            'name' => 'Firstname',
            'options' => array(
                'label' => 'Provide firstname',
            ),
            'attributes' => array(
                'class' => 'form-control ',
                'placeholder' => 'Enter your firstname'
            ),
            'type'  => 'Text'
        ));
        
        $this->add(array(
            'name' => 'Lastname',
            'options' => array(
                'label' => 'Provide lastname',
               
            ),
            'attributes' => array(
                'class' => 'form-control',
                 'placeholder' => 'Enter your lastname'
            ),
            'type'  => 'Text'
        ));
        
        /***************************/
        /* Captch element */
        $dirdata = './data';
        $captchaImage = new CaptchaImage(  array(
                'font' => $dirdata . '/fonts/arial.ttf',
                'width' => 250,
                'height' => 100,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3)
        );
        $captchaImage->setImgDir($dirdata.'/captcha');
        $captchaImage->setImgUrl($urlcaptcha);
 
        //add captcha element...
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                // 'label' => 'Please verify you are human',
                'captcha' => $captchaImage,
            ),
            'attributes' => array(
                'class' => 'form-control mt5 captcha-verify',
                'placeholder' => 'Enter captcha in here'
            )
        ));
 
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Comment'
            ),
        ));
    }
 
}