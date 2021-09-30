<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
 
if(isset($_POST["id"]) && isset($_POST["meeting_id"]))
{
	$userid=$_SESSION['userid'];
	$meeting_id=mysqli_real_escape_string($conn, $_POST["meeting_id"]);
	$id = mysqli_real_escape_string($conn,$_POST["id"]);	
	
	$query1="SELECT * FROM meeting WHERE meeting_id=$meeting_id";
	$res1=mysqli_fetch_array(mysqli_query($conn, $query1));
	$card_id=$res1['card_id'];
	$query3="INSERT INTO partecipate(user_id, meeting_id, card_id) VALUES($userid, $meeting_id, $card_id)";
	mysqli_query($conn, $query3);
	$query= "DELETE FROM messages WHERE message_id =$id";
	mysqli_query($conn, $query);
	
		
		
}


?>