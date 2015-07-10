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
        
        $catsKey = 'categorizKEY';

        $cache = $this->getServiceLocator()->get('Zend\Cache\Storage\Filesystem');

        // if($cache->hasItem($catsKey)){
        //     $cts = $cache->getItem($catsKey);
        //     var_dump($cts);
        //     exit('o are');
        // } else {
        //     //var_dump($cacheService);exit();
        //     $cache->setItem($catsKey , $cts);
        //     exit('nu o are');
        // }

        // exit('doing it!');

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
