<?php
	session_start();
    if (!$_SESSION["loggedin"]) {
	    header("LOCATION:amplifylogin.php");
	    return;
    }
    try{
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['publishNew'])) {
            $config = parse_ini_file("amplifydb.ini");
            $dbh = new PDO($config['dsn'], $config['username'],$config['password']);
        
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Prepares user input to be entered into the database
            date_default_timezone_set('EST');
            $date = date($_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'].' '.$_POST['hour'].':'.$_POST['minute'].':00'); //to be changed to user-selected date
            $eDescription = trim(filter_var($_POST['eDesc'], FILTER_SANITIZE_STRING));
            $eventHost = $_SESSION["userid"];
            $rating = 0;
            $name = trim(filter_var($_POST['eName'], FILTER_SANITIZE_STRING));
            $location = trim(filter_var($_POST['eLocation'], FILTER_SANITIZE_STRING));
            $image = trim(filter_var($_POST['eImage'], FILTER_SANITIZE_STRING));
            $invalid = array(0,0,0); //{name_error, date_error, image_error}

            foreach ( $dbh->query("SELECT eventName FROM Events") as $names) {
                if (strcmp($names[0], $name) == 0){
                    $invalid[0] = 1;
                }
            }
            if (strlen($_POST['day']) == 0 || checkdate($_POST['month'], $_POST['day'], $_POST['year']) == false || $date <= date('Y-m-d H:i:s')) {
                $invalid[1] = 1;
            }
            if(strlen($eDescription) < 20 || strlen($name) < 5 || strlen($location) < 5){
                $invalid[2] = 1;
            }

            if ($invalid[0] == 0 && $invalid[1] == 0 && $invalid[2] == 0) {
                $stmt = $dbh->prepare("INSERT INTO Events(eventName, date, location, eventHost, bio, rating, image) VALUES(?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $date, $location, $eventHost, $eDescription, $rating, $image]);

                $_POST['eventName'] = $name;
                header("LOCATION:eventpage.php");
                return;
            }
        }
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage()."<br/>";
        die();
    }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>Publish new Event</title>
    <link rel="shortcut icon" type="image/jpg" href="favicon.ico"/>
    <style>
        body{
            color: white;
            background-image: radial-gradient(teal, slategrey);
            overflow-x: hidden;
            min-height: 300px;
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
            min-height: 700px;
        }

        #buttonArea{
            display: flex;
            justify-content: flex-end;
            padding: 3pt 0 3pt 0;
        }

        #center{
			margin-top:225px;
	    }

        .errorMessage{
            color: yellow;
        }

        #publishPane {
            border-radius: 25px;
            border-style: solid;
            border-width: thin;
            background-color: black;
            padding: 20px;
            width: 75%;
            height: auto;
            position: block;
            vertical-align: center;
            margin: auto;
            text-align: center;
        }

        h1{
            margin: 0px;
            margin-bottom: 30px;
        }

        #hour_select{
            margin-left: 20px;
        }

        #publishTop {
            display: flex;
        }

        #imageInput{
            flex-basis: 34%;
            margin-left: 10%;
            margin-right: 10%;
        }

        #inputs{
            flex-basis: 66%;
            display: grid;
            grid-template-columns: 1fr 4fr;
        }


        .LineInput{
            display: flex;
            margin: auto;
        }

        .inputbox{
            width: 100%;
        }

        #description textarea{
            max-width: 80%;
            min-width: 80%;
        }

        .inputLineContainer{
            display: flex;
            margin: auto;
            flex-direction: column;
            width: 80%;
        }

        @media screen and (max-width: 1100px){
            #publishTop{
                display: block;
            }
            .dateInput{
                display: block;
            }
        }
    </style>
</head>
<body>
    <div id=banner >
        <div id=logo>
            <a href="Homepage.php">
                <img src="invislogo.png">
            </a>
        </div>
    </div>
    <div class = "content box">
        <div id = 'center'>
            <div id = "publishPane">
                <form method = "post" action = "publishEvent.php">
                <h1>
                    Publish an event:
                </h1>
                <div id = "publishTop">
                    <div id = 'imageInput'>
                        <h3>Image URL</h3>
                        <div><?php
                        echo "<input type = 'text' class = 'inputbox' name = 'eImage' minlength = '5' maxlength = '500'>";
                        if (isset($_POST['publishNew'])){
                            echo $image;
                        }
                        ?></div>
                    </div>
                    <div id = 'inputs'>
                        <h3>Event Name</h3>
                        <div class = "inputLineContainer">
                            <?php
                            echo "<input required type = 'text' class = 'inputbox' name = 'eName' minlength = '5' maxlength = '50' ";
                            if (isset($_POST['publishNew'])){                
                                echo "value = '".$name."' ";
                            }
                            echo "/>";
                            if (isset($_POST['publishNew'])){                
                                if ($invalid[0] == 1){
                                    echo "<div class = 'errorMessage'>Name taken. Please choose another.</div>";
                                }
                            }
                            ?>
                        </div>
                        <h3>Date/Time</h3>
                        <div class = "inputLineContainer">
                            <div class = "LineInput dateInput">
                                <select name = 'month'>
                                    <option value="0">Month...</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>

                                <input type = "text" size = "2" maxLength = "2" name = "day"></input>

                                <select name = 'year'>
                                    <option value="0">Year...</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                </select>

                                <select name = 'hour' id = "hour_select">
                                <option value="">Hour...</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                </select>

                                <select name = 'minute'>
                                <option value="">Min...</option>
                                    <option value="00">00</option>
                                    <option value="05">05</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                </select>
                            </div>
			                <?php
			                if (isset($_POST['publishNew'])){                
                                if ($invalid[1] == 1){
                                    echo "<div class = 'errorMessage'>Date invalid or has passed. Please choose a different date/time.</div>";
                                }
                            }?>
                        </div>
                        <h3>Location</h3>
                        <div class = "inputLineContainer">
                            <?php
                            echo "<input required type = 'text' class = 'inputbox' name = 'eLocation' minlength = '5' maxlength = '50' ";
                            if (isset($_POST['publishNew'])){
                                echo "value = '".$location."' ";
                            }
                            echo "/>";
                        ?></div>
                    </div>
                </div>
                <div id = 'description'>
                    <h4>
                        Write an event description. Remember to include all the information you want users to know about your event, like admission price.
                    </h4>
                    <div class = "textin">
                        <textarea required name = 'eDesc' minlength = '20' maxlength = '500'><?php
                        if (isset($_POST['publishNew'])){
                        echo $eDescription;
                        }
                        ?></textarea>
                    </div>
                </div>
                <div id = "buttonArea">
                    <button class = "" name = "publishNew">Publish</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>