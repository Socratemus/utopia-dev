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
        $slug = $this->params()->fromRoute('slug');
        $itemService = $this->getServiceLocator()->get('ItemService');
        $item = $itemService->getBySlug($slug);
        if(!$item){
            throw new \Exception('Item was not found.[' . $slug . ']');
        }
        $item = $item[0];
        $url = $this->url()->fromRoute('application', array('controller' => 'item','action' => 'captcha' , 'lang' => 'en'), array('force_canonical' => true));
        
        $form = new \Application\Form\CommentForm($url);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            //set data post
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                //Valid captcha ...
                echo 'valid captcha';
            } else {
                //Invalid captcha logic ...
                echo 'invalid captcha';
            }
        }
        
        
        $viewModel = new ViewModel();
        $viewModel->setVariable('item' , $item);
        $viewModel->setVariable('form' , $form);
        return $viewModel;
    }
    
    /**
     * Generates captcha image for 
     * the comment section.
     */
    public function captchaAction(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', "image/png");
 
        $id = $this->params('id', false);//var_dump($id);exit;
        //var_dump($id);exit;
        if ($id) {
 
            $image = './data/captcha/' . $id;
 
            if (file_exists($image) !== false) {
                $imagegetcontent = @file_get_contents($image);
 
                $response->setStatusCode(200);
                $response->setContent($imagegetcontent);
 
                if (file_exists($image) == true) {
                    unlink($image);
                }
            }
 
        }
 
        return $response;
    }
    
}

?>