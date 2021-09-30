<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
if(isset($_POST["user_id"]) && isset($_POST["meeting_id"])){
	$user_id=$_POST["user_id"];
	foreach($user_id as $userid){
		$userid = mysqli_real_escape_string($conn,$userid);
		$meeting_id = mysqli_real_escape_string($conn,$_POST["meeting_id"]);
	
		$query="INSERT INTO messages (user_id_invito, meeting_id) VALUES($userid, $meeting_id)";
		mysqli_query($conn, $query);
	}
}

?>