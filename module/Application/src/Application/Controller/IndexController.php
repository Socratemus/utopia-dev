<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Entity\Category;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $ctSrv = $this->getServiceLocator()->get('CategoryService');
        $cts = $ctSrv->getRootCategories();
        
        $vm = new ViewModel();
        $vm->setVariables(array(
            'categories' => $cts
        ));
       
        return $vm;
    }
    
    public function redirectAction(){
        
        exit('redirecting...');
    }
}
