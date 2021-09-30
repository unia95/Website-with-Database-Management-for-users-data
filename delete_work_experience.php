<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
 
 //se ho passato l'ID dell'esperienza lavorativa eseguo la query di eliminazione
if(isset($_POST["id"]))
{
	$id = mysqli_real_escape_string($conn,$_POST["id"]);
	mysqli_query($conn, "DELETE FROM WORK_EXPERIENCE WHERE work_experience_id = '".$id."'");
	
		
		
		
}
 
 
?>