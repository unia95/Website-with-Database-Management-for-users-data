<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione


  //nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

	//se ho instaurato la connessione con successo, allora eseguio una query che mi fa vedere tutte le education_experience associate all'utente loggato
	$query= "SELECT * FROM education_experience WHERE user_id=".$_SESSION["userid"]."";
	$result = mysqli_query($conn, $query);
 
	$num_rows = mysqli_num_rows($result);
  
	$res = array();

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
   $res[] = array(
	  'education_experience_id' => $row['education_experience_id'],
	  'title'=> $row['title'],
	  'year'=> $row['year'],
      'place' => $row['place'],
	  'button_1' => '',
	  'button_2' => ''
	  
	 
   );
}

$json_data = array(
                "draw"            => 1,
                "recordsTotal"    => $num_rows,
                "recordsFiltered" => $num_rows,
                "data"            => $res
            );
$json = json_encode($json_data);
echo $json;

  
?>