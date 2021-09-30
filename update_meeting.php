<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
 
if(isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["date"]) && isset($_POST["place"]))
{
	$id= mysqli_real_escape_string($conn, $_POST["id"]);
	$title = mysqli_real_escape_string($conn,$_POST["title"]);	
	$date = mysqli_real_escape_string($conn,$_POST["date"]);
	$place = mysqli_real_escape_string($conn,$_POST["place"]);
	
	$update="UPDATE meeting SET title='$title', place= '$place', date='$date' WHERE meeting_id=$id";
	$query= mysqli_query($conn, $update);
	echo "Done";
	
		
}


?>