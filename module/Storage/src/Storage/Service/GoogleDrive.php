<?php

namespace Storage\Service;
use Application\Service\ModelService as Service;

class GoogleDrive extends Service {

	public function __construct()
	{
		parent::__construct();

	}	

	public function init()
	{

		exit('on init.');
	}

	public function connect()
	{

		exit('connecting');
	}

}