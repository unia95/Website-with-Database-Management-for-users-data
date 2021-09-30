<?php

session_start(); 

  include ("db.php");		//includo il mio database
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
 
	//mi assicuro di aver inviato tutti i dati
if (isset($_POST["title"])&& isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["edu_exp_id"]) && isset($_POST["working_exp_id"]) && isset($_POST["id"]))
{
	$card_id=mysqli_real_escape_string($conn, $_POST["id"]);
	$title=mysqli_real_escape_string($conn,$_POST["title"]); 
	$name=mysqli_real_escape_string($conn,$_POST["name"]);	
	$surname=mysqli_real_escape_string($conn,$_POST["surname"]);
	$email=mysqli_real_escape_string($conn,$_POST["email"]);
	$phone=mysqli_real_escape_string($conn,$_POST["phone"]);
	$education_experience_id=mysqli_real_escape_string($conn,$_POST["edu_exp_id"]);
	$work_experience_id=mysqli_real_escape_string($conn,$_POST["working_exp_id"]);
	$userid=$_SESSION["userid"];
	
	//effettuo la query di update
	mysqli_query($conn, "UPDATE cards SET user_id=$userid, title='$title', name='$name', surname='$surname', email='$email', phone=$phone, education_experience_id=$education_experience_id, work_experience_id=$work_experience_id WHERE card_id= $card_id");
		
		
}

?>