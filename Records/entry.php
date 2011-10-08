<?php

// **
// * Represents a card in a cube.
class Entry
{
	public static $TABLE = "entries";
	
	private $id;
	private $cube;
	private $card;
	private $active;
	
	public function __construct($cube, $cardId)
	{
		$s = DB::zdb()->select()
				->from(Entry::$TABLE, array("id", "active"))
				->where("cube = ?", $cube->id)
				->where("card = ?", $cardId);
		list($id, $active) = DB::zdb()->fetchRow($s);
		if ( $id )
		{
			$this->cube = $cube;
			$this->card = $cardId;
			$this->active = $active;
			$this->id = $id;
		}
		else
		{
			DB::zdb()->insert(
				Entry::$TABLE,
				array(
					"cube" => $this->id,
					"card" => $cardId,
					"active" => 0
				)
			);
			$this->cube = $cube;
			$this->card = $cardId;
			$this->active = 0;
			$this->id = DB::zdb()->lastInsertId();
		}
	}
	
	public function Add()
	{
		DB::zdb()->update(
			Entry::$TABLE,
			array("active" => 1),
			"id = $id"
		);
		$this->active = 1;
	}
	
	public function Invalidate()
	{
		DB::zdb()->update(
			Entry::$TABLE,
			array("active" => 0),
			"id = $id"
		);
		$this->active = 1;
	}
}

?>