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
	
	public static function Import($url)
	{
		$s = DB::zdb()->select()
			->from(Image::$TABLE)
			->where("source_url = ?", $url);
		$row = DB::zdb()->fetchRow($s);
		if ( !$row )
		{
			DB::zdb()->insert(
				Image::$TABLE, array("source_url" => $url)
			);
		}
		require_once "Tools/Image/import.php";
		$r = GetImages($url);
		foreach($r as $class => $url)
		{
			DB::zdb()->insert(
				Image::$CLASSES,
				array(
					"image" => $row['id'],
					"class" => $class,
					"local_url" => $url
				);
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
		$this->useSource = $image['use_source'];
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
				$this->localUrls[] = $row['local_url'];
			}
		}
	}
	
	public function Get($key) { return $this->data[$key]; }
}

?>