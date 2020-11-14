
<?php
session_start();

//if someone is already logged into an active session, send them to the student's main page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header("LOCATION:Homepage.php");
        return;
}

//if the login button was pressed
if (isset($_POST["username1"]) && isset($_POST["password1"]) && isset($_POST["confirmPassword"])) {

    //main mechanics of login page
    try {
	        //These three lines set-up the connection to the database using the provided .ini file
            $config = parse_ini_file("amplifydb.ini");
            $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            if ($_POST["password1"] == $_POST["confirmPassword"]) {
                    $x = 0;
                    foreach ($dbh->query("SELECT * FROM User") as $row) {
                        if ($_POST["username1"] == $row[0]) {
                            echo '<div id=php>"That username has already been taken."</div>';
                            $x = 1;
                            break;
                        }
                        else {
                            $x = 0;
						}
                    }
                    if ($x == 0) {
                        $stmt = $dbh->prepare("INSERT INTO User(username, password) VALUES(?, ?)");
                        $stmt->execute([$_POST["username1"], $_POST["password1"]]);
                        header("LOCATION:amplifylogin.php");
                        return;
					}
            }
            echo '<div id=php>"Your passwords did not match."</div>';
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
      overflow-y:auto;
      padding-top:115px;

    }

    h2{
      margin:5px;
      padding:0px;
    }

    #php{
			margin-top:0;
			color:red;
			position:absolute;
			top:600px;
			left:50%;
			z-index:3;
			background-color:black;
			-webkit-transform: translate(-37%, 0);
      -moz-transform: translate(-37%, 0);
      -ms-transform: translate(-37%, 0);
      -o-transform: translate(-37%, 0);
      transform: translate(-37%, 0);

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
        vertical-align: 40%;
        margin: auto;
        text-align: center;
    }

    #center{
        /*
        margin-top: 115px;
        width: 100%;*/
        margin:-100px;
				margin-top:225px;
        position:absolute;
				left:50%;
				top:40px;
	}

    #login {
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
    <form id="frm" method=post action=NewAccountPage.php>
	    Username: <input type="text" name="username1" style="margin-bottom:0.5cm;">
	    <br>
	    	Password: <input type="password" name="password1" style="margin-bottom:1cm;">
		    Confirm Password: <input type="password" name="confirmPassword" style="margin-bottom:1cm;">
	    </br>
	    <input type="submit" name="login" value="Create Account" style="margin-bottom:7px;">
        <div id="login" onclick="location.href='amplifylogin.php';">Already have an account? Login!</div>
    </form>
</div>
</body>
</html>
