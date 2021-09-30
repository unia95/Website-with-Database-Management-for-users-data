<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
//se mi viene passato l'ID del meeting che voglio eliminare effettuo la query di cancellazione 
if(isset($_POST["id"]))
{
	$id = mysqli_real_escape_string($conn,$_POST["id"]);
	$query= "DELETE FROM meeting WHERE meeting_id = $id";
	mysqli_query($conn, $query);
	$query="DELETE FROM partecipate WHERE meeting_id=$id";
	mysqli_query($conn, $query);
	$query="DELETE FROM messages WHERE meeting_id = $id";
	mysqli_query($conn, $query);
		
		
		
}

?>
 