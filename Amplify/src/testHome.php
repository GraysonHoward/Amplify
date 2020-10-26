
<?php
session_start();

echo "Test Home Page";
if ($_POST["logout"]) {
	header("LOCATION:amplifylogout.php");	//send user to logout
}
?>

<center>
<form method=post action=amplifylogin.php>
	<input type="submit" name="logout" value="Logout">
</form>
</center>