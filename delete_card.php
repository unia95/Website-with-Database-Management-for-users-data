<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
 //se prendo l'ID della business card da eliminare effettuo la query di cancellazione
if(isset($_POST["id"]))
{
	$id = mysqli_real_escape_string($conn,$_POST["id"]);
	$query= "DELETE FROM cards WHERE card_id = $id";
	mysqli_query($conn, $query);
	
		
		
		
}