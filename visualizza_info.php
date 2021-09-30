<?php
session_start(); 
include("db.php"); //includo i dati del mio database
include("_modalConfirm.php");
include("header.html");

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

//dopo la connessione mi assicuro di avere tutte le variabili $_SESSION presenti altrimenti vuol dire che l'utente non è loggato e quindi non gli faccio vedere proprio la pagina
if(isset($_SESSION["username"]) && isset($_SESSION["name"]) && isset($_SESSION["surname"]) && isset($_SESSION["email"]) && isset($_SESSION["password"]) && isset($_SESSION["birth"])){
?>

<!DOCTYPE html>
<head>
	<title>Info</title>
	
</head>
<style>
body, h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", sans-serif}
.w3-row-padding img {margin-bottom: 12px}
/* Set the width of the sidebar to 120px */
.w3-sidebar {width: 120px;background: #222;}
/* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
#main {margin-left: 120px}
/* Remove margins from "page content" on small screens */
@media only screen and (max-width: 600px) {#main {margin-left: 0}}

.btn-dark{
  background-color:black;
  color:white;
  .btn-dark:hover{color: white;}
  }

  #table_id{
	 
	  border-collapse: collapse;
	  position:relative;
	  left:200px;
	 	
	
  }
	

  
  tr, td{
	  border: 0.5px black;
	  padding: 100px;	
	  border-collapse: collapse;
	
  }
  

  
</style>
	
</head>
<body class="w3-black">
	<h2>Home Page</h2>
	

<!--Faccio una barra di navigazione utilizzando bootstrap per rendere il sito più godibile -->	
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
 <?php 

if( file_exists("./uploads/".$_SESSION['userid'].".jpg") ){
	 echo "<img src='uploads/".$_SESSION['userid'].".jpg' style='width:100%'>";
	
}else { 
	echo "<img src='avatar3.png' style='width:100%'>";
} 


?>
   <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-home w3-xxlarge"></i>
    <p>DASHBOARD</p>
  </a>
       <a href="visualizza_info.php" class="w3-bar-item w3-button w3-padding-large w3-black">
    <i class="fa fa-user w3-xxlarge"></i>
    <p>ABOUT</p>
  </a>
       <a href="eduexp.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-folder-o w3-xxlarge"></i>
    <p>YOUR PROFILE</p>
  </a>
       <a href="business_cards_carousel.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-address-card w3-xxlarge"></i>
    <p>BUSINESS CARDS</p>
  </a>
	   <a href="meetings_visual.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-handshake-o w3-xxlarge"></i>
    <p>MEETINGS</p>
  </a>
  <a href="messages.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-envelope-o w3-xxlarge"></i>
    <p>MESSAGES</p>
  </a>
  </div>

</nav>
		<div class="w3 m3">
		<body background="background.jpg">
<div class="container">
<table class= "table" id="table_id" style="width:80%">
	<thead>
		<tr><td colspan='2' align='center'>Account Info</td></tr></thead>
		<tr><td>Username: <?php echo $_SESSION['username'];?></td></tr>
		<tr><td>Password: *********</td></tr>
		<tr><td>Name: <?php echo $_SESSION['name'];?> </td></tr>
		<tr><td>Surname:  <?php echo $_SESSION['surname'];?> </td></tr>
		<tr><td>E-mail: <?php echo $_SESSION['email'];?> </td></tr>
		<tr><td>Birthdate: <?php echo $_SESSION['birth'];?> </td></tr>
		<tr><td>Profile Picture:<br> <?php 

if( file_exists("./uploads/".$_SESSION['userid'].".jpg") ){
	 echo "<img src='uploads/".$_SESSION['userid'].".jpg' style='width:70%'>";
	
}else { 
	echo "<img src='avatar3.png' style='width:70%'>";
} 


?></td></tr></table>
	</thead>
	<br><input type="button" class="btn-dark" value="Update informations" onclick="window.location.href='update_info.php'"/><br>
	</div>
		
</div>
</body>


<?php 
}

else {
	echo "An error has occurred, you can't see this page<br>";	//inserisco un controllo che nel caso anche uno solo dei dati session non sia presente, allora stampo un messaggio di errore
	}

mysqli_close($conn);
?>
</html>

