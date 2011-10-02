<?php

require_once "Records/user.php";

class Auth
{
	// logged in user
	private $user;
	
	// singleton
	private function __construct()
	{
		$this->user = NULL;
	}
	
	public function Obj()
	{
		static $auth;
		if ( !$auth )
		{
			$auth = new Auth();
			$auth->Reconcile();
		}
		return $auth;
	}
	
	// Check if a user is already logged in.
	private function Reconcile()
	{
		@session_start();
		if ( isset( $_SESSION["user"] ) )
		{
			if ( App::Obj()->UseFacebook() )
			{
				$fb = App::Obj()->FacebookUser();
				if ( ! $fb )
				{
					$fb = new Facebook( App::Obj()->FacebookSettings() );
					$loc = $fb->getLoginUrl();
					header("Location: $loc");
				}
			}
			$this->user = new User($_SESSION["user"]);
		}
	}
	
	// boolean, if the user is authenticated or not.
	public function Authenticated()
	{
		return $this->user !== NULL;
	}
	
	// boolean, if the user is at or above a level
	public function CanAccess($level)
	{
		return $this->user !== NULL && $level <= $this->user->Level();
	}
	
	public function User()
	{
		return $this->user;
	}
	
	// Log In
	public function LogIn($user=NULL, $pass=NULL)
	{
		@session_start();
		
		$u = false;
		
		if ( App::Obj()->UseFacebook() )
		{
			require_once "Tools/Facebook/facebook.php";
			$fb = new Facebook( App::Obj()->FacebookSettings() );
			$user = $fb->getUser();
			if ( $user )
			{
				$data = $fb->api("/me");
				$fbId = $data["id"];
				$s = DB::zdb()->select()
					->from("users", array("id"))
					->where("facebook = ?", $fbId);
				$u = DB::zdb()->fetchOne($s);
			}
		}
		else
		{	
			$pass = md5($pass);
			$user = mysql_escape_string($user);
			
			$s = DB::zdb()->select()
				->from("users", array("id"))
				->where("user = ?", $user)
				->where("pass = ?", $pass);
			$u = DB::zdb()->fetchOne($s);
		}
		
		if ( $u )
		{
			$this->user = new User($u);
			$_SESSION["user"] = $u;
			Log::Activity("Logged in");
		}
	}
	
	public function LogOut()
	{
		@session_start();
		Log::Activity("Logged out");
		session_destroy();
	}
}

?>