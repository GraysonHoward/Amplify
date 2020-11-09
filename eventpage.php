<?php
	session_start();
if (!$_SESSION["loggedin"]) {
	header("LOCATION:amplifylogin.php");
	return;
}
	$name = $_POST['name'];
	$_SESSION['eventName'] = $name;
	$_SESSION['comments'] = array();
?>




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amplify Event: <?php echo $name ?></title>
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
        
        body{
            color: white;
            background-image: radial-gradient(teal, slategrey);
            overflow-x: hidden;
            margin-top:115px;
        }
        button.inactive{
            color: slategrey;
            background-color: steelblue;
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
        /* Holds the quick-info and "i'm interested" button elements*/
        .infowrapper{
            display: flex;
            padding:  0 5% 0 5%;
            border-style: none none solid none;
            border-color: black;
        }
        .quickinfo{
            width: 100%;
        }
        .buttondiv button{
            background-color: yellow;
            padding: 5%;
            font-weight: bold;
            border-radius: 3pt;
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

        .comments ul li p{
            outline-style: solid;
            outline-width: thin;
            padding: 3pt;
            background-color: slategray;
        }

        .comments ul li{
            margin: 0 0 10pt 0;
            border-style: double;
            background-color: rosybrown;
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
            justify-content: right;
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
            <div id=logo>
                 <a href="Homepage.php">
            <img src="invislogo.png">
                </a>
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
                <li class = "blankAttendee">
                    <div class = "username">
                        username
                    </div>
                    <button class = "friend">
                        friend
                    </button>
                </li>
            </ul>
            <button class = "loadMore">
                Show more
            </button>
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
                    <p>
                        The event description goes here. It may contain several lines of text. How about that! Make sure to include relevant information here. Maybe a link to a ticket sales website? Who knows, the choice is all yours!
                    </p>
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
                    <div class = "buttondiv">
                        <button>I'm interested!</button>
                    </div>
                </div>
            </div>
            <div class = "comments">
                <h3>
                    Comments
                </h3>
                <button>Add comment</button>
                <div class = "noComments">
                    No one has commented on this event yet. Be the first to leave your thoughts!
                </div>
                <ul>
                    <li class = "blankComment">
                        <div class = "username">
                            username
                        </div>
						<div class = "commentdt">
							12
						</div>
                        <p>comment body</p>
                        <div class = "ratingWrapper">
                            <button>Like</button>
                            <div class = "rating">0</div>
                            <button>dislike</button>
                        </div>
                    </li>
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
            var num = <?php echo $numComments[0] ?> //replace with datacall
            if (num == 0){
                loadMore.className = "inactive"
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
		
        //Loads three new comments every time "load more" is clicked
        loadMore.addEventListener("click", function(){
            load3comments()
        })

        //Adds a new li to the comment list containing html for the new comment
        function displayNewComment(comment){
            var newComment = template  
            //The newComment variable is for readability purposes only. It is not necessary for functionality.
            newComment.getElementsByClassName('username')[0].innerHTML = comment[0]
            newComment.getElementsByTagName('p')[0].innerHTML = comment[2]
			newComment.getElementsByClassName('commentDT')[0].innerHTML = comment[1]
			newComment.getElementsByClassName('rating')[0].innerHTML = comment[3]
            commentList.innerHTML = commentList.innerHTML + "<li>" + newComment.innerHTML + "</li>"  
            //New comments are created without the 'blankComment' tag. This allows them to display.
            visibleComments++
        }
    </script>
    <script> //Javascript for the attendees
        var attTemplate = document.getElementsByClassName('blankAttendee')[0]
        var attendeeList = attTemplate.parentElement
        var showMore = attendeeList.parentElement.getElementsByClassName('loadMore')[0]
		var attendees = []
        var visibleAtts = 0
        var totalAtts = getNumOfAtts()

        var curattendee = ["hypotheticalAttendee"] // Adding extra information, like status or number of guests per user, could be a stretch goal


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
                showMore.className = "inactive"
             }
            else{
                document.getElementsByClassName('noAtts')[0].className = "hide"
            }   
            return num
        }
		
		<?php
			foreach ( $dbh->query("SELECT username FROM Attendees where eventName = '".$name."'") as $attendees ) {
				echo 'attendees.push(';
				echo json_encode($attendees[0]);
				echo ')';
				echo ";";
			}
		?>
		
		function getAttendee(){
			return attendees[visibleAtts]
		}
		
		function loadAttendee(){
			var attendee = [getAttendee()]
			return attendee
		}
		
        //Loads 20 attendees automatically
        for (var i = 0; i < 20; i++){
           if (visibleAtts < totalAtts){
                 displayNewAttendee(loadAttendee())
           }
          if(visibleAtts == totalAtts){
                showMore.className = "inactive"
          }   
        }

        //Loads an additional 20 attendees when "show more" is clicked
        showMore.addEventListener("click", function(){
         for (var i = 0; i < 20; i++){
              if (visibleAtts < totalAtts){
                  displayNewAttendee(loadAttendee())
                }
               if(visibleAtts == totalAtts){
                    showMore.className = "inactive"
                }   
            }
        })

        //Displays the next attendee
        function displayNewAttendee(attendee){
            attTemplate.getElementsByClassName('username')[0].innerHTML = attendee[0]
            attendeeList.innerHTML = attendeeList.innerHTML + "<li>" + attTemplate.innerHTML + "</li>" 
            visibleAtts++
        }
    </script>

</body>
</html> 