<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
  
  
if(isset($_SESSION["userid"])){
	
	if (isset ($_POST["id"])){
	
	$id= mysqli_escape_string($conn, $_POST["id"]);
	
	$query= "SELECT * FROM meeting WHERE meeting_id=$id";
	$result=mysqli_query($conn, $query);
	$num_rows = mysqli_num_rows($result);
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$res[] = array(
					  'title'=> $row['title'],
      'place' => $row['place'],
	  'date'=>$row['date'],
	  'topic'=> $row['topic'],
	  'invitation'=> $row['inv'],
	  'card_id'=>$row['card_id'],
	  'language'=> $row['lang'],
	  'meeting_id'=> $row['meeting_id'],
				'role' => 'C',
				 'button_1'=>'');
		;
	}
}

else{
	
	$num_rows=0;
	$userid = mysqli_real_escape_string($conn,$_SESSION["userid"]);
	$query="SELECT * FROM meeting WHERE user_id=$userid";
	$result=mysqli_query($conn, $query);
	$num_rows1 = mysqli_num_rows($result);
	$res = array();
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$res[] = array(
					  'title'=> $row['title'],
      'place' => $row['place'],
	  'date'=>$row['date'],
	  'topic'=> $row['topic'],
	  'invitation'=> $row['inv'],
	  'card_id'=>$row['card_id'],
	  'language'=> $row['lang'],
	  'meeting_id'=> $row['meeting_id'],
				'role' => 'C',
				 'button_1'=>'');
		$num_rows=$num_rows+$num_rows1;
	}
	$query="SELECT * FROM partecipate WHERE user_id=$userid";
	$result=mysqli_query($conn, $query);
	$m_id=array();
	while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
		array_push($m_id, $row['meeting_id']);
	}
	foreach($m_id as $meeting_id){
		$query="SELECT * FROM meeting WHERE meeting_id=$meeting_id";
		$result2=mysqli_query($conn, $query);
		$num_rows2 = mysqli_num_rows($result2);
		while($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
			$res[] = array(
					  'title'=> $row['title'],
      'place' => $row['place'],
	  'date'=>$row['date'],
	  'topic'=> $row['topic'],
	  'invitation'=> $row['inv'],
	  'card_id'=>$row['card_id'],
	  'language'=> $row['lang'],
	  'meeting_id'=> $row['meeting_id'],
				'role' => 'P',
				 'button_1'=>''
			);
		}
		$num_rows=$num_rows+$num_rows2;
	}
}

$json_data = array(
                "draw"            => 1,
                "recordsTotal"    => $num_rows,
                "recordsFiltered" => $num_rows,
                "data"            => $res
            );
$json = json_encode($json_data);
echo $json;
}

?>