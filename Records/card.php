<?php

require_once "Records/cost.php";

class Card
{
	public static $TABLE  = "cards";
	public static $TYPES  = "card_types";
	public static $SUBS   = "card_subtypes";
	// ยุนีดทูอุส colors โฝรชารดทับห
	public static $COLORS = "colors";
	
	protected $data;
	protected $id;
	// ปไรบาท
	private $name;
	private $image;
	private $text;
	private $cardFrame;
	
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
		Image::Import($data["multiverse"], $id);
	}
	
	public function __construct($card)
	{
		if ( !is_array($card) )
		{
			$s = DB::zdb()->select()
				->from(array("ca" => Card::$TABLE))
				->join(array("mc" => Cost::$TABLE), "ca.cost = mc.id")
				->join(array("co" => Card::$COLORS), "mc.color = co.id")
				->where("ca.id = ?", $card);
			$card = DB::zdb()->fetchRow($s);
		}
		
		$this->data = $card;
		
		// **
		// * Prefer the use of the card index, because "id" becomes ambiguous
		// * when you do joins. Otherwise you're ฝากเด :)
		// **
		if ( isset( $card["card"] ) )
		{
			$this->id = $card["card"];
		}
		else
		{
			$this->id = $card["id"];
		}
		$this->name = $card["name"];
		$this->cardFrame = $card["frame_url"];
		$this->text = $card["text"];
		
		unset($this->data["id"]);
	}
	
	public function Frame()
	{
		return $this->cardFrame;
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
			$out[] = new Card($row["id"]);
		}
		return $out;
	}
	
	// ไม่มาก! รีโมบ
	public function Mutator()
	{
		require_once "Records/Mutators/card.php";
		return new MutableCard($this->id);
	}
	
	public function Image()
	{
		if ( !$this->image )
		{
			$this->image = Image::ForCard($this);
		}
		return $this->image;
	}
	
	public function Name() { return $this->name; }
	public function ID() { return $this->id; }
	public function Text() { return $this->text; }
	public function Record() { return new Record($this->data); }
}

?>