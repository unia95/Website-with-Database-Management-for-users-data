<?php

session_start();		//avvio la sessione

include ("db.php");		//includo il mio database

$conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

//nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

 

 
//faccio la query per vedere a quali meeting partecipa o è il creatore l'user connesso
$result = mysqli_query($conn, "SELECT * FROM company");
 
$num_rows = mysqli_num_rows($result);
  
$res = array();

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
	
      $res[] = array(
      'company_id' => $row['company_id'],
	  'name' => $row['name'],
	  'button_3'=>''
   );
	}

$json = json_encode($res);
echo $json;
?>