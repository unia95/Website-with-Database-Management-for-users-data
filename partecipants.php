<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione


  //else{
	   
	  
	 $user_id=$_SESSION["userid"];
	 $query= "SELECT * FROM users where user_id <> '".$_SESSION['userid']."'";
	 $result = mysqli_query($conn, $query);
	 $num_rows = mysqli_num_rows($result);
	 $res = array();
	 
	 
	 while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
	 {
		$select= "SELECT * FROM work_experience where user_id<>$user_id";
		$result2= mysqli_query($conn, $select);
		
		
		
		$select_company= "SELECT * FROM company";
		$result3= mysqli_query($conn, $select_company);
		$row2= mysqli_fetch_array($result2, MYSQLI_ASSOC);
	 
			if ( $row3= mysqli_fetch_array($result3, MYSQLI_ASSOC) )
				{	
					$res[] = array(
					'user_id'=>$row['user_id'],
					'name'=> $row['name'],
					'company' => $row3['name'],
					'role'=> $row2['role'],
					'button_1'=> ''
					);
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
  //}