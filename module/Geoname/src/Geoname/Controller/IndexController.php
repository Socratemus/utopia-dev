<?php

namespace Geoname\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {   
        
        $manager = $this->getServiceLocator()->get('GeonameManager');
        
        $counties = $manager->getDistricts();
        
        $manager->getCounties($counties);
        
        $this->getServiceLocator()->get('EntityManager')->flush();
        
        $this->JsonResponse->setVariables($counties);
        
        return $this->JsonResponse;       
    }
    
}