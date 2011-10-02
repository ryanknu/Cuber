<?php

class Activity
{
	private $actions;
	
	public function __construct($num=5)
	{
		$s = DB::zdb()->select()
			->from(array("a" => "activity"))
			->join(array("u" => "users"), "a.user = u.id")
			->order("date DESC")
			->limit(5);
		$actions = DB::zdb()->fetchAll($s);
		$out = array();
		foreach ($actions as $action)
		{
			$out[] = $action["name"] . " " . $action["action"];
		}
		$this->actions = $out;
	}
	
	public function Actions()
	{
		return $this->actions;
	}
}

?>