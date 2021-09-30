<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

  //se passo a questa pagina un meeting id dato da una funzione, effettuo una query che mi ritorna tutte le info di quel meeting
 if (isset ($_POST["id"])){
	
	$id= mysqli_escape_string($conn, $_POST["id"]);
	
	$query= "SELECT * FROM meeting WHERE meeting_id=$id";
	$result=mysqli_query($conn, $query);
}

//se invece non passo nessun id vuol dire che non sto eseguendo la funzione ma che sto semplicmemente visualizzando delle informazioni basilari
//riguardo i meeting, che sono quelle richieste dal mockup

else{
	$query= "SELECT * FROM meeting WHERE user_id=".$_SESSION["userid"]."";
	$result = mysqli_query($conn, $query);
 }
	$num_rows = mysqli_num_rows($result);
  
	$res = array();
	

//comunque definisco il mio vettore row e ci metto dentro il risultato di entrambe le query, nel senso che le variabili row dentro l'if e dentro l'else hanno lo stesso nome:
//dato che o viene eseguito l'if o viene eseguito l'else, a prescindere da cosa mi ritorna posso andare a mettere le tuple richieste dalla query in vettori
//che passo come oggetti json alla pagina che li ha richiesti

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
   $res[] = array(
	  'title'=> $row['title'],
      'place' => $row['place'],
	  'date'=>$row['date'],
	  'topic'=> $row['topic'],
	  'invitation'=> $row['inv'],
	  'card_id'=>$row['card_id'],
	  'language'=> $row['lang'],
	  'meeting_id'=> $row['meeting_id'],
	  'button_1'=>''
	 
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
