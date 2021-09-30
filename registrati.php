<?php
session_start();		//avvio la sessione

include ("db.php");		//includo il mio database

$conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

//nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}



//mi assicuro nuovamente di aver inviato tutti i dati
if(isset($_POST["username"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["birthdate"])){

	//attraverso il metodo POST passo tutte le variabili che avevo preso dalla pagina "registrazione.html", e con la funzione mysqli_real_escape_string mi proteggo dall' SQL injection
	$username=mysqli_real_escape_string($conn,$_POST["username"]);  
	$firstname=mysqli_real_escape_string($conn,$_POST["firstname"]);
	$lastname=mysqli_real_escape_string($conn,$_POST["lastname"]);
	$email=mysqli_real_escape_string($conn,$_POST["email"]);
	$password=mysqli_real_escape_string($conn,$_POST["password"]);
	$birthdate=mysqli_real_escape_string($conn,$_POST["birthdate"]);
	$password = md5($password);
	
	$error=0;	//setto questa variabile che mi servirà dopo per effettuare la transazione. Infatti, se inserisco una mail o un username già presenti nel database mi 
	//ritorna un messaggio di errore e non esegue la transazione. Così non incremento neanche l'indice nel caso la transazione non andasse a buon fine
	$user_check = "SELECT * FROM account WHERE username = '$username'";		//eseguo la query per controllare che non ci siano presenti utenti con lo stesso username
	$result = mysqli_query($conn, $user_check);
	
	$errmsg=""; //setto questa variabile che nel caso di inserimenti di username o email duplicate, mi dice quale delle due cose devo modificare
	if (mysqli_num_rows($result)!=0) { //in questo caso stampo il messaggio di errore solo se la query ritorna un numero maggiore di 0 di righe, perchè un numero maggiore di 0 implica che ho trovato un username uguale nel mio database
      $errmsg=$errmsg."Username già esistente; <br> ";
	  $error=1; //setto questa variabile=1 così da uscire dal programma senza inserire nulla nel mio database in caso di username già presente
    }

	//eseguo lo stesso codice anche nel caso della mail, per vedere se ci sono già utenti che hanno la stessa mail nel database
	$user_check2= "SELECT * FROM users WHERE email='$email'";
	$result2 = mysqli_query($conn, $user_check2);
  
  
    if(mysqli_num_rows($result2)!=0) {
      $errmsg=$errmsg."Email già esistente; <br> ";
	  $error=1;
    }
	
	//in questo caso non ho trovato utenti con username o email già presenti nel database e allora inserisco il nuovo utente, error==0 perchè non si è verificata nessuna delle condizioni precedenti.
	if ($error==0){
		mysqli_autocommit($conn, FALSE);
	
		//eseguo la query per inserire in account, non metto l'id perchè si va ad incrementare ed inserire automaticamente ad ogni inserimento, quindi non devo controllarlo io
		$query="INSERT INTO account(activation_date, passw, username) values(curdate(), '$password', '$username')";
		
		//vado ad inserire anche su un'altra tabella per cui mi assicuro prima che il primo inserimento sia andato a buon fine, altrimenti effettuo il rollback
		if (mysqli_query($conn,$query)) { 
			$last_id=mysqli_insert_id($conn);	//uso questa funzione per passare l'ID nella tabella
			$query2="INSERT INTO users(user_id, name, surname, birth, email) values('$last_id','$firstname', '$lastname', '$birthdate', '$email')";
			if (!mysqli_query($conn, $query2)) {		//se qualcosa va storto, esco ed effettuo il rollback
				mysqli_rollback($conn);
			}
			mysqli_commit($conn);		//in questo caso entrambe le query sono state eseguite e allora stampo un messaggio di avvenuta registrazione
			echo "Registrazione avvenuta con successo!";
		}
	}
	
	//se la prima query trova dati già presenti allora stampo un messaggio di errore, che mi dice che la mail e/o la password sono già presenti
	else{
		echo "<p style='font-size:30px;'>Si è verificato un errore: </p><br>".$errmsg;
	}
	
}

else {
	echo "<p style='font-size:30px;'> Si è verificato un errore, non puoi accedere a questa pagina! </p><br>";	//inserisco un controllo che nel caso anche uno solo dei dati post non sia presente, allora stampo un messaggio di errore
}
	
	?> 
		<br><input type="button" value="Torna alla registrazione" onclick="window.location.href='registrazione.html'" /> <!--inserisco un bottone che reindirizza alla pagina di registrazione -->
		<br><input type="button" value="Effettua il login" onclick="window.location.href='login.html'" /> <!--inserisco un bottone che reindirizza alla pagina di login -->

<?php

mysqli_close($conn); 	//infine chiudo la connessione con il database


?>