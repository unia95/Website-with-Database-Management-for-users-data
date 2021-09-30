<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
	//mi assicuro di aver inviato tutti i dati
	if(isset($_POST["title"]) && isset($_POST["year"]) && isset($_POST["place"]) && isset($_POST["id"]))
	{
	$id = mysqli_real_escape_string($conn,$_POST["id"]);
	$title = mysqli_real_escape_string($conn,$_POST["title"]);
	$year = mysqli_real_escape_string($conn,$_POST["year"]);
	$place = mysqli_real_escape_string($conn,$_POST["place"]);
	
	//effettuo la query di update
	mysqli_query($conn, "UPDATE education_experience SET title = '$title', year = $year, place = '$place' WHERE education_experience_id = $id");
		
		
}

?>