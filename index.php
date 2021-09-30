<?php 
  session_start(); 
  include ("db.php");		//includo il mio database
  include("header.html");
  $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione

  if (!isset($_SESSION['username'])) { 
  	$_SESSION['msg'] = "Devi loggare prima di poter vedere la pagina!"; //se la connessione non avviene, viene effettuato un redirect alla pagina di login che invita l'utente a loggarsi per proseguire
	header('location: login.html');

  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.html");
	
  }
?>
<!DOCTYPE html>
<html>

<head>

	<title>Home</title>
	
	<style>
body, h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", sans-serif}
.w3-row-padding img {margin-bottom: 12px}
/* Set the width of the sidebar to 120px */
.w3-sidebar {width: 120px;background: #222;}
/* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
#main {margin-left: 120px}
/* Remove margins from "page content" on small screens */
@media only screen and (max-width: 600px) {#main {margin-left: 0}}
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
   <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-black">
    <i class="fa fa-home w3-xxlarge"></i>
    <p>DASHBOARD</p>
  </a>
       <a href="visualizza_info.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
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
<body>
		<div class="w3 m3">
	
		<?php if (isset($_SESSION['username'])){} 	//se prende la variabile username dalla sessione che abbiamo avviato all'inizio della pagina, allora stampa "Benvenuto + nome utente dell'utente loggato in quel momento"?>
		<div class="w3-padding-large" id="main">
  <!-- Header/Home -->
  <header class="w3-container w3-padding-15 w3-center w3-black" id="home">
    <h1 class="w3-jumbo"><span class="w3-hide-small">Welcome</span> <?php echo $_SESSION['username']; ?></h1>
    <p>See what's new!</p>
	
	<table id="meeting" class="display" cellspacing="0" width="91%">
        <thead>
            <tr>
                <th>Title</th>
				<th>Place</th>
				<th>Invitation</th>
				<th>Role</th>
            </tr>
        </thead>
    </table>
	</div>
	</div>
	
	<footer class="w3-content w3-padding-64 w3-text-grey w3-xlarge">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
	<p> <a href="login.html?logout='1'">Logout</a> </p> <!--è un pulsante di logout che mi modifica anche il valore dell'omonima variabile -->
    <p class="w3-medium">Powered by Lilly Cutaia</p>
  <!-- End footer -->
  </footer>
  
  </body>
  
  <script>
  
      
$(document).ready( function() {
  $('#meeting').dataTable( {
    "sAjaxSource": "show_all_meetings.php",
	"bFilter": false,
        "dom": "Brti",
		"info":false,
        "responsive": true,
        "bDestroy": true,
        "aoColumns": [
             
            { "mData": "title" },
            { "mData": "place"},
			{ "mData": "invitation" },
			{ "mData": "role"}
        ],
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				$('td', nRow).css( 'background', 'black' );
				$('td', nRow).css( 'text-align', 'center' );
				$('td', nRow).css( 'border-style', 'none' );
		}
    });

	});

  
  </script>
  

</html>