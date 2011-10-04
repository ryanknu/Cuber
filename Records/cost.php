<?php

class Cost
{
	protected $id;
	protected $data;
	private static $TABLE = "costs";
	private static $FIELDS = array(
			"RR" => "red",			"PR" => "phy_red",
			"GG" => "green",		"PG" => "phy_green",
			"UU" => "blue",			"PU" => "phy_blue",
			"WW" => "white",		"PW" => "phy_white",
			"BB" => "black", 		"PB" => "phy_black",
			"RG" => "red_green",	"RU" => "red_blue",
			"RW" => "red_white",	"RB" => "red_black",
			"GU" => "green_blue",	"GW" => "green_white",
			"GB" => "green_black",	"UW" => "blue_white",
			"UB" => "blue_black",	"XX" => "x",
			"BW" => "black_white",  "2R" => "2_red",
			"2G" => "2_green",		"2B" => "2_black",
			"2U" => "2_blue",		"2W" => "2_white"
		);
	
	public function __construct($id)
	{
		$s = DB::zdb()->select()
			->from(Cost::$TABLE)
			->where("id = ?", $id);
		$this->data = DB::zdb()->fetchRow($s);
	}
	
	// string format: ccXXYYZZ...
	// cc is colorless cost. The other format is NONE for no cost.
	public static function CostFromString($str)
	{
		$match = array();
		$cond = "(1=1) ";
		
		if ( $str == "NONE" || strlen($str) < 2 )
		{
			$match["no_cost"] = 1;
		}
		else
		{
			$match["colorless"] = $str{0} . $str{1};
			$cond .= " AND colorless = " . $match["colorless"];
			$match["cmc"] = $match["colorless"];
			for ( $i = 2; $i < strlen($str); $i += 2 )
			{
				$buf = $str{$i} . $str{$i+1};
				if ( $buf <> "XX" )
					++$match["cmc"];
				if ( array_key_exists( $buf, $match ) )
				{
					++$match[$buf];
				}
				else
				{
					$match[$buf] = 1;
				}
			}
		}
		if ( !isset( $match["no_cost"] ) )
			$cond .= " AND no_cost IS NULL ";
		foreach ( Cost::$FIELDS as $key => $val )
			if ( !isset( $match[$key] ) )
				$cond .= " AND $val IS NULL ";
			else
			{
				$cond .= ( " AND $val = " . $match[$key] . " ");
				$match[$val] = $match[$key];
				unset($match[$key]);
			}
		
		// Search the DB for it
		$s = DB::zdb()->select()
			->from(Cost::$TABLE, array("id"))
			->where( $cond );
		$id = DB::zdb()->fetchOne($s);
		if ( $id )
		{
			return new Cost($id);
		}
		else
		{
			DB::zdb()->insert(Cost::$TABLE, $match);
			return Cost::CostFromString($str);
		}
	}
	
	public function EditRecord()
	{
		return new Record($this->data);
	}
	
	public function PrettyCost()
	{
		static $order = array(
			"XX", "PW", "PU", "PB", "PR", "PG", "UW", "BW",
			"2W", "WW", "UB", "RU", "2U", "UU", "RB", "GB",
			"2B", "BB", "RG", "RW", "2R", "RR", "GW", "GU", 
			"2G", "GG"
		);
			
		static $pngs = array("phy_red","phy_white","phy_blue","phy_green","phy_black");
		$r = "(" . $this->data["colorless"] . ")";
		
		foreach ($order as $col)
		{
			$key = Cost::$FIELDS[$col];
			$val = $this->data[$key];
			if ( $val )
			{
				for ( $i = 0; $i < $val; $i++ )
				{
					$ext = ".gif";
					if ( in_array( $key, $pngs ) )
						$ext = ".png";
					$r .= "<img src=\"Views/img/mana_symbols/$key$ext\" />";
				}
			}
		}
		return $r;
	}
}

?>