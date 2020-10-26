
<?php
session_start();

echo "Test Home Page";
echo "<br>";
echo '<form method="post" action="amplifylogout.php">';
echo "<TR>";
echo '<TD> <input type="submit" name="Logout" value="Logout"> </TD>';		//provide a button to optionally return to the student login page
echo "</TR>";
echo '</form>';
?>
