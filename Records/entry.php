<?php

// **
// * Represents a card in a cube.
class Entry
{
	public static $TABLE = "entries";
	
	private $id;
	private $cube;
	private $card;
	private $count;
	
	public function __construct($cube, $cardId)
	{
		$s = DB::zdb()->select()
				->from(Entry::$TABLE, array("id", "count"))
				->where("cube = ?", $cube->ID())
				->where("card = ?", $cardId);
		$r = DB::zdb()->fetchRow($s);
		list($id, $count) = array($r["id"], $r["count"]);
		if ( $id )
		{
			$this->cube = $cube;
			$this->card = new Card($cardId);
			$this->count = $count;
			$this->id = $id;
		}
		else
		{
			DB::zdb()->insert(
				Entry::$TABLE,
				array(
					"cube" => $cube->ID(),
					"card" => $cardId
				)
			);
			$this->cube = $cube;
			$this->card = new Card($cardId);
			$this->count = 1;
			$this->id = DB::zdb()->lastInsertId();
		}
	}
	
	public function Add()
	{
		DB::zdb()->update(
			Entry::$TABLE,
			array("count" => ++$this->count),
			"id = " . $this->id
		);
	}
	
	public function Remove()
	{
		if ( $this->count > 0 )
		{	
			DB::zdb()->update(
				Entry::$TABLE,
				array("count" => --$this->count),
				"id = " . $this->id
			);
		}
	}
	
	public function Card()
	{
		return $this->card;
	}
}

?>