<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
	  
	  
	 //qui devo selezionare tutte le esperienze lavorative attribuibili ad un cliente. Quindi faccio la query e mi trovo row che mi trasforma il risultato della query in un array
	 $query= "SELECT * FROM work_experience where user_id='".$_SESSION['userid']."'";
	 $result = mysqli_query($conn, $query);
	 $num_rows = mysqli_num_rows($result);
	 $res = array();
	 
	 
	 while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
	 {	//utilizzo questa query per fare in modo che anzichè l'ID della compagnia mi appaia il nome della compagnia. Mi prendo l'ID dalla row della work experience e poi in row2 metto
//solo il nome della compagnia. 
		$select_company= "SELECT * FROM company WHERE company_id='".$row["company_id"]."'"; 
		$result2= mysqli_query($conn, $select_company);
	 
	 
	 
		if ($row2= mysqli_fetch_array($result2, MYSQLI_ASSOC))
	{	//mette i dati in degli array, prendendoli dal database
	  $res[] = array(
	  'work_experience_id'=>$row['work_experience_id'],
      'company' => $row2['name'],
	  'role'=> $row['role'],
      'year' => $row['year'],
	  'place' => $row['place'],
	  'button_1'=> '',
	  'button_2'=> ''
   );
	}
}
	 
//prende nuovamente i dati e li prepara per codificarli
$json_data = array(
                "draw"            => 1,
                "recordsTotal"    => $num_rows,
                "recordsFiltered" => $num_rows,
                "data"            => $res
            );
$json = json_encode($json_data); //codifica i dati json
echo $json;
  
?>