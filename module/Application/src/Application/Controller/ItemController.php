<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ItemController extends AbstractActionController
{
    /**
     * The product details page
     */
    public function IndexAction()
    {
        /* @TODO */
        $itemService = $this->getServiceLocator()->get('ItemService');
        $item = $itemService->getRepository()->find(30);
        //var_dump($product);
        $viewModel = new ViewModel();
        $viewModel->setVariable('item' , $item);
        return $viewModel;
    }
    
}

?>