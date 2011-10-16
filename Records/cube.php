<?php

class Cube
{
	public static $TABLE = "cubes";
	private static $CELL_COMPONENT = "cube/cell";
	
	private $id;
	private $revision;
	private $name;
	private $count;
	private $cards;
	private $image;
	private $data;
	
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
			require_once "Records/entry.php";
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
	
	// Here's a fantastic example of why you should always use the
	// getter and setter methods... no matter where you are. Deferred
	// loading.
	public function Cards()
	{
		if ( ! $this->cards )
			$this->GetEntries();
			
		return $this->cards;
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
		$this->image = $cube["image"];
		$this->data = $cube;
		
		$this->count = DB::zdb()->fetchOne(
			"SELECT COUNT(*) FROM entries WHERE cube='" . $this->id . "'"
		);
	}
	
	private function GetEntries()
	{
		require_once "Records/card.php";
		require_once "Records/entry.php";
		$s = Card::GetAllCardsQuery()
			->join(array("e" => Entry::$TABLE), "e.card = ca.id", array())
			->where("e.cube = ?", $this->id);
		$r = DB::zdb()->fetchAll($s);
		$this->cards = array();
		foreach ( $r as $rr )
			$this->cards[] = new Card($rr);
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
			
			require_once "Records/entry.php";
			$entry = new Entry($this, $cardId);
			$entry->Add();
			
			DB::zdb()->commit();
		}
		catch (Exception $e)
		{
			DB::zdb()->rollBack();
			Log::Failure(print_r($e, true));
		}
	}
	
	public function DrawCubeCell()
	{
		$r = new Record(
			array(
				"name" => $this->name,
				"count" => $this->count . " Cards",
				"id" => $this->id,
				"bg_image" =>
					"background-image:url('image.php?cube="
					. $this->id . "');"
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
	
	public function Record() { return new Record($this->data); }
}

?>