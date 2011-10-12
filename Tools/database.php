<?php

require_once "Zend/Config/Xml.php";
require_once "Zend/Db.php";

class DB
{
	private function __construct() { }
	static function zdb()
	{
		static $db = NULL;
		if ( $db == NULL )
		{
			
			$config = new Zend_Config_Xml(FindFile("Tools/config.xml"));
			$db = Zend_Db::factory($config->default->database);
		}
		return $db;
	}
}

?>