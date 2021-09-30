<?php

session_start(); 
include("db.php"); //includo i dati del mio database

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

if(isset($_POST["username"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["birthdate"]) && isset($_SESSION["userid"]))
{
	$username=mysqli_real_escape_string($conn,$_POST["username"]);  
	$firstname=mysqli_real_escape_string($conn,$_POST["firstname"]);
	$surname=mysqli_real_escape_string($conn,$_POST["lastname"]);
	$email=mysqli_real_escape_string($conn,$_POST["email"]);
	$password=mysqli_real_escape_string($conn,$_POST["password"]);
	$password = md5($password);		//la password è criptata e in tutto il sito non è mai possibile vederla in chiaro
	$birthdate=mysqli_real_escape_string($conn,$_POST["birthdate"]);
	if(isset($_FILES['profile_picture'])){
		$json = json_encode($_FILES['profile_picture']);
        echo $json;
		echo $_FILES['profile_picture']['tmp_name'];
		move_uploaded_file($_FILES['profile_picture']['tmp_name'], "uploads/".$_FILES['profile_picture']['name']);
		if(file_exists("uploads/".$_SESSION["userid"].".jpg")){
			unlink("uploads/".$_SESSION["userid"].".jpg");
		}
		rename('uploads/'.$_FILES['profile_picture']['name'], "uploads/".$_SESSION["userid"].".jpg");
	}
	
	
	$user_check = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username'");		//eseguo la query per controllare che non ci siano presenti utenti con lo stesso username
	$mail_check= mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");					//qui controllo che non siano presenti utenti con la stessa mail
	
	if (mysqli_num_rows($user_check) && $username != $_SESSION["username"])			//nel caso siano stati trovati utenti con lo stesso username(email) nel database che sia anche diverso da quello dell'utente
	{																				//loggato in quel momento, allora l'utente non può procedere e l'update non viene fatto
		echo "Cannot update, username already exists";
	}
	
	elseif (mysqli_num_rows($mail_check) && $email != $_SESSION["email"])
	{
		echo "Cannot update, e-mail already exists";
	}
	
	//se tutto va a buon fine e quindi non sono presenti nel db username o email ripetute diverse da quelle dell'utente loggato in quel momento, allora si procede all'update effettivo
	else {
		mysqli_query ($conn,"UPDATE account SET passw='".$password."', username='".$username."' WHERE user_id=".$_SESSION["userid"]);
		mysqli_query ($conn,"UPDATE users SET name='".$firstname."', surname='".$surname."', birth='".$birthdate."', email='".$email."'  WHERE user_id=".$_SESSION["userid"]);
	    header('location: login.html');		//alla fine l'utente viene reindirizzato alla pagina di login perchè deve loggare nuovamente per vedere le modifiche apportate
	}
}

else {
	echo "An error has occured, please try again<br>";		//inserisco un controllo che nel caso anche uno solo dei dati post non sia presente, allora stampo un messaggio di errore
}

?>
<br><input type="button" value="Indietro" onclick="window.location.href='update_info.php'" /><br>
<br><input type="button" value="Torna alla Home" onclick="window.location.href='index.php'" /><br>

