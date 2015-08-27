<?php

namespace Cli\Entity;

interface CommandInterface
{

    public function getGUID();

    public function setGUID($Key);

    public function getCacheKey();

    public function setCacheKey($CacheKey);

    public function getClass();

    public function setClass($Class);

    public function getMethod();

    public function setMethod($Method);
    
    public function getParams();

    public function setParams(array $Params);

    public function addParam($Param);

    public function getPID();

    public function setPID($PID);

    public function getStatus();

    public function setStatus($Status);

    /*public function getMessage();

    public function setMessage($Message);

    public function getAction();

    public function setAction($Action);*/
}