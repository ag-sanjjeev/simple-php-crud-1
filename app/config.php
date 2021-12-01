<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
/************************************
 * Configuration and Logic for Crud *
 ************************************/

/**
 * Database
 */
class DB extends PDO
{
	public $dbcon='', $dsn='', $dbhost='127.0.0.1', $dbname='practicle', $dbuser='admin', $dbpass='ZIr*t8MgNZJ(u7R[';

	function __construct()
	{
		$this->dsn = "mysql:host=$this->dbhost; dbname=$this->dbname; charset=UTF8";

		try {
			$this->dbcon = parent::__construct($this->dsn, $this->dbuser, $this->dbpass);
			$this->setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}

?>