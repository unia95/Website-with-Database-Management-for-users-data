<?php
session_start(); 
include("db.php"); //includo i dati del mio database
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
<html lang="en">
<head>
  <title>Business Card</title>
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
</style>
	
	<body class="w3-black" background="buildings.jpg">
	<h2>Meetings</h2>
	

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
       
	   <a href="business_cards_carousel.php" class="w3-bar-item w3-button w3-padding-large w3-black">
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

</nav><!-- sono tutti input che io posso inserire per salvare il mio nuovo biglietto da visita -->
	<form id="info" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <label><input type="text" id="profile_name" class="form-control" placeholder="Profile Name" name="profile_name"> Profile</label> <br>
                <label><input type="text" id="name" class="form-control" placeholder="Name" name="name">Name</label><br>
				<label><input type="text" id="surname" class="form-control" placeholder="Surname" name="surname">Surname</label><br>
				<label><input type="email" id="email" class="form-control" placeholder="E-Mail" name="email">E-Mail</label><br>
				<label><input type="phone" id="phone" class="form-control" placeholder="Phone" name="phone">Phone</label><br>
            </tr>
        </thead>
    </form>
	
<table id="education" class="display" cellspacing="0" width="70%" align="right">
        <thead> 
            <tr> 
                <th>Title</th>
                <th>Year</th>
				<th>Place</th>
				<th>Check</th>
            </tr>
        </thead>
    </table>
	<!--visualizzo i dati della work experience che posso checkare -->
	<table id="work" class="display" cellspacing="100" width="70%" align="right">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Role</th>
				<th>Year</th>
				<th>Place</th>
				<th>Check</th>
            </tr>
        </thead>
    </table>
	
	<!--salvo il biglietto da visista -->
	<button id = "button_save_card" type="submit" class="btn btn-default" onclick="window.location.href='business_cards_carousel.php'">Save</button>
	
	<script>
	
	//è la funzione che mi fa salvare il biglietto da visita. Rimanda ad una pagina php che effettua l'insert su cards
	
	$("#button_save_card").click(function(){
    var title = $("#profile_name").val();
    var name = $("#name").val();
    var surname = $("#surname").val();
	var email = $("#email").val();
	var phone= $("#phone").val();
	var education_exp_id = $('.editor-active:checked').val();
	var work_exp_id = $('.editor:checked').val();
    $.post("save_card.php", {title: title, name: name, surname: surname, email: email, phone: phone, edu_exp_id: education_exp_id, working_exp_id:work_exp_id });
	alert ("Saved!");
	})
	
//mi fa vedere le education experience e mi fa fare il check di una sola di esse
  $(document).ready( function() {
  $('#education').dataTable( {
    "sAjaxSource": "education_visual.php",
        "dom": "Brti",
		"info": false,
        "responsive": true,
        "bDestroy": true,  	
        "aoColumns": [
			{ "mData": "title" }, 
			{ "mData": "year" },
			{ "mData": "place"},
			{ "mData": "education_experience_id",
                "mRender": function ( data, type, row ) {
                        return '<input type="radio" name="edu_exp_checkbox" class="editor-active" value='+data+'>';
                }
				
			}
	
        ],
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				$('td', nRow).css( 'background', 'black' );
				$('td', nRow).css( 'text-align', 'center' );
				$('td', nRow).css( 'border-style', 'solid' );
				$('td', nRow).css( 'border-color', 'grey' );
		}
        
    });


 //mi fa vedere tutte le work experience e mi fa scegliere solo una di esse
  $('#work').dataTable( {
    "sAjaxSource": "work_visual.php",
        "dom": "Brti",
		"info": false,
        "responsive": true,
        "bDestroy": true, 
		
        "aoColumns": [
             
			{ "mData": "company" }, 
			{ "mData": "role" },
			{ "mData": "year" },
			{ "mData": "place" },
			{ "mData": "work_experience_id",
                "mRender": function ( data, type, row ) {
                        return '<input type="radio" name="working_exp_checkbox" class="editor" value='+data+'>';
                }
				
			}
	
        ],
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				$('td', nRow).css( 'background', 'black' );
				$('td', nRow).css( 'text-align', 'center' );
				$('td', nRow).css( 'border-style', 'solid' );
				$('td', nRow).css( 'border-color', 'grey' );
		}
  });
      } )  
	
</script>

		</body>
	
	
	
	
</head>

<?php 
}

else {
	echo "Si è verificato un errore, non puoi accedere a questa pagina<br>";	//inserisco un controllo che nel caso anche uno solo dei dati session non sia presente, allora stampo un messaggio di errore
	header('location: login.html'); //rimando l'utente direttamente al login
	}

mysqli_close($conn);
?>

</html>


<style>
.form-control {
	position:relative;
	left:150px;
	top: 100px;
	width: 110%;
}

#nc{
	position:relative;
	margin-left:150px;
	top:120px;

	
}
#tc{
	color:black;
	border-radius: 5px;
	
}
#education{
	
	position: relative;
	bottom: 200px
}

#work{
	margin-top: 100 px;
	position: relative;
	bottom: 200px
}

#button_save_card{
	color:white;
	text-align: center;
	transition-duration: 0.4s;
	background-color: black;
	position: relative;
    left: 1250px;
	bottom:180px;
	width: 84px;
    height: 45px; 
	
}

</style>