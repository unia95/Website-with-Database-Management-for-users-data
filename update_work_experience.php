<?php

session_start();		//avvio la sessione

include ("db.php");		//includo il mio database

$conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

//nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

//mi assicuro nuovamente di aver inviato tutti i dati 
 if(isset($_POST["company_id"]) && isset($_POST["role"]) && isset($_POST["year"]) && isset($_POST["place"]) && isset($_POST["id"]))
	 
{
	//metto un nome alle variabili e faccio l'inserimento in tabella
	$id = mysqli_real_escape_string($conn,$_POST["id"]);
	$company_id = mysqli_real_escape_string($conn,$_POST["company_id"]);
	$role = mysqli_real_escape_string($conn,$_POST["role"]);
	$year = mysqli_real_escape_string($conn,$_POST["year"]);
	$place = mysqli_real_escape_string($conn,$_POST["place"]);
	
	//query di inserimento
	mysqli_query($conn, "UPDATE WORK_EXPERIENCE set company_id =$company_id, role = '$role', year = $year, place = '$place' where work_experience_id = $id");
}

?>