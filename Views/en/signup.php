<?php require_once "Views/Components/ModernText.php"; ?>

  	<form method="POST" action="signup.php">
  	  <table width="400">
  	    <tr>
  	      <td>Sign up for a cuber account</td>
  	    </tr>
  	    <tr>
  	      <td>
  	        <?php echo ModernText("code", "", "Invite Code"); ?>
  	      </td>
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
  	        <?php echo ModernPassword("pass2", "Confirm Password"); ?>
  	      </td>
  	    </tr>
  	    <tr>
  	      <td>
  	        <?php echo ModernText("name", "", "Display Name"); ?>
  	      </td>
  	    </tr>
  	    <tr>
  	      <td>
  	        <input type="submit" class="inp_sty" style="width:150px" value="Sign up" />
  	      </td>
  	    </tr>
  	  </table>
  	</form>
  	