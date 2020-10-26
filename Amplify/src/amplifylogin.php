
<?php
session_start();

//if coming from a post message of logout, display that the user logged out successfully on the login page
if (isset($_POST["logout"])) {	
	session_destroy();
	echo "You have logged out.";
}

//if someone is already logged into an active session, send them to the student's main page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {	
        header("LOCATION:testHome.php");
        return;
}

//if the login button was pressed
if (isset($_POST["username"])) {

//main mechanics of login page
try {
	//These three lines set-up the connection to the database using the provided .ini file
        $config = parse_ini_file("amplifydb.ini");					
        $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//for each user in the User table
		foreach ($dbh->query("SELECT * FROM User") as $row) {	
				//if the ID and password that was entered in the text fields both match that of a student in the table (encryption used in comparing passwords)
                                if ($_POST["username"] == $row[0] && $row[1] == $_POST["password"]) { //$row[1] == crypt($_POST["password"],$row[1])
                                        $_SESSION["loggedin"]=true;				//the session status now shows the student as logged-in
					$_SESSION["userid"] = $row[0];				//the ID of the student is saved to the session as long as they are logged-in
					$_SESSION["password"] = $row[1];			//the password of the student is saved to the session as long as they are logged-in
                                        header("LOCATION:testHome.php");		//go to the home page
                                        return;
                                }
                        }
                        echo "Incorrect ID/password.";	//if nothing matches the input, stay on the page and display that the input was incorrect
	
}
catch (PDOException $e) {		//catch any problems with database connection
        print "Error!" . $e->getMessage()."<br/>";
        die();
}
}
?>

<!-- html code that creates the text fields and login button --!>
<center>
<form method=post action=amplifylogin.php>
	User ID: <input type="text" name="username">
	<br>
		password: <input type="password" name="password">
	<br>
	<input type="submit" name="login" value="Login">
</form>

</center>



