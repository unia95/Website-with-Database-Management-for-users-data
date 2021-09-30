<?php
session_start(); 
include("db.php"); //includo i dati del mio database

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}


if (isset($_POST["meeting_id"]) && isset($_POST["submitStars"]) && isset($_POST["submitStars2"]) && isset($_POST["text"])){
	
	$userid=$_SESSION["userid"];
	$meeting_id= mysqli_real_escape_string($conn, $_POST["meeting_id"]);
	$text= mysqli_real_escape_string($conn, $_POST["text"]);
	$rating=mysqli_real_escape_string($conn, $_POST["submitStars"]);
	$rating2= mysqli_real_escape_string($conn, $_POST["submitStars2"]);
	
	$select= "SELECT * FROM meeting where meeting_id=$meeting_id";
	$result= mysqli_query($conn, $select);
	$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
	$card_id= $row["card_id"];
	
	$control="SELECT * FROM wallet WHERE user_id=$userid AND meeting_id=$meeting_id";
	$control_query=mysqli_query($conn, $control);
	$row_count=mysqli_num_rows($control_query);

	if ($row_count==0){

		$query="INSERT INTO wallet (user_id, meeting_id, card_id, note, rating_usefull, rating_importance) VALUES ($userid, $meeting_id, $card_id, '$text', $rating, $rating2)";
		mysqli_query($conn, $query);
		echo "Submitted!";
	}
	
	
	else {
		echo"Sorry, you can't rate a meeting two times";
	}
	
}



mysqli_close($conn);
?>