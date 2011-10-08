<?php

class Card
{
	public static $TABLE = "cards";
	
	protected $data;
	protected $id;
	// private fields!
	private $name;
	
	public function __construct($card)
	{
		if ( is_array($card) )
		{
			// more fields!
			$this->data = $card;
			$this->id = $card["id"];
			$this->name = $card["name"];
			
			unset($this->data["id"]);
		}
		else
		{
			$s = DB::zdb()->select()
				->from(Card::$TABLE)
				->where("id = ?", $card);
			$row = DB::zdb()->fetchRow($s);
			$this->data = $row;
			$this->id = $row["id"];
			$this->name = $row["name"];
			
			unset($this->data["id"]);
		}
	}
	
	public static function CardList($set)
	{
		$s = DB::zdb()->select()
			->from(Card::$TABLE)
			->where("`set` = ?", $set);
		$rows = DB::zdb()->fetchAll($s);
		$out = array();
		foreach ($rows as $row)
		{
			$out[] = new Card($row);
		}
		return $out;
	}
	
	public function Mutator()
	{
		require_once "Records/Mutators/card.php";
		return new MutableCard($this->id);
	}
	
	public function Name() { return $this->name; }
	public function ID() { return $this->id; }
}

?>