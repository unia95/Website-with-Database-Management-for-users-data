<?php
session_start(); 
include("db.php"); //includo i dati del mio database

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

//dopo la connessione mi assicuro di avere tutte le variabili $_SESSION presenti altrimenti vuol dire che l'utente non è loggato e quindi non gli faccio vedere proprio la pagina
if(isset($_SESSION["username"]) && isset($_SESSION["name"]) && isset($_SESSION["surname"]) && isset($_SESSION["email"]) && isset($_SESSION["password"]) && isset($_SESSION["birth"])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Business Cards</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js">
	</script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	</head>
	
		<title>Messages</title>
	
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
	
<body class="w3-black">
	<h2>Messages</h2>
	

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
  <a href="messages.php" class="w3-bar-item w3-button w3-padding-large w3-black">
    <i class="fa fa-envelope-o w3-xxlarge"></i>
    <p>MESSAGES</p>
  </a>
  </div>

</nav>
<table id="messaggi" class="display" cellspacing="0" width="91%" align="right" >
        <thead>
            <tr>
                <th>Profile Name</th>
                <th>Place</th>
				<th>Topic</th>
				<th>Date</th>
				<th>Options</th>
            </tr>
        </thead>
    </table>
</body>
<?php
}
else {
	echo "Si è verificato un errore, non puoi accedere a questa pagina<br>";	//inserisco un controllo che nel caso anche uno solo dei dati session non sia presente, allora stampo un messaggio di errore
	}

mysqli_close($conn);
?>


<script>
function Decline(id){
	$.post("delete_message.php", {id: id});
	var deletion = $('#messaggi').DataTable();
	deletion.ajax.reload();
} 

function Accept(id, meeting_id){
	$.post("accept_message.php", {id: id, meeting_id: meeting_id});
	var deletion = $('#messaggi').DataTable();
	deletion.ajax.reload();
}

$(document).ready(function(){
	 $('#messaggi').dataTable( {
    "sAjaxSource": "messages_query.php",
	"bFilter": true,
	"ordering": false,
	"info": false,
        "dom": "Brti",
        "responsive": true,
        "bDestroy": true, 
        "aoColumns": [
            { "mData": "profile_name" },
            { "mData": "place"},		
            { "mData": "topic"},
			{ "mData": "date"},
			{ "mData": "button_1","mRender":function(data, type, row){
           return "<button class='accept' id='acc' onclick='Accept("+row.message_id+","+row.meeting_id+")'   type='button'  value='accept_inv'><i class = 'fa fa-check' style='color:white;' ></i></button>  <button class='decline' id='dec' onclick='Decline("+row.message_id+")'  type='button'  value='decline_inv'><i class = 'fa fa-times' style='color:white;' ></i></button>" 
         }},
        ],
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                 $('td', nRow).css( 'background', 'black' );
				 $('td', nRow).css( 'text-align', 'center' );
				 $('td', nRow).css( 'border-style', 'none' );
            }
    })
})

</script>
</html>


<style>


#acc, #dec{
	background-color: Transparent;
	border: none;
}
</style>

