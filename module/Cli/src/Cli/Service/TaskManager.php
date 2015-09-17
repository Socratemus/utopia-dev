<?php

namespace Cli\Service;
/**
 *
 *
 */
class TaskManager extends \Application\Service\ModelService {
	
	/**
	 * Reset database task
	 */
	public function TskResetDatabase()
	{
		for($i = 0 ; $i < 10 ; $i++){
			echo ' Looping in task reset database ::' . $i . "\n";
			$this->getLogger()->info('task reset database loop ' . $i );
			sleep(2);
		}
		
		return 'reset database task done';	
	}
	
	/**
	 * Removes all product images from the server
	 */
	public function TskClearProductImages(){
		echo __METHOD__ . "\n";
		echo 'STARTS SLEEPING';
		sleep(10);
		echo 'END CLEAR PRODUCTS AFTER 100 s SLEEP';
		return __METHOD__;
	}
	
	/**
	 * Removes all categories images from the server
	 */
	public function TskClearCategoriesImages(){
		for($i = 0 ; $i < 100000 ; $i++){
			$this->getLogger()->info('STRESS TEST THE SERVER');
			echo date('Y-m-d H:i:s') . ' :: ' . microtime() . 'STRESSING THE SERVER' . "\n";
		}
		
		return __METHOD__;
	}

}