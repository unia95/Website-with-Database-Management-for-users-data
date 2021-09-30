<?php

session_start();		//avvio la sessione

include ("db.php");		//includo il mio database

$conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

//nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

 

 
//mi prendo tutte le compagnie che ho inserito nel database
$result = mysqli_query($conn, "SELECT * FROM company");
 
$num_rows = mysqli_num_rows($result);
  
$res = array();

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) //prendo gli array corrispondenti alle informazioni che mi servono
{
	
      $res[] = array(
      'company_id' => $row['company_id'],
	  'name' => $row['name'],
	  'button_3'=>''
   );
	}
//passo i dati come oeggetti json
$json = json_encode($res);
echo $json;
?>