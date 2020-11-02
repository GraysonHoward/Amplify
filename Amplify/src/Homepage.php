<html>

<head>
  <title>Amplify: Home</title>
  <style>
    body{
      color: white;
      background-image: radial-gradient(teal, slategrey);
      overflow-x: hidden;
      padding-top:115px;
    }

    h2{
      margin:5px;
      padding:0px;
    }

    .box{
      border:5px;
      border-style:solid;
      border-color:black;
      border-top:0;
      padding:5px;
      margin-top: -5px;
      margin-bottom:0px;
      padding-top:1px;
      box-sizing:border-box;

      z-index:1;
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

    #logo{

    }

    #events{
      border-top:5px;
      top:115px;
    }

  </style>
  <link rel="stylesheet" href="Homepage.css">
</head>

<body>
  <div id=banner >
  <div id=logo>
  <a href="Homepage.html">
  <img src="invislogo.png">
  </a>
  </div>
  </div>
  <div id=events class=box>
    <h2>All Events</h2>
    <div id= "eventpane">
	
	<?php
		session_start();
	
		try {
			$config = parse_ini_file("amplifydb.ini");
			$dbh = new PDO($config['dsn'], $config['username'],$config['password']);

			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			foreach ( $dbh->query("SELECT eventName FROM Events ORDER BY rating DESC") as $row ) {
				
				
				echo '<div class = "thumbnail">';
				echo '<div class = "eventTitle">';
				echo $row[0];
				echo '</div>';
				echo '<img src = "empty_event.png">';
				echo '</div>';
			}
				// Catch statement that activates if connection to database fails
			} catch (PDOException $e) {
				print "Error!" . $e->getMessage()."<br/>";
				die();
			}	
	
	?>
	

		
    </div>
    <h3 class = "hidden">No more events to display!</h3>
  </div>
  <a href="Account.html">Return to Account page.</a>
  <footer>
    
  </footer>
</body>

</html>