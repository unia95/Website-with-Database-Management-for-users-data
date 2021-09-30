<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
 //se riesco a prendere l'ID della education_experience allora la passo alla query di cancellazione ed elimino l'education experience corrispondente all'ID che ho passato
if(isset($_POST["id"]))
{
	$id = mysqli_real_escape_string($conn,$_POST["id"]);
	$query= "DELETE FROM education_experience WHERE education_experience_id = $id";
	mysqli_query($conn, $query);
	
		
		
		
}

else{
	echo "Errore";
}

?>
 
 
 
