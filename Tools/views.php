<?php

require_once "Records/record.php";

class View
{
	private $title;
	private $local;
	// model for use with components
	private $model;
	
	public static function Obj()
	{
		static $obj;
		if ( !$obj )
		{
			$local = "en";
			if ( Auth::Obj()->Authenticated() )
			{
				$local = Auth::Obj()->User()->Local();
			}
			$obj = new View($local);
		}
		return $obj;
	}

	private function __construct($local)
	{
		$this->local = $local;
		$this->model = NULL;
		$this->title = "Cuber by Ryan Knuesel";
	}

	public function Title($title)
	{
		$this->title = $title;
	}
	
	// **
	// * IncFile
	// * Includes a view for viewing. $parse can be either a Record
	// * object or an array, either is acceptable.
	public function IncFile($folder, $file, $parse=array())
	{
		$view = is_array($parse)?
			new Record($parse) : $parse;
			
		$local = $this->local;
		$title = $this->title;
		
		$str = "$folder/$local/$file.php";
		if ( !file_exists( $str ) )
			$str = "$folder/en/$file.php";
		include $str;
	}

	public function MainView($view, $parse=array())
	{
		$parse['view'] = $view;
		$this->IncFile("Views", "content", $parse);
	}
	
	public function View($view, $parse=array())
	{
		$this->IncFile("Views", $view, $parse);
	}
	
	public function UseDataModel($model)
	{
		$this->model = $model;
	}
	
	public function Component($view, $parse=array())
	{
		if ( $this->model == NULL )
		{
			if ( file_exists( "Records/$view.php" ) )
				include_once "Records/$view.php";
		}
		else
		{
			include_once "Records/{$this->model}.php";
			$this->model = NULL;
		}
		$this->IncFile("Views/Components", $view, $parse);
	}
	
	public function Warning($message)
	{
		$this->View("warning", array("message"=>$message));
	}
	
	public function Error($message)
	{
		$this->View("error", array("message"=>$message));
	}
	
	public function Exception($e)
	{
		$local = $this->local;
		$str = "Views/$local/exception.php";
		if ( !file_exists( $str ) )
			$str = "Views/en/exception.php";
		include $str;
	}

}

?>