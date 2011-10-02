<?php

class App
{
	private $useFB;
	private $fbSettings;
	private $offline;
	
		// singleton
	private function __construct()
	{
		$s = DB::zdb()->select()
			->from("app_settings");
		$row = DB::zdb()->fetchRow($s);
		$this->useFB = $row["use_facebook"];
		$this->offline = $row["offline_mode"];
		
		$this->fbSettings = array(
			"appId"  => $row["app_id"],
			"secret" => $row["app_secret"]
		);
	}
	
	public function Obj()
	{
		static $app;
		if ( !$app )
		{
			$app = new App();
		}
		return $app;
	}
	
	public function FacebookUser()
	{
		require_once "Tools/Facebook/facebook.php";
		$fb = new Facebook($this->fbSettings);
		$u = $fb->getUser();
		if ( $u )
		{
			return $fb->api("/me");
		}
		else
		{
			return false;
		}
	}
	
	public function UseFacebook() { return $this->useFB; }
	public function FacebookSettings() { return $this->fbSettings; }
	public function IsOffline() { return $this->offline; }
	
}

?>