<?php

session_start();		//avvio la sessione

include ("db.php");		//includo il mio database

$conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

//nel caso non possa instaurare una connessione stampo un messaggio di errore
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}
$res=array();

//mi assicuro nuovamente di aver inviato tutti i dati
if(isset($_POST["title"]) && isset($_POST["place"]) && isset($_POST["date"]) && isset($_POST["topic"]) && isset($_POST["card_id"]) && isset($_POST["lang"]) && isset($_POST["inv"]) )
{
	$title=mysqli_real_escape_string($conn,$_POST["title"]);  
	$place=mysqli_real_escape_string($conn,$_POST["place"]);
	$date=mysqli_real_escape_string($conn,$_POST["date"]);
	$topic=mysqli_real_escape_string($conn,$_POST["topic"]);
	$card_id=mysqli_real_escape_string($conn,$_POST["card_id"]);
	$lang=mysqli_real_escape_string($conn,$_POST["lang"]);
	$inv=mysqli_real_escape_string($conn, $_POST["inv"]);
	$userid=$_SESSION["userid"];
	
	//effettuo la query di inserimento
	$query="INSERT INTO meeting(user_id,title,place,date,topic,inv,card_id,lang) VALUES($userid, '$title', '$place', '$date', '$topic', $inv, $card_id, '$lang')";
	
	$result=mysqli_query($conn, $query);
	$query="SELECT meeting_id FROM meeting WHERE user_id=$userid AND title='$title' AND place='$place' AND date='$date' AND topic='$topic' AND inv=$inv AND card_id=$card_id AND lang='$lang'";
	$result1=mysqli_query($conn, $query);
	$res=mysqli_fetch_array($result1,MYSQLI_NUM);
	}
	echo $res[0];
?>