<?php

namespace Application\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController
{
    /**
     * The category page, 
     * listing all products from a category
     */
    public function IndexAction()
    {
        try
        {
            $slug = $this->params()->fromRoute('slug');
        
            $ctgsrv = $this->getServiceLocator()->get('CategoryService');
        
            $cat = $ctgsrv->getBySlug($slug);
            if(!$cat)
                throw new \Exception('The category was not found.[' . $slug . ']');
            $cat = $cat[0];
            $viewModel = new ViewModel();
            $viewModel->setVariables(
                array(
                     'category' => $cat
                )    
            );
            return $viewModel;
        } 
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            //Redirect home;
            return $this->redirect()->toRoute('home');
        }
        
        
        /* @TODO */
    }
    
}

?>