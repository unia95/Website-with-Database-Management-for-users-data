<?php
session_start(); 
include("db.php"); //includo i dati del mio database

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}


if (isset($_POST["meeting_id"]) && isset($_POST["rated_user"]) && isset($_POST["submitStars_1"]) && isset($_POST["submitStars_2"]) && isset($_POST["submitStars_3"]) && isset($_POST["text2"])){
	
	$userid=$_SESSION["userid"];
	$meeting_id= mysqli_real_escape_string($conn, $_POST["meeting_id"]);
	$rated_user= mysqli_real_escape_string($conn, $_POST["rated_user"]);
	$text= mysqli_real_escape_string($conn, $_POST["text2"]);
	$rating=mysqli_real_escape_string($conn, $_POST["submitStars_1"]);
	$rating2= mysqli_real_escape_string($conn, $_POST["submitStars_2"]);
	$rating3= mysqli_real_escape_string($conn, $_POST["submitStars_3"]);
	
	
	$control="SELECT * FROM user_rating WHERE meeting_id=$meeting_id AND rated_user=$rated_user";
	$control_query=mysqli_query($conn, $control);
	$row_count=mysqli_num_rows($control_query);

	if ($row_count==0){

		$query="INSERT INTO user_rating (user_id, meeting_id, rated_user, note, professionality, availability, impression) VALUES ($userid, $meeting_id, $rated_user, '$text', $rating, $rating2, $rating3)";
		mysqli_query($conn, $query);
		echo "Submitted!";
	}
	
	
	else {
		echo"Sorry, you can't rate a user two times";
	}
	
}



mysqli_close($conn);
?>