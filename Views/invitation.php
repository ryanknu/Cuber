<?php require_once "Views/Components/ModernText.php"; ?>

  	<form method="POST" action="signup.php">
  	  <table width="400" align="center">
  	    <tr>
  	      <td style="margin-top: 150px;text-align:center;">
  	        <?php echo ModernText("code", "", "Invitation Code"); ?>
  	      </td>
  	    </tr>
  	    <tr>
  	      <td>
  	        Don't have an invitation code? Email me, ryan@eknuesel.net, to obtain
  	        one.
  	      </td>
  	    </tr>
  	    <tr>
  	      <td>
  	        <input type="submit" class="inp_sty" style="width:100px" value="Connect" />
  	      </td>
  	    </tr>
  	  </table>
  	</form>
  	