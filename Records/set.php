<?php

class Set
{
	protected static $TABLE = "sets";
	
	protected $id;
	private $image;
	private $name;
	private $date;
	private $abbr;
	private $active;
	protected $data;
	
	public static function Create($post=array("name"=>"_new_set"))
	{
		DB::zdb()->insert(Set::$TABLE, $post);
		$s = DB::zdb()->select()
			->from(Set::$TABLE, array("id"))
			->where("name = ?", $post["name"]);
		Log::Activity("created a set");
		return new Set(DB::zdb()->fetchOne($s));
	}
	
	public function __construct($set)
	{
		if ( is_array( $set ) )
		{
			$this->id = $set["id"];
			$this->image = @$set["image"];
			$this->name = $set["name"];
			$this->abbr = $set["abbr"];
			$this->date = $set["date"];
			$this->active = $set["active"];
			$this->data = $set;
		}
		else
		{
			$s = DB::zdb()->select()
				->from(Set::$TABLE)
				->where("id = ?", $set);
			$row = DB::zdb()->fetchRow($s);
			$this->data = $row;
			$this->id = $row["id"];
			$this->image = @$row["image"];
			$this->name = $row["name"];
			$this->abbr = $row["abbr"];
			$this->date = $row["date"];
			$this->active = $row["active"];
		}
		
		unset($this->data['id']);
	}
	
	public function GetCards()
	{
		$s = DB::zdb()->select()
			->from(Card::$TABLE)
			->where("`set` = ?", $this->id);
		$r = DB::zdb()->fetchAll($s);
		$out = array();
		foreach ( $r as $row )
		{
			$out[] = new Card($row["id"]);
		}
		return $out;
	}
	
	// **
	// * Cards
	// * Method
	// * Aliast to match naming convention
	// **
	public function Cards()
	{
		return $this->GetCards();
	}
	
	public static function SetList($includeInactive=false)
	{
		$s = DB::zdb()->select()
			->from(Set::$TABLE);
		if ( !$includeInactive )
			$s->where("active = 1");
		$sets = DB::zdb()->fetchAll($s);
		$out = array();
		foreach ( $sets as $set )
		{
			$out[] = new Set($set);
		}
		return $out;
	}
	
	public function Mutator()
	{
		require_once "Records/Mutators/set.php";
		return new MutableSet($this->id);
	}
	
	public function String() { return $this->name; }
	public function Name() { return $this->name; }
	public function ID() { return $this->id; }
	public function Image() { return $this->image; }
	public function Date() { return $this->image; }
	public function Abbr() { return $this->abbr; }
	public function Active() { return $this->active; }
}

?>