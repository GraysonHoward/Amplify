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
	
  	.infowrapper{
			display: flex;
			padding: 0 1% 0 0;
      border-style: none none solid none;
      border-color: black;
    }

    .align-right{
	    text-align:right;
      border:0;
    }
	
	  .buttondiv button{
      background-color: yellow;
			display: block;
      padding: 5%;
      font-weight: bold;
      border-radius: 3pt;
			width: 125px;
			height: 30px;
    }
	
    #logo{
	  	width: 100%;
    }

    #events{
      border-top:5px;
      top:115px;
    }

    .thumbnail input{
      background-color: yellow;
      border-radius: 5px;
      font-weight: bold;
      padding: 4px;
      margin: 10px;
    }

    .thumbnail form{
      margin: 0;
    }

    div.thumbnail{
      background-color: purple;
      margin: 10px;
      font-size: 15pt;
      border-style: solid;
      border-width: 2px;
      text-align: center;
    }

    div.thumbnail img{
      width: 100%;
    }

    #eventpane{
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
    }

    h3{
      text-align: center;
    }

    .hidden{
      display: none;
    }

    @media screen and (max-width: 700px){
      #eventpane{
        grid-template-columns: 1fr 1fr;
      }
    }


    @media screen and (max-width: 450px){
      #eventpane{
        grid-template-columns: 1fr;
      } 
     }
    
  </style>

</head>

<body>
  <div id=banner >
    <div class = "infowrapper">
      <div id=logo>
        <a href="Homepage.php">
          <img src="invislogo.png">
        </a>
      </div>
      <div class= "btn-container">
        <div class = "align-right">
		      <div class = "buttondiv">
			      <button>
				      <a href="Account.html">
				        My Account
				      </a>
			      </button>
		      </div>
        </div>
        <div class = "align-right">
		      <div class = "buttondiv">
			      <button>
				      <a href="eventpage.php">
				        Create An Event
				      </a>
			      </button>
		      </div>
        </div>
        <div class = "align-right">
		      <div class = "buttondiv">
			      <button>
				      <a href="amplifylogout.php">
				        Log Out
				      </a>
			      </button>
		      </div>
        </div>
      </div>
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
				echo '<form method="post" action="eventpage.php">';
				echo '<input type="submit" name="eventName" value="'.$row[0].'">';
					echo '<input type = "hidden" name = "eventName" value="'.$row[0].'">'; 
				echo '</form>';	
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