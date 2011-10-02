<?php

require_once "Records/auth.php";

class User
{
	private $user;
	private $name;
	private $level;
	private $id;
	private $data;
	
	// Create User
	public static function Create($post=NULL)
	{
		$invite = new Invite($post["code"]);
		if ( !$invite->Available() )
		{
			throw new Exception("Invite has already been redeemed.");
		}
		
		if ( App::Obj()->UseFacebook() )
		{
			require_once "Tools/Facebook/facebook.php";
			$fb = new Facebook( App::Obj()->FacebookSettings() );
			$user = $fb->getUser();
			if ( $user )
			{
				$data = $fb->api("/me");
				$fbId = $data["id"];
				if ( ! $fbId )
					throw new Exception("FB ID invalid");
				$in = array("facebook" => $fbId);
				DB::zdb()->insert("users", $in);
				Auth::Obj()->LogIn();
			}
		}
		else
		{	
			unset($post["pass2"]);
			unset($post["code"]);
			$pass = $post["pass"];
			$post["pass"] = md5($post["pass"]);
			$n = DB::zdb()->insert("users", $post);
			Auth::Obj()->LogIn($post["user"], $pass);
		}
		
		if ( Auth::Obj()->Authenticated() )
		{
			$invite->Reconcile();
			Log::Activity("created their user account");
		}
	}
	
	public function __construct($user)
	{
		$s = DB::zdb()->select()
			->from("users")
			->where("id = ?", $user);
		$data = DB::zdb()->fetchRow($s);
		if ( !$data["id"] )
		{
			throw new Exception("Attempted to instantiate a user that doesn't exist");
		}
		$this->id    = $data["id"];
		$this->user  = $data["user"];
		$this->name  = $data["name"];
		$this->level = $data["level"];
		$this->local = $data["local"];
		if ( App::Obj()->UseFacebook() )
		{
			$this->data = App::Obj()->FacebookUser();
		}
	}
	
	public function User() { return $this->user; }
	public function Name() { return $this->name; }
	public function Level() { return $this->level; }
	public function ID() { return $this->id; }
	public function Local() { return $this->local; }
	public function Data() { return $this->data; }
}

?>