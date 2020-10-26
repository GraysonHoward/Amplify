<?php

/*
	File that allows users to input their login information and access the homepage
*/

session_start();

// Only accesses this part if a username was provided after clicking the login button
if (isset($_POST["userid"])) {
	
// try catch statement to access the database
try { 
    $config = parse_ini_file("amplifydb.ini");
    $dbh = new PDO($config['dsn'], $config['username'],$config['password']);

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    

    // Prepared statement that selects the users login based on what they provided and prevents SQL injection
    $statement = $dbh->prepare("SELECT * from User where username=:userid and password=:password");

    $result = $statement->execute(array(':userid'=>$_POST['userid'], ':password'=>$_POST['password']));
	
	// Converts the users information into rowcount, there should only be one if information is correct
    $rowcount = $statement->rowCount();


    
	
	// If rowcount is 1, the login info is correct, and redirects the user to login_options
    if($rowcount == 1) {
		// Sets loggedin to true and creates userid and password global variables to be accessed elsewhere
        $_SESSION["loggedin"] = true;
        $_SESSION['username'] = $_POST['userid'];
        $_SESSION['password'] = $_POST['password'];
		// Redirects to homepage
        header('Location: //whatever homepage filename is');
	return;
    } else {
		// If info is wrong, prints this statement
        echo "Incorrect username or password";
    }
// catch statement for if database fails to connect
} catch (PDOException $e) {
    print "Error!" . $e->getMessage()."<br/>";
    die();
}
}
	// Html section that follows displays a text area for username and password, as well as a submit button
?>
<center>
<form method=post action=amplifylogin.php>
username: <input type="text" name="userid">
<br>
password: <input type="password" name="password">
<br>
<input type="submit" name="login" value="login">
</center>
</form>













