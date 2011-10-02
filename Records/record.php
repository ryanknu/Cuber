<?php

class Record
{
	private $data;
	
	public function __construct($array)
	{
		$this->data = $array;
	}
	
	public function Get($key) { return $this->data[$key]; }
}

?>