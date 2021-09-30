<?php
session_start();	//avvio la sessione

include("db.php"); //includo i dati del mio database

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

//nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}



//Mi assicuro nuovamente di aver mandato i dati alla pagina
if(isset($_POST["username"]) && isset($_POST["password"]))
{
	//Prendo i dati passati dalla pagina login.html
	$username = $_POST["username"];
	$password = $_POST["password"];
	$password = md5($password);
	
	//Vedo se nel mio database c'è una coppia nome utente-password valida
	$query = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username' AND passw = '$password'");	
	$control = mysqli_fetch_array($query, MYSQLI_ASSOC);
	
	if($control){		//se trovo la mia coppia allora reindirizzo ad un'altra pagina dove posso fare le varie operazioni dopo aver loggato
		$result=mysqli_query($conn, "SELECT * FROM users WHERE user_id= ".$control["user_id"]);
		$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		$_SESSION["userid"]=$control["user_id"];
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
		$_SESSION["name"]=$row["name"];
		$_SESSION["surname"]=$row["surname"];
		$_SESSION["email"]=$row["email"];
		$_SESSION["birth"]=$row["birth"];
		header('location: index.php');
	}
	else { 		//se qualcosa va storto stampo questo messaggio e un bottone mi reindirizza alla pagina di login
		echo "<p style='font-size:30px;'>Utente non trovato</p><br>";
		echo "<br><a href='login.html'>Torna al login</a>";
	}
}

else {
	header('location: login.html');
}
?>		