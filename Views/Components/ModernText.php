<?php

// Class borrowed from MPN for now. I technically wrote it, and the
// whole thing isn't present. Will be updated later.

function ModernText($name, $value, $label, $params=array())
{
	$m = new Modern();
	return $m->modernText($name, $value, $label, $params);
}

function ModernPassword($name, $label="Password", $params=array())
{
	$m = new Modern();
	return $m->modernPassword($name, $label, $params);
}

// temporary text fields to make it easier
class Modern 
{

	// **
    // * Draw a text field with in-field validation
    // *
    public function modernText($name, $value, $label, $params=array(), $type="text")
    {
    	if ( isset($params['width']) && $params['width']{strlen($params['width']) - 1} <> "%" )
    	{
    		$style = @$params['style'];
    		$params['style'] = "width: {$params['width']}px;" . $style;
    		unset($params['width']);
    	}
    	$onBlur = @$params['onBlur'];
    	$params['onBlur'] = "fadeLeaveBox('$name');" . $onBlur;
    	$onFocus = @$params['onFocus'];
    	$params['onFocus'] = "fadeEnterBox('$name', event);" . $onFocus;
    	$onKeyDown = @$params['onKeyDown'];
    	$params['onKeyDown'] = "fadeEnterBox('$name', event);" . $onKeyDown;
    	return  "<div style=\"position:relative\">"
    	       ."<label for=\"$name\" "
    	       ."id=\"label_$name\" "
    	       ."class=\"infield\""
    	       .">$label</label>"
    		   ."<input type=\"$type\" name=\"$name\" id=\"$name\" "
    	       ."value=\"$value\" "
    	       ."class=\"inp_sty\" "
    	       . $this->_prepareParams($name, $params)
    	       ." /></div>";
    }
    
    // **
    // * Draws a "modern" text field for password inputs
    public function modernPassword($name, $label="Password", $params=array('style'=>'width: 100%'))
    {
    	return $this->modernText($name, "", $label, $params, "password");
    }
    
    private function _prepareParams($name, $params) {
        if ($name && !isset($params['id']))
            $params['id'] = $name;
        if ($params) {
            $out = ' ';
            foreach ($params as $key => $val)
                if (($key!='disabled' && $key!='readonly') || $val)
                    $out .= $key . '="' . $val . '" ';
            return $out;
        } else
            return '';
    }

}

?>