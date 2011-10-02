<?php

// Represents a login invite
class Invite
{
	private $code;
	private $owner;
	private $available;
	private $redeemer;
	private static $TABLE = "invites";
	
	public static function GenerateCode()
	{
		$str = "";
		while( strlen( $str ) < 19 )
		{
			$str .= chr(rand(ord('A'), ord('Z')));
			if ( strlen($str) % 5 == 0 )
				$str .= "-";
		}
		return $str;
	}
	
	public static function Create($owner)
	{
		if ( !Auth::Obj()->Authenticated() )
			throw new Exception("Must be logged in");
		$code = Invite::GenerateCode();
		$data = array("code" => $code, "owner" => Auth::Obj()->User()->ID());
		DB::zdb()->insert(Invite::$TABLE, $data);
		Log::Activity("generated invitation code " . $code);
		return new Invite($code);
	}
	
	public function __construct($code)
	{
		$s = DB::zdb()->select()
			->from(Invite::$TABLE)
			->where("code = ?", $code);
		$data = DB::zdb()->fetchRow($s);
		if ( !$data )
			throw new Exception("Invalid invitation code");
		$this->code = $data["code"];
		$this->owner = $data["owner"];
		$this->available = $data["available"];
		if ( !$this->available )
			$this->redeemer = $data["redeemed_by"];
	}
	
	public function Available()
	{
		return $this->available;
	}
	
	public function Reconcile()
	{
		DB::zdb()->update(Invite::$TABLE,
			array("redeemed_by" => Auth::Obj()->User()->ID(),
			      "available" => 0), "code = '{$this->code}'");
		Log::Activity("reconciled invitation code " . $this->code);
	}
	
	public function Code()
	{
		return $this->code;
	}
	
	public static function InviteList($user)
	{
		
	}
}

?>