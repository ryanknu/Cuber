<?php

require_once "Zend/Config/Xml.php";
require_once "Zend/Db.php";

function FindFile($fn)
{
	if ( !file_exists( $fn ) )
	{
		$ip = explode(":", ini_get("include_path"));
		foreach ( $ip as $p )
		{
			if ( file_exists( "$p/$fn" ) )
			{
				$fn = "$p/$fn";
				break;
			}
		}
	}
	return $fn;
}

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