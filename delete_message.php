<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
 //se dalla funzione riesco a prendere l'ID del messaggio lo elimino
if(isset($_POST["id"]))
{
	$id = mysqli_real_escape_string($conn,$_POST["id"]);
	$query= "DELETE FROM messages WHERE message_id = $id";
	mysqli_query($conn, $query);
	
		
		
		
}

else{
	echo "Errore";
}

?>