<?php

require_once "Records/cost.php";

class Card
{
	public static $TABLE = "cards";
	public static $TYPES = "card_types";
	public static $SUBS  = "card_subtypes";
	
	protected $data;
	protected $id;
	// private fields!
	private $name;
	
	public static function Create($data)
	{
		$in = array();
		$cost = Cost::CostFromString($data["Mana Cost"]);
		$in["cost"] = $cost->ID();
		$in["rarity"] = strtoupper($data["Rarity"]);
		$map = array(
			"name" => "Card Name",
			"power" => "P",
			"toughness" => "T",
			"text" => "Card Text",
			"flavor" => "Flavor Text",
			"loyalty" => "Loyalty",
			"artist" => "Artist",
			"multiverse" => "multiverse",
			"number" => "Card #",
			"set" => "set"
		);
		foreach( $map as $key => $val )
		{
			if ( isset( $data[$val] ) )
				$in[$key] = $data[$val];
		}
		DB::zdb()->insert(Card::$TABLE, $in);
		$id = DB::zdb()->lastInsertId();
		foreach( $data["Types"] as $type )
		{
			DB::zdb()->insert(Card::$TYPES,
				array("card" => $id, "type" => $type)
			);
		}
		foreach( $data["Subtypes"] as $type )
		{
			DB::zdb()->insert(Card::$SUBS,
				array("card" => $id, "subtype" => $type)
			);
		}
	}
	
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