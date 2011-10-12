<?php

$name = $view->Get("name");
$text = $view->Get("text");
$val = $view->Get("value");
$action = $view->Get("action");
$u = $view->Get("uniq");


echo "
<tr>
  <td>
  	<input type=\"hidden\" id=\"${u}_a_$name\" value=\"$action\" />
    <span class=\"se_up\" id=\"${u}_$name\">$text: $val <a onclick=\"${u}_e('$name', '$u');\"> :edit</a></span>
    <span class=\"se_down\" id=\"${u}_e_$name\"><input type=\"text\" id=\"${u}_i_$name\" onblur=\"${u}_b('$name', '$u');\" value=\"$val\" /></span>
  </td>
</tr>
";

?>