<?php 
session_start(); 
include("db.php"); //includo i dati del mio database
include("header.html");

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

//dopo la connessione mi assicuro di avere tutte le variabili $_SESSION presenti altrimenti vuol dire che l'utente non è loggato e quindi non gli faccio vedere proprio la pagina
if(isset($_SESSION["username"]) && isset($_SESSION["name"]) && isset($_SESSION["surname"]) && isset($_SESSION["email"]) && isset($_SESSION["password"]) && isset($_SESSION["birth"])){
?>

<!DOCTYPE html>
<html>


<head><h2>Update your informations:</h2> 
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

  #update_form{
	 width: 700px;
   height: 500px;
   margin: auto;
   position: relative;
     border: 1px solid #ccc;
    border-radius: 10px;
	   padding: 25px 100px;
    margin: 50px 300;
    box-sizing: border-box;
	 	
	
  }
 

  
</style>
	
</head>

  
 <script type= "text/javascript">

function validate() {
	if (document.update.username.value==""||
		document.update.firstname.value=="" || 
		document.update.lastname.value=="" ||
		document.update.email.value==""	||
		document.update.password.value=="" ||
		document.update.birthdate.value=="")
		{
		
		alert ("Devi compilare tutti i campi");
		return false;
	
	}
	else {
		var timestamp = Date.parse(document.update.birthdate.value);
		var today = new Date().getTime();
		var diff = ( today - timestamp ) / ( 1000 * 60 * 60 * 24 * 365 );
		var n = parseInt( diff, 10 );
		if (n>17) {
			return true;
		}
		else {
		alert("Devi essere maggiorenne per iscriverti");
			return false;
		}
	}
}
//controllo che nessuno dei campi sia vuoto e che l'utente che sta cambiando anche la data di nascita sia maggiorenne

</script>
</head>
<title> Update </title>

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
<body class="w3-black" background="background.jpg">
<!--anche questo è un form al quale vengono però passate tutte le variabili di sessione in modo tale che l'utente possa decidere cosa modificare senza cambiare gli altri campi e senza dover riempire tutto ogni volta. 
E' però necessario reinserire la password (vecchia o nuova non ha importanza) perchè, essendo criptata, se non venisse reinserita darebbe errore poichè usando md5 non è possibile decriptare una password criptata -->
<div><form id="update_form" name="update" action="update.php" method="POST" enctype="multipart/form-data" onsubmit= "return validate();">
New Username <input type="text" name="username" value= "<?php echo $_SESSION['username']; ?>"><br><br>
New Password <input type="password" name="password"><br><br>
New Email <input type="email" name="email" value= "<?php echo $_SESSION['email']; ?>"><br><br>
New Name <input type="text" name="firstname" value= "<?php echo $_SESSION['name']; ?>"><br><br>
New Surname <input type="text" name="lastname" value= "<?php echo $_SESSION['surname']; ?>"><br><br>
New Birthdate <input type="date" name="birthdate" value= "<?php echo $_SESSION['birth']; ?>"><br><br>
Profile Picture <input type="file" name="profile_picture" id="profile_picture"> <br><br>

To see changes, you have to log in again!<br>
<input type="submit" class="btn" value="Update"> <!-- premendo il pulsante "Update" se tutti i dati sono stati inseriti correttamente e superano il controllo lato client, si passa al controllo lato server-->
</form></div>
</body>

<?php 
}

else {
	echo "An error has occurred, you can't see this page<br>";	//inserisco un controllo che nel caso anche uno solo dei dati session non sia presente, allora stampo un messaggio di errore
	header('location: login.html'); //rimando l'utente direttamente al login
}

mysqli_close($conn);
?>

</html>