<?php

namespace Mail;
use Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ServiceManager\ServiceLocatorAwareInterface;
    
class Mailer extends \PHPMailer implements ServiceLocatorAwareInterface 
{
    protected $ServiceLocator = null;
    
    public function __construct(){
        parent::__construct();
        
        $this->SMTPAuth = true;
        $this->Host = 'smtp.gmail.com';  // Specify main and backup server
        $this->Username = 'corneliu.iancu27@gmail.com';// SMTP username
        $this->Password = 'Bucuresti91'; //SMTP password
        $this->Port = '465'; ;
        $this->SMTPSecure =  'ssl';
        $this->SetFrom("utopiadev@ide.c9.io");
        $this->FromName = 'utopiadev@ide.c9.io';
        $this->IsSMTP(); // enable SMTP
        // $this->Subject = "Test";
        // $this->Body = "hello";
        $this->addAddress('corneliu.iancu27@gmail.com', 'Corneliu Iancu');
        // if(!$this->Send())
        // {
        // echo "Mailer Error: " . $this->ErrorInfo;
        // }
        // else
        // {
        // echo "Message has been sent";
        // }
        // exit;
    }
    
    public function setServiceLocator(ServiceLocatorInterface $ServiceLocator)
    {
        $this->ServiceLocator = $ServiceLocator;
    }

    public function getServiceLocator()
    {
        return $this->ServiceLocator;
    }    
    
    public function getRender()
    {
        if(!isset($this->Render))
        {
            $this->Render = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
        }
        return $this->Render;
    }
    
    public function BodyHtml($Template, $Options = null)
    {
        $vm = new \Zend\View\Model\ViewModel();
        $vm->setTemplate($Template);
        if(is_array($Options))
        {
            $vm->setVariables($Options);
        }
        $this->IsHTML();
        $this->Body = $this->getRender()->render($vm);
    }
}