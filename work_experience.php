<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
 //mi assicuro che siano arrivati tutti i dati
 if(isset($_POST["company"]) && isset($_POST["role"]) && isset($_POST["year"]) && isset($_POST["place"]))
{
	$company_id = mysqli_real_escape_string($conn,$_POST["company"]);
	$role = mysqli_real_escape_string($conn,$_POST["role"]);
	$year = mysqli_real_escape_string($conn,$_POST["year"]);
	$place = mysqli_real_escape_string($conn,$_POST["place"]);
	
	//se tutti i dati sono stati passati correttamente allora effettuo la query di inserimento
	mysqli_query($conn, "INSERT INTO work_experience(company_id, user_id, role, year, place) VALUES($company_id, ".$_SESSION['userid'].", '$role', $year, '$place')");
	
}
?>