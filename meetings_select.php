<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione


  //nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}


if (isset ($_POST["id"])){
	
	$id= mysqli_escape_string($conn, $_POST["id"]);
	
	$query= "SELECT * FROM meeting WHERE meeting_id=$id";
	$res=mysqli_query($conn, $query);
	
	echo $id;
	
}


?>