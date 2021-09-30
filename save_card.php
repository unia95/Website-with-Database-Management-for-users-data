<?php

session_start();		//avvio la sessione

include ("db.php");		//includo il mio database

$conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

//nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

 
 //mi assicuro di aver inviato tutti i dati
if (isset($_POST["title"])&& isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["edu_exp_id"]) && isset($_POST["working_exp_id"]))
{
	$title=mysqli_real_escape_string($conn,$_POST["title"]); 
	$name=mysqli_real_escape_string($conn,$_POST["name"]);	
	$surname=mysqli_real_escape_string($conn,$_POST["surname"]);
	$email=mysqli_real_escape_string($conn,$_POST["email"]);
	$phone=mysqli_real_escape_string($conn,$_POST["phone"]);
	$education_experience_id=mysqli_real_escape_string($conn,$_POST["edu_exp_id"]);
	$work_experience_id=mysqli_real_escape_string($conn,$_POST["working_exp_id"]);
	$userid=$_SESSION["userid"];
	//effettuo la query di inserimento
	mysqli_query($conn, "INSERT INTO cards(user_id, title, name, surname, email, phone, education_experience_id, work_experience_id) values ($userid, '$title', '$name', '$surname', '$email', '$phone', '$education_experience_id', '$work_experience_id')");
	
	$logo_query="SELECT * FROM cards WHERE education_experience_id=$education_experience_id AND work_experience_id=$work_experience_id";
	$result=mysqli_query($conn, $logo_query);
	$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
	 
	if(isset($_FILES['logo'])){
		$json = json_encode($_FILES['logo']);
        echo $json;
		echo $_FILES['logo']['tmp_name'];
		move_uploaded_file($_FILES['logo']['tmp_name'], "logos/".$_FILES['logo']['name']);
		if(file_exists("logos/".$row["card_id"].".jpg")){
			unlink("logos/".$row["card_id"].".jpg");
		}
		rename('logos/'.$_FILES['logo']['name'], "logos/".$row["card_id"].".jpg");
	}
	
	
	
	
	
	
	
	
		
		
}
?>
 
 