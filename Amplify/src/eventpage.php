<?php
	session_start();
if (!$_SESSION["loggedin"]) {
	header("LOCATION:amplifylogin.php");
	return;
}
if (!isset($_POST['eventName'])){
    header("LOCATION:Homepage.php");
	return;
}

    $name = $_POST['eventName'];
    
	$_SESSION['attendees'] = array();
	$_SESSION['eventname'] = $name;
	$_SESSION['comments'] = array();
	
	
?>




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amplify Event: <?php echo $name ?></title>
    <link rel="shortcut icon" type="image/jpg" href="favicon.ico"/>
    <style>
        /*Every div has no initial margin or padding by default*/
        * {
            margin: 0;
            padding: 0;
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
			width: 100%;
		}
        body{
            color: white;
            background-image: radial-gradient(teal, slategrey);
            overflow-x: hidden;
            margin-top:115px;
        }
        button.inactive{
            color: slategrey;
            background-color: steelblue;
            border-radius: 5px;
        }
        .description{
            text-align: left;
            outline-style: solid;
            outline-width: thin;
            outline-color: black;
            margin-bottom: 10pt;
            margin-left: 5%;
            margin-right: 5%;
            background-color: blueviolet;
            padding: 10px 5px 10px 5px;
        }
        div.attendeepane{            
            width: 34%;
            position: sticky;
            top: 130px;
            height: 80vh;
            margin: 5px;
            padding-top: 5px;
        }
        div.contentpane{
            display: flex;
            flex: 1;
            min-height: 100%;
            border:5px;
            border-style:solid;
            border-color:black;
            border-top:0;
            margin: 5px;
        }
        .eventinfo{
            border-style: none none solid none;
            border-color: black;
            margin-bottom: 10px;
            padding-bottom: 15px;
        }
        div.eventpane {
            width: 66%;
            text-align: center;
            padding-top: 10pt;
            margin-bottom: 0px;
            border: 5px;
            border-style: none none none solid;
            border-color:black;
        }
        .eventpane img{
            width: 90%;
            margin: 5%;
        }
        .eventpane .imageContainer{
            overflow: hidden;
            max-height: 250px;
            text-align: center;
            margin-bottom: 5%;
        }
        .eventRating{
            font-size: 14pt;
        }
        .eventRating .ratingWrapper{
            display: inline-flex;
            vertical-align: center;
        }
        #ratingNumber{
            margin-left: 10px;
            margin-right: 10px;
        }
		.infowrapper2{
			display: flex;
			padding: 0 1% 0 0;
            border-style: none none solid none;
            border-color: black;
		}
        /* Holds the quick-info and "i'm interested" button elements*/
        .infowrapper{
            display: flex;
            padding:  0 5% 10px 5%;
        }
        .quickinfo{
            width: 100%;
        }
        .ratingWrapper{
            vertical-align: center;
        }
		.align-right{
			text-align: right;
			border:0;
		}
        form input{
            background-color: yellow;
            padding: 5%;
            font-weight: bold;
            border-radius: 3pt;
        }
		.buttondiv2 button{
            background-color: yellow;
			display: block;
            padding: 5%;
            font-weight: bold;
            border-radius: 3pt;
			width: 125px;
			height: 30px;
		}
        /*Handles default styling for comment and attendee lists*/
        ul{
            text-align: left;
            list-style: none;
        }

    </style>
    <style>/*  handles the css for the event page comments */
        .comments{
            height: auto;
            margin-top: 10pt;
            margin-left: 5px;
            padding: 0 10pt 10pt 10pt;
        }

        #addComment{
            background-color: yellow;
            border-radius: 5px;
            padding: 1px;
            margin: 4px;
        }

        .commentInput{
            margin: 8px;
            width: 98%;
            max-width: 98%;
            min-width: 98%;
            height: 10%;
            white-space: normal;
        }

        .comments ul li p{
            padding: 3pt;
            background-color: slategray;
            margin-top: 5px;
        }

        .comments ul li{
            margin: 0 0 10pt 0;
            border-style: solid;
            background-color: black;
            padding: 5px;
        }

        #commentRatings{
            display: none;
        }

        .ratingWrapper button{
            border-radius: 50%;
        }

        .rating{
            vertical-align: center;
            margin-left: 15px;
            margin-right: 15px;
        }

        .hide{
            display: none;
        }

        /*  This is the comment template that is copied to display user-generated comments.
            It is not meant to be displayed.
        */
        .comments ul li.blankComment{
            display: none
        }

        .comments ul li div.ratingWrapper{
            display: flex;
            justify-content: flex-end;
            padding: 3pt 0 3pt 0;
        }

    </style>
    <style>/*handles the css for the attendees
        /*The attendee template*/
        .attendeeList .blankAttendee{
            display: none;
        }

        .attendeeList{
            border-style: solid;
            border-width: medium;
            margin-top: 10px;
            max-height: 90%;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .attendeeList li{
            width: 100%;
            display: inline-flex;
            margin: auto;
            border-style: solid;
            border-width: thin;
            border-color: slategray;
            padding: 5px 2px 5px 10px;
        }

        .attendeeList li button{
            margin-left: 20px;
            background-color: 02fdff;
            border-radius: 5px;
            padding: 1px;
        }

        .noAtts{
            margin-top: 20px;
        }
    </style>
    <style> /*The contents of this style tag handle styling for mobile devices*/

    @media screen and (max-width: 700px){
            div.contentpane{
                display: -webkit-box;
                -webkit-box-orient: vertical;
                -webkit-box-direction: reverse;
            }
            div.attendeepane{
                width: auto;
                text-align: center;
                max-height: 450pt;
                border-top-style: solid;
                border-color: black;
                margin-left: 0;
                margin-right: 0;
                padding:0 5px 0 5px;
            }
            div.eventpane{
                width: 100%;
                border-style: none;
            }
        }
    </style>
    
</head>
<body>
    <header>
        <div id=banner>
			<div class = "infowrapper2">
				<div id=logo>
					<a href="Homepage.php">
						<img src="invislogo.png">
					</a>
				</div>
			<div class= "btn-container">
				<div class = "align-right">
					<div class = "buttondiv2">
						<button>
							<a href="Account.html" class = "button">
								My Account
							</a>
						</button>
					</div>
				</div>
				<div class = "align-right">
					<div class = "buttondiv2">
						<button>
							<a href="publishEvent.php" class = "button">
								Create An Event
							</a>
						</button>
					</div>
				</div>
				<div class = "align-right">
					<div class = "buttondiv2">
						<button>
							<a href="amplifylogout.php" class = "button">
								Log Out
							</a>
						</button>
					</div>
				</div>			  
			</div>
			</div>
		</div>
    </header>
    <div class = "contentpane">
        <div class = "attendeepane">
            <h3>
                See who's going:
            </h3>
            <div class = "noAtts">
                No one on Amplify is going to this event. You could be the first!
            </div>
            <ul class = "attendeeList">
				<?php
	
				try {
					$config = parse_ini_file("amplifydb.ini");
					$dbh = new PDO($config['dsn'], $config['username'],$config['password']);
						
					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$_SESSION["friends"] = array();
					foreach ( $dbh->query("SELECT friendName FROM FriendList where username = '".$_SESSION["userid"]."'") as $friends ) {
						array_push($_SESSION["friends"] ,$friends[0]);
					}

					foreach ( $dbh->query("SELECT username FROM Attendees where eventName = '".$name."'") as $attendees ) {
						echo '<li>';
						echo $attendees[0];

						
									
									if (!in_array($attendees[0], $_SESSION["friends"]) and $attendees[0] != $_SESSION["userid"]) {
										echo '<form method="post">';
										echo '<input type="hidden" name="friend" value="'.$attendees[0].'">';
										echo '<input type="submit" name="beFriends" value= " friend? ">';
										echo '<input type = "hidden" name = "eventName" value="'.$name.'">';
										echo '</form>';
									}
						
						
						echo '</li>';
					}
					
					echo '<form action="eventpage.php">';
					echo '<form action="eventpage.php">';
					if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['beFriends']) and isset($_POST['friend'])) {
						$attendees = $_POST['friend'];

						$stmt = $dbh->prepare("INSERT INTO FriendList(username, friendName) VALUES('".$_SESSION["userid"]."', '".$attendees."')");
						$stmt->execute();

					}
					echo '</form>';
					echo '</form>';
				} catch (PDOException $e) {
					print "Error!" . $e->getMessage()."<br/>";
					die();
				}	
			
				?>
           
            </ul>
        </div>
        <div class = "eventpane">
            <h2>
                <?php echo $name ?>
            </h2>
            <div class = "imageContainer">
				<?php
	
				try {
					$config = parse_ini_file("amplifydb.ini");
					$dbh = new PDO($config['dsn'], $config['username'],$config['password']);

					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					foreach ( $dbh->query("SELECT image FROM Events where eventName = '".$name."'") as $image ) {
						echo "<img src = $image[0]>";
					}
				} catch (PDOException $e) {
					print "Error!" . $e->getMessage()."<br/>";
					die();
				}	
			
				?>
                
            </div>
            <div class = "eventinfo">
                <div class = "description">
                   
                        <?php
	
							try {
								$config = parse_ini_file("amplifydb.ini");
								$dbh = new PDO($config['dsn'], $config['username'],$config['password']);

								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
								foreach ( $dbh->query("SELECT bio FROM Events where eventName = '".$name."'") as $bio ) {
									echo "<p>$bio[0]</p>";
								}
							} catch (PDOException $e) {
								print "Error!" . $e->getMessage()."<br/>";
								die();
							}	
			
						?>
                    
                </div>
                <div class = "infowrapper">
                    <div class = "quickinfo">
                        <ul>
						
							<?php
	
							try {
								$config = parse_ini_file("amplifydb.ini");
								$dbh = new PDO($config['dsn'], $config['username'],$config['password']);

								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
								foreach ( $dbh->query("SELECT date, location FROM Events where eventName = '".$name."'") as $info ) {
									echo "<li>Date/Time: $info[0]</li>";
									echo "<li>Location: $info[1]</li>";
								}
							} catch (PDOException $e) {
								print "Error!" . $e->getMessage()."<br/>";
								die();
							}	
			
							?>
                        </ul>
                    </div>
					<?php
						echo '<form method="post" action="eventpage.php">';
							echo '<input type="submit" name="attend" value=" I am interested! ">';
							echo '<input type = "hidden" name = "eventName" value="'.$name.'">';
							if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['attend'])) {
								try {
									$config = parse_ini_file("amplifydb.ini");
									$dbh = new PDO($config['dsn'], $config['username'],$config['password']);

									$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$a = false;
									foreach ( $dbh->query("SELECT username FROM Attendees where eventName = '".$name."'") as $attending ) {
										if ($attending[0] == $_SESSION["userid"]) {
											$a = true;
										}
									}
									if($a == false){
										$stmt = $dbh->prepare("INSERT INTO Attendees(eventName, username) VALUES(?, ?)");
										$stmt->execute([$name, $_SESSION["userid"]]);
									}
								} catch (PDOException $e) {
									print "Error!" . $e->getMessage()."<br/>";
									die();
								}
							}
						echo '</form>';	
					?>
                </div>
                <div class = "eventRating">
                    <div class = "ratingWrapper">
                        Event Rating:    
                        <?php
						try {
							$config = parse_ini_file("amplifydb.ini");
							$dbh = new PDO($config['dsn'], $config['username'],$config['password']);
							$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							echo '&nbsp';
							echo '<form method="post" action = "eventpage.php">';
								echo '<button class = "ratingVote" name = "like">';
									echo '<img src = "like.png" style= "width:15px; height:15px;">';
									echo '<input type = "hidden" name = "eventName" value="'.$name.'">';
										if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['like'])) {
											foreach ( $dbh->query("SELECT rating FROM Events where eventName = '".$name."'") as $erating ) {
												$stmt = $dbh->prepare("UPDATE Events SET rating = '".$erating[0]."' + 1 where eventName = '".$name."'");
												$stmt->execute();
											}
										}
								echo '</button>';
							echo '</form>';
                            echo '<div id = "ratingNumber">';
								foreach ( $dbh->query("SELECT rating FROM Events where eventName = '".$name."'") as $erating ) {
									echo $erating[0];
								}
                            echo '</div>';
							echo '<form method="post" action = "eventpage.php">';
								echo '<button class = "ratingVote" name = "dislike">';
									echo '<img src = "dislike.png" style= "width:15px; height:15px;">';
									echo '<input type = "hidden" name = "eventName" value="'.$name.'">';
										if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['dislike'])) {

											foreach ( $dbh->query("SELECT rating FROM Events where eventName = '".$name."'") as $erating ) {
												$stmt = $dbh->prepare("UPDATE Events SET rating = '".$erating[0]."' - 1 where eventName = '".$name."'");
												$stmt->execute();
											}
										} 
									
								echo '</button>';
							echo '</form>';
						} catch (PDOException $e) {
							print "Error!" . $e->getMessage()."<br/>";
							die();
						}
						?>
                    </div>
                </div>
            </div>
            <div class = "comments">
                <h3>
                    Comments
                </h3>
                <div class = "noComments">
                    No one has commented on this event yet. Be the first to leave your thoughts!
                </div>
                <button id = 'addComment'>Add comment</button>
                <ul>
                    <li class = "userIn hide">
						<?php
							try {
								$config = parse_ini_file("amplifydb.ini");
								$dbh = new PDO($config['dsn'], $config['username'],$config['password']);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								echo '<form method="post" action = "eventpage.php">';
								
								echo '<textarea class = "commentInput" name = "newComment" maxlength = "255" required>';
								echo '</textarea>';
								
								echo '<button class = "submitComment" name = "submitNewC">';
								echo '<input type = "hidden" name = "eventName" value="'.$name.'">';
								if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submitNewC'])) {
									$date = date('Y-m-d H:i:s');
									$stmt = $dbh->prepare("INSERT INTO Comments(username, eventName, datetime, comment, rating) VALUES(?, ?, ?, ?, ?)");
									$stmt->execute([$_SESSION["userid"], $name, $date, trim($_POST['newComment']), '0']);		
								}
								echo "Submit";
								echo '</button>';
								echo '</form>';
							} catch (PDOException $e) {
								print "Error!" . $e->getMessage()."<br/>";
								die();
							}
						?>

                    </li>
                    <li class = "blankComment">
                        <div class = "commentHeader">
                            <div class = "username align-left">
                                username
                            </div>
					    	<div class = "commentdt align-right">
							    12
                            </div>
                        </div>
                        <p>comment body</p>
                        <div class = "ratingWrapper align-right">
                            <?php
                            /* This whole PHP tag can be removed without loss of function

								echo '<form method="post" action = "eventpage.php">';
								echo '<button name = "clike">';
								echo '<img src = "like.png" style= "width:12px; height:12px;">';
								echo '<input type = "hidden" name = "eventName" value="'.$name.'">';
								
								echo '</button>';
                                echo '</form>';
                                */
							?>
                            <div class = "rating">0</div>
                            <?php
                            /* So can this one

								echo '<form method="post" action = "eventpage.php">';
								echo '<button name = "cdislike">';
								echo '<img src = "dislike.png" style= "width:12px; height:12px;">';
								echo '<input type = "hidden" name = "eventName" value="'.$name.'">';
								echo '</button>';
                                echo '</form>';
                                */
							?>
                        </div>
                    </li>
                </ul>
                <ul id = "commentRatings">
                    <?php
				        try {
				        	$config = parse_ini_file("amplifydb.ini");
				        	$dbh = new PDO($config['dsn'], $config['username'],$config['password']);
                        
				        	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                            foreach ( $dbh->query("SELECT rating, datetime, username FROM Comments where eventName = '".$name."' ORDER BY rating DESC") as $comrating ) {
                                echo '<div class = "invisRatings">';
                                //PHP for liking a comment
                                echo '<form method="post" action = "eventpage.php">';
                                echo '<button name = "clike">';
                                echo '<input type = "hidden" name = "comdate" value = "'.$comrating[1].'">';
                                echo '<input type = "hidden" name = "comuser" value = "'.$comrating[2].'">';
								echo '<img src = "like.png" style= "width:12px; height:12px;">';
                                echo '<input type = "hidden" name = "eventName" value="'.$name.'">';
                                    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['clike'])){
                                        if ($_POST['comdate'] == $comrating[1] and $_POST['comuser'] == $comrating[2]){
                                            $stmt = $dbh->prepare("UPDATE Comments SET rating = '".$comrating[0]."' + 1 where eventName = '".$name."' AND datetime = '".$comrating[1]."' AND username = '".$comrating[2]."'");
                                            $stmt->execute();
                                        }
                                    }
								echo '</button>';
                                echo '</form>';
                                
                                echo '<div class = "rating">0</div>';


                                //PHP for disliking a comment
                                echo '<form method="post" action = "eventpage.php">';
                                echo '<button name = "cdislike">';
                                echo '<input type = "hidden" name = "comdate" value = "'.$comrating[1].'">';
                                echo '<input type = "hidden" name = "comuser" value = "'.$comrating[2].'">';
								echo '<img src = "dislike.png" style= "width:12px; height:12px;">';
                                echo '<input type = "hidden" name = "eventName" value="'.$name.'">';
                                    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['cdislike'])){
                                        if ($_POST['comdate'] == $comrating[1] and $_POST['comuser'] == $comrating[2]){
                                            $stmt = $dbh->prepare("UPDATE Comments SET rating = '".$comrating[0]."' - 1 where eventName = '".$name."' AND datetime = '".$comrating[1]."' AND username = '".$comrating[2]."'");
                                            $stmt->execute();
                                        }
                                    }
								echo '</button>';
                                echo '</form>';

                                echo '</div>';
                            }

				        } catch (PDOException $e) {
				        	print "Error!" . $e->getMessage()."<br/>";
				        	die();
				        }
                    ?>
                </ul>
                <button class="seeMore">load more</button>
            </div>
        </div>
    </div>

    <script> //Script for the comments
        var template = document.getElementsByClassName('blankComment')[0]
        var commentList = document.getElementsByClassName('comments')[0]
        commentList = commentList.getElementsByTagName('ul')[0]
        var loadMore = document.getElementsByClassName('seeMore')[0]
		var commentBody = []
		var commentDT = []
		var commentUser = []
		var commentRating = []
        var visibleComments = 0
        var totalComments = getNumOfComments()
        var addUserComment = document.getElementById('addComment');
        var commentRatingButtons = document.getElementById('commentRatings');
        commentRatingButtons = commentRatingButtons.getElementsByClassName('invisRatings');

        //The following functions are prototypes meant to deal with data calls. 
        //This was done to keep GUI functionality independent from data call implementation
        //============================================= 
        function getNumOfComments(){
			<?php
	
				try {
					$config = parse_ini_file("amplifydb.ini");
					$dbh = new PDO($config['dsn'], $config['username'],$config['password']);

					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					foreach ( $dbh->query("SELECT COUNT(comment) FROM Comments where eventName = '".$name."'") as $numComments ) {
					}
				} catch (PDOException $e) {
					print "Error!" . $e->getMessage()."<br/>";
					die();
				}	
			
			?>
            var num = <?php echo $numComments[0] ?> 
            if (num == 0){
                loadMore.style.display = "none"
            }
           else{
                document.getElementsByClassName('noComments')[0].className = "hide"
            }   
            return num
        }
		
		<?php
			foreach ( $dbh->query("SELECT comment, datetime, username, rating FROM Comments where eventName = '".$name."' ORDER BY rating DESC") as $comments ) {
				echo 'commentBody.push(';
				echo json_encode($comments[0]);
				echo ')';
				echo ";";
				echo 'commentDT.push(';
				echo json_encode($comments[1]);
				echo ')';
				echo ";";
				echo 'commentUser.push(';
				echo json_encode($comments[2]);
				echo ')';
				echo ";";
				echo 'commentRating.push(';
				echo json_encode($comments[3]);
				echo ')';
				echo ";";
			}
		?>
		
		
        function getCommentBody(){
            return commentBody[visibleComments];
		}

        function getCommentDateTime(){
            return commentDT[visibleComments];
        }

        function getCommentUsername(){
            return commentUser[visibleComments]; 
        }

        function getCommentRating(){
            return commentRating[visibleComments];
        }
        //============================================= 

        function loadComment(){
            var comment = [getCommentUsername(), getCommentDateTime(), getCommentBody(), getCommentRating()]
            return comment
        }


        //Automatically loads three comments when the page loads
        function load3comments(){
			for (var i = 0; i < 3; i++){
				if (visibleComments < totalComments){
					displayNewComment(loadComment())
				}
				if(visibleComments == totalComments){
					loadMore.className = "inactive"
				}   
			}
		}
		
        load3comments()
        //Keeps the number of loaded comments consistent on page reload
        if (typeof('storage') != "undefined"){
            var numtoload = sessionStorage.getItem('numloaded');
            if (numtoload != "undefined"){
                numtoload = parseInt(numtoload);
                while (visibleComments < numtoload && visibleComments < totalComments){
                    load3comments();
                }
            }
        }
		
        //Loads three new comments every time "load more" is clicked
        loadMore.addEventListener("click", function(){
            load3comments()
            //Keeps the loaded comments consistent on page reload
            if (typeof('storage') != "undefined"){
                sessionStorage.setItem('numloaded', visibleComments);
            }
        })

        //Displays user input field when add comment is clicked
        addUserComment.addEventListener("click", function(){
            commentList.getElementsByClassName('userIn')[0].className = 'userIn'
        })

        //Adds a new li to the comment list containing html for the new comment
        function displayNewComment(comment){
            var newComment = template  
            //The newComment variable is for readability purposes only. It is not necessary for functionality.
            newComment.getElementsByClassName('username')[0].innerHTML = comment[0];
            newComment.getElementsByTagName('p')[0].innerHTML = comment[2];
			newComment.getElementsByClassName('commentDT')[0].innerHTML = comment[1];
            newComment.getElementsByClassName('ratingWrapper')[0].innerHTML = commentRatingButtons[visibleComments].innerHTML;
			newComment.getElementsByClassName('rating')[0].innerHTML = comment[3];
            commentList.innerHTML = commentList.innerHTML + "<li>" + newComment.innerHTML + "</li>"; 
            
			
    
            //New comments are created without the 'blankComment' tag. This allows them to display.
            visibleComments++;
        }
    </script>
    <script> //Javascript for the attendees
        var totalAtts = getNumOfAtts()
        function getNumOfAtts(){
			
			<?php
	
				try {
					$config = parse_ini_file("amplifydb.ini");
					$dbh = new PDO($config['dsn'], $config['username'],$config['password']);

					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					foreach ( $dbh->query("SELECT COUNT(username) FROM Attendees where eventName = '".$name."'") as $numAttendees ) {
					}
				} catch (PDOException $e) {
					print "Error!" . $e->getMessage()."<br/>";
					die();
				}	
			
			?>
			
            var num = <?php echo $numAttendees[0] ?> //replace with datacall
            if (num == 0){
                document.getElementsByClassName('attendeeList')[0].style.display = 'none';
            }
            else{
                document.getElementsByClassName('noAtts')[0].className = "hide"
            }   
            return num
        }
    </script>
    <script>// Script to keep the page scroll consistent after reloading
        /*window.addEventListener("beforeunload", function(event) {
            alert(window.scrollY);
            if (typeof('storage') != "undefined"){
                sessionStorage.setItem('scrollpos', window.scrollY);
                alert(window.scrollY);
            }
        });*/
    </script>

</body>
</html> 