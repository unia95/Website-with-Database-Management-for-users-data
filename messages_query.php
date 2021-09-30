<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
 
//if(isset($_SESSION["userid"]))
//{
	$userid=$_SESSION["userid"];
	$query="SELECT * FROM messages WHERE user_id_invito=$userid";
	$res1=mysqli_query($conn,$query);
	$numrows=mysqli_num_rows($res1);
	if ($numrows ==0){
			$res=array();
		
	}
	
	
	else{
		while($row1=mysqli_fetch_array($res1,MYSQLI_ASSOC)){
			$meeting_id=$row1['meeting_id'];
			$query2="SELECT * FROM meeting WHERE meeting_id=$meeting_id";
			$res2=mysqli_query($conn, $query2);
			while($row2=mysqli_fetch_array($res2, MYSQLI_ASSOC)){
				$user_id=$row2['user_id'];
				$query3="SELECT * FROM account WHERE user_id=$user_id";
				$res3=mysqli_query($conn, $query3);
				while ($row3=mysqli_fetch_array($res3, MYSQLI_ASSOC)){
					$res[] = array(
					'profile_name'=>$row3['username'],
					'place' => $row2['place'],
					'topic'=> $row2['topic'],
					'date'=> $row2['date'],
					'button_1' => '',
					'message_id'=>$row1['message_id'],
					'meeting_id'=>$meeting_id
					);
				}

			}
		}
	}
$json_data = array(
                "draw"            => 1,
                "recordsTotal"    => $numrows,
                "recordsFiltered" => $numrows,
                "data"            => $res
            );
$json = json_encode($json_data);
echo $json;
	


?>