<?php

if ( !Auth::Obj()->CanAccess(2) ) return;

class MutableCard extends Card
{
	private $keys;

	public function __construct($card)
	{
		parent::__construct($card);
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
		Log::Activity("updated the card " . $this->data["name"]);
		
		$post = array($field=>$value);
		DB::zdb()->update(Card::$TABLE, $post, "id='{$this->id}'");
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
				$arr["uniq"] = "ce";
				$arr["action"] = "request.php?a=card_editor";
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