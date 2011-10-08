<?php

class Cube
{
	public static $TABLE = "cubes";
	private static $CELL_COMPONENT = "cube_cell";
	
	private $id;
	private $revision;
	private $name;
	private $count;
	private $cards;
	
	public static function Create()
	{
		try
		{
			DB::zdb()->beginTransaction();
			// Create empty cube.
			DB::zdb()->insert(
				Cube::$TABLE,
				array(
					"name" => "New Cube",
					"revision" => 1,
					"owner" => Auth::Obj()->User()->ID()
				)
			);
			// Insert CDP for free.
			DB::zdb()->insert(
				Entry::$TABLE,
				array(
					"card" => 1,
					"cube" => DB::zdb()->lastInsertId()
				)
			);
			DB::zdb()->commit();
		}
		catch ( Exception $e )
		{
			DB::zdb()->rollBack();
			Log::Failure(print_r($e, true));
		}
	}
	
	public function __construct($cube)
	{
		if ( !is_array($cube) )
		{
			$s = DB::zdb()->select()
				->from(Cube::$TABLE)
				->where("id = ?", $cube);
			$cube = DB::zdb()->fetchRow($s);
		}
		$this->id = $cube["id"];
		$this->revision = $cube["revision"];
		$this->name = $cube["name"];
		
		$this->GetEntries();
	}
	
	private function GetEntries()
	{
		require_once "Records/card.php";
		$s = DB::zdb()->select()
			->from(array("e" => Entry::$TABLE))
			->join(array("c" => Card::$TABLE), "e.card = c.id")
			->where("e.cube = ?", $this->id);
		$r = DB::zdb()->fetchAll($s);
		$this->cards = array();
		foreach ( $r as $rr )
			$this->cards[] = new Card($rr);
		$this->count = count($this->cards);
	}
	
	public function CubesForUser($user)
	{
		$s = DB::zdb()->select()
			->from(Cube::$TABLE)
			->where("owner = ?", $user->ID());
		$r = DB::zdb()->fetchAll($s);
		$out = array();
		foreach ($r as $rr)
			$out[] = new Cube($rr);
		return $out;
	}
	
	public function AddCardToCube($cardId)
	{
		try
		{
			DB::zdb()->beginTransaction();
			
			$entry = new Entry($this, $cardId);
			$entry->Add();
			
			DB::zdb()->commit();
		}
		catch (Exception $e)
		{
			DB::zdb()->rollBack()
			Log::Failure(print_r($e, true));
		}
	}
	
	public function DrawCubeCell()
	{
		$r = new Record(
			array(
				"name" => $this->name,
				"count" => $this->count . " Cards",
				"id" => $this->id
			)
		);
		View::Obj()->Component(Cube::$CELL_COMPONENT, $r);
	}
	
	public static function DrawAddCubeCell()
	{
		$r = new Record(
			array(
				"name" => "Add Cube",
				"count" => "Click here to make a new cube.",
				"id" => "new"
			)
		);
		View::Obj()->Component(Cube::$CELL_COMPONENT, $r);
	}
	
	public function Name()
	{
		return $this->name;
	}
	
	public function ID()
	{
		return $this->id;
	}
}

?>