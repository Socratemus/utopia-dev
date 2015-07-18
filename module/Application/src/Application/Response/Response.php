<?php

namespace Application\Response;

class Response
{
    /*
     * result status 0-Fail 1-Success 2-Error to be shown to user
     */
    protected $Status;

    /*
     * redirect from page default = false
     */
    protected $Redirect = false;

    /*
     * result message;
     */
    protected $Message;

    /*
     * no of entities that were succeded transfered
     */
    protected $Succeded = 0;

    /*
     * no of entities that failed
     */
    protected $Failed = 0;

    /*
     * returned object
     */
    protected $Object;

    public function __construct($Status, $Message='', $Object = null)
    {
        $this->setStatus($Status);
        $this->setMessage($Message);
        if(isset($Object))
        {
            $this->setObject($Object);
        }
        return $this;
    }

    public function getStatus()
    {
        return $this->Status;
    }

    public function setStatus($Status)
    {
        //if status is critical then set redirect true
        if($Status == 2)
        {
            $this->setRedirect(true);
        }
        $this->Status = $Status;
        return $this;
    }

    public function getRedirect()
    {
        return $this->Redirect;
    }

    public function setRedirect($Redirect)
    {
        $this->Redirect = $Redirect;
        return $this;
    }

    public function getMessage()
    {
        return $this->Message;
    }

    public function setMessage($Message)
    {
        $this->Message = $Message;
        return $this;
    }

    public function getSucceded()
    {
        return $this->Succeded;
    }

    public function setSucceded($Succeded)
    {
        $this->Succeded = $Succeded;
        return $this;
    }

    public function getFailed()
    {
        return $this->Failed;
    }

    public function setFailed($Failed)
    {
        $this->Failed = $Failed;
        return $this;
    }

    public function getObject()
    {
        return $this->Object;
    }

    public function setObject($Object)
    {
        $this->Object = $Object;
        return $this;
    }

    public function expose()
    {
        return get_object_vars($this);
    }

}