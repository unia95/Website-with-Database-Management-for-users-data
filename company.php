<?php

session_start();		//avvio la sessione

include ("db.php");		//includo il mio database

$conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

//nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}



//mi assicuro nuovamente di aver inviato tutti i dati
if(isset($_POST["name"]) && isset ($_POST["place"]) && isset($_POST["site"]) && isset($_POST["email"]))
{

	$name=mysqli_real_escape_string($conn, $_POST["name"]);
	$place=mysqli_real_escape_string($conn,$_POST["place"]);  
	$site=mysqli_real_escape_string($conn,$_POST["site"]);
	$email=mysqli_real_escape_string($conn,$_POST["email"]);
	
	//sempre se tutti i dati sono stati inviati allora effettuo la query di inserimento, qui non serve molto fare il controllo se la compagnia esiste già perchè si possono scegliere una serie
	//di compagnie tramite un menù quando si va ad inserire una nuova esperienza lavorativa, quindi non credo che l'utente medio (pigro per natura) si metta ad inserire una compagnia che esiste
	//già, per questo motivo qui ho omesso la query di controllo
	
	$insert="INSERT INTO company (name, place, web, email) VALUES ('$name','$place', '$site', '$email')"; 
	$query=mysqli_query($conn, $insert);
	
}

mysqli_close($conn); 	//infine chiudo la connessione con il database


?>