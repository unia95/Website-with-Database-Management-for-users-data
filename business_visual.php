<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

  if (!isset($_SESSION['username'])) { 
  	$_SESSION['msg'] = "Devi loggare prima di poter vedere la pagina!"; //se la connessione non avviene, viene effettuato un redirect alla pagina di login che invita l'utente a loggarsi per proseguire
	header('location: login.html');
  }
  
  else{
	  
	 $query= "SELECT * FROM cards where user_id='".$_SESSION['userid']."'";
	 $result = mysqli_query($conn, $query);
	 $num_rows = mysqli_num_rows($result);
	 $res = array();
	 
	 
	 while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
	 {
		$edu_exp= "SELECT * FROM education_experience WHERE education_experience_id='".$row["education_experience_id"]."'";
		$result2= mysqli_query($conn, $edu_exp);
		
		$row2= mysqli_fetch_array($result2, MYSQLI_ASSOC);
		
		$work_exp= "SELECT * FROM work_experience WHERE work_experience_id='".$row["work_experience_id"]."'";
		$result3= mysqli_query($conn, $work_exp);
		
		while ($row4= mysqli_fetch_array($result3, MYSQLI_ASSOC)){
		
		$company= "SELECT * FROM company where company_id = '".$row4["company_id"]."'";
		$result4=mysqli_query($conn, $company);
		
		}
	 
	 
	 
		if ($row5= mysqli_fetch_array($result4, MYSQLI_ASSOC))
	{	
	  $res[] = array(
	  'card_id'=>$row['card_id'],
	  'profile_name'=>$row['title'],
      'name' => $row['name'],
	  'surname'=> $row['surname'],
      'email' => $row['email'],
	  'phone' => $row['phone'],
	  'title'=> $row2['title'],
	  'company_name'=>$row5['name']
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
  }
  
?>