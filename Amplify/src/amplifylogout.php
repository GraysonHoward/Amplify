<?php
session_start();	//begin while still a part of the session
session_destroy();	//immediately destroy the session, effectively logging the student out of the website
header("LOCATION:amplifylogin.php");		//go to the login page
?>






