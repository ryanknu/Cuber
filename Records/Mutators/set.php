<?php

if ( !Auth::Obj()->CanAccess(2) ) return;

class MutableSet extends Set
{
	private $keys;

	public function __construct($set)
	{
		parent::__construct($set);
		$this->keys = array_keys($this->data);
		foreach( $this->keys as $key )
		{
			if ( array_key_exists( $key, $_GET ) )
			{
				$this->Mutate( $key, $_GET[$key] );
				$this->data[$key] = $_GET[$key];
			}
		}
	}
	
	public function Mutate($field, $value)
	{
		Log::Activity("updated the set " . $this->data["name"]);
		
		$post = array($field=>$value);
		DB::zdb()->update(Set::$TABLE, $post, "id='{$this->id}'");
	}
	
	public function EditForm()
	{
		ob_start();
		echo "<table>";
		foreach( $this->keys as $key )
		{
			if ( is_object( $this->data[$key] ) )
			{
				echo $this->data[$key]->Mutator()->EditForm();
			}
			else
			{
				$arr["name"] = $key;
				$arr["text"] = ucfirst($key);
				$arr["value"] = $this->data[$key];
				$arr["action"] = "request.php?a=set_editor";
				$arr["uniq"] = "se";
				View::Obj()->Component("form_field", $arr);
			}
		}
		echo "</table>";
		$r = ob_get_contents();
		ob_get_clean();
		return $r;
	}
}

?>