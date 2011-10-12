<?php

class Image
{
	public static $TABLE = "images";
	public static $CLASSES = "image_classes";
	
	private $id;
	private $classes;
	private $localUrls;
	private $sourceUrl;
	private $useSource;
	
	public static function ForCard($card)
	{
		$s = DB::zdb()->select()
			->from(array("c" => Card::$TABLE))
			->join(array("i" => Image::$TABLE), "c.id = i.card")
			->where("c.id = ?", $card->ID());
		$r = DB::zdb()->fetchRow($s);
		if ( $r )
		{
			return new Image($r);
		}
		return false;
	}
	
	public static function Import($id, $card)
	{
		require_once "Tools/Image/import.php";
		$s = DB::zdb()->select()
			->from(Image::$TABLE)
			->where("source_url = ?", GetGathererURL($id));
		$row = DB::zdb()->fetchRow($s);
		if ( !$row )
		{
			DB::zdb()->insert(
				Image::$TABLE, array("source_url" => GetGathererURL($id), "card" => $card)
			);
			$row = array("id" => $imId = DB::zdb()->lastInsertId());
		}
		$r = GetImages($id);
		foreach($r as $class => $url)
		{
			DB::zdb()->insert(
				Image::$CLASSES,
				array(
					"image" => $row['id'],
					"class" => $class,
					"local_url" => $url
				)
			);
		}
	}
	
	public function __construct($image)
	{
		if ( !is_array($image) )
		{
			$s = DB::zdb()->select()
				->from(Image::$TABLE)
				->where("id = ?", $image);
			$image = DB::zdb()->fetchRow($s);
		}
		$this->id = $image['id'];
		$this->sourceUrl = $image['source_url'];
		$this->classes = array();
		$this->localUrls = array();
		if ( !$this->useSource )
		{
			$s = DB::zdb()->select()
				->from(Image::$CLASSES)
				->where("image = ?", $this->id);
			$rows = DB::zdb()->fetchAll($s);
			foreach($rows as $row)
			{
				$this->classes[] = $row['class'];
				$this->localUrls[$row['class']] = $row['local_url'];
			}
		}
	}
	
	public function GetClass($class)
	{
		if ( $class == "source" )
			return $this->sourceUrl;
		return $this->localUrls[$class];
	}
	
	public function Get($key) { return $this->data[$key]; }
}

?>