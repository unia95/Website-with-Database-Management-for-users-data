<?php
session_start(); 
include("db.php"); //includo i dati del mio database

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}
 
 //mi assicuro di aver inviato tutti i dati
if(isset($_POST["title"]) && isset($_POST["year"]) && isset($_POST["place"]))
{
	$title = mysqli_real_escape_string($conn,$_POST["title"]);
	$year = mysqli_real_escape_string($conn,$_POST["year"]);
	$place = mysqli_real_escape_string($conn,$_POST["place"]);
	
	//eseguo la query di inserimento
	mysqli_query($conn, "INSERT INTO EDUCATION_EXPERIENCE(title,year, place, user_id) VALUES('$title', $year, '$place', ".$_SESSION["userid"].")") ;
			
}
?>



