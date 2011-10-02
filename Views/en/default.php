<?php require_once "Views/Components/ModernText.php"; ?>

  	<form method="POST" action="login.php">
  	  <table width="400">
  	    <tr>
  	      <td>Please sign in</td>
  	    </tr>
  	    <tr>
  	      <td>
  	        <?php echo ModernText("user", "", "Username"); ?>
  	      </td>
  	    </tr>
  	    <tr>
  	      <td>
  	        <?php echo ModernPassword("pass"); ?>
  	      </td>
  	    </tr>
  	    <tr>
  	      <td>
  	        <input type="submit" class="inp_sty" style="width:100px" value="Log In" />
  	      </td>
  	    </tr>
  	  </table>
  	</form>
  	