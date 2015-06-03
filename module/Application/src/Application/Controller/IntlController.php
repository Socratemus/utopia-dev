<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IntlController extends AbstractActionController
{
    public function IndexAction(){
        exit('fu!');
        return $this->redirect()->toRoute('home', array('lang' => 'ro'));
        exit('hello');
    }
    
    public function changeLang(){
        /*  */
    }
}

?>