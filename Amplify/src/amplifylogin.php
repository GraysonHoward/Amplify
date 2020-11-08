
<?php
session_start();

//if coming from a post message of logout, display that the user logged out successfully on the login page
if (isset($_POST["logout"])) {	
	session_destroy();
	echo "You have logged out.";
}

//if someone is already logged into an active session, send them to the student's main page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {	
        header("LOCATION:Homepage.php");
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
										$_SESSION["userid"] = $row[0];			//the ID of the student is saved to the session as long as they are logged-in
										$_SESSION["password"] = $row[1];		//the password of the student is saved to the session as long as they are logged-in
                                        header("LOCATION:Homepage.php");		//go to the home page
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






<html>
<head>
  <title>Amplify: Home</title>
  <style>
    body{
      color: white;
      background-image: radial-gradient(teal, slategrey);
      overflow-x: hidden;
      padding-top:115px;
      height: 100%;
    }

    h2{
      margin:5px;
      padding:0px;
    }

    #banner{
      position:fixed;
      width:100%;
      height:115px;

      padding:5px;
      z-index:2;
      left:0;
      top:0;
      background-image:url("studyofdista.jpg");
    }

    h3{
        text-align: center;
    }

    .hidden{
        display: none;
    }

    #frm {
        border-radius: 25px;
        border-style: solid;
        border-width: thin;
        background-color: black;
        padding: 20px;
        width: 200px;
        height: auto;
        position: block;
        vertical-align: center;
        margin: auto;
        text-align: center;
    } 

    #center{
        padding-top: 250px;
        margin-top: 115px;
        width: 100%;
	}

    #newAccount {
        text-color: white;
        cursor: pointer;
	}

  </style>
</head>

<body>
  <div id=banner >
  <div id=logo>
  <img src="invislogo.png">
  </div>
  </div>
  <div id = "center">
    <form id="frm" method=post action=amplifylogin.php>
	    Username: <input type="text" name="username" style="margin-bottom:0.5cm;">
	    <br>
	    	Password: <input type="password" name="password" style="margin-bottom:1cm;">
	    </br>
	    <input type="submit" name="login" value="Login" style="margin-bottom:7px;">
        <div id="newAccount" onclick="location.href='NewAccountPage.php';">Create an account!</div>
    </form>
</div>
</body>
</html>






