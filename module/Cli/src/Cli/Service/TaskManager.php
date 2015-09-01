<?php

namespace Cli\Service;
/**
 *
 *
 */
class TaskManager extends \Application\Service\ModelService {
	
	/**
	 *
	 */
	public function task(){
		return __METHOD__;
	}
	
	/**
	 *
	 */
	public function task_resetDatabase(){

		try
		{
			$className = '\Application\Entity\AppLog';
			$em = $this->getEntityManager();
			$cmd = $em->getClassMetadata($className);
			// $connection = $em->getConnection();
			// $dbPlatform = $connection->getDatabasePlatform();
			// $connection->query('SET FOREIGN_KEY_CHECKS=0');
			// $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
			// $connection->executeUpdate($q);
			// $connection->query('SET FOREIGN_KEY_CHECKS=1');
			return 'table was truncated.';
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}

		return __METHOD__;
	}

}