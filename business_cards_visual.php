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
<html lang="en">
<head>
  <title>Business Cards</title>
	
	</head>
	
		<title>Business Cards</title>
	
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
	<h2>Business Cards</h2>
	

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

</nav>
	
	<body background="buildings.jpg">
	
	<table id="business_cards" class="display" cellspacing="0" width="91%" align="right" >
        <thead>
            <tr>
                <th>Profile Name</th>
                <th>Name</th>
				<th>Surname</th>
				<th>e-Mail</th>
				<th>Phone</th>
				<th>Title</th>
				<th>Company Name</th>
				<th>Options</th>
            </tr>
        </thead>
    </table>
	
	
	<div class="container">
<div class="modal fade" id="updateCardModal" role="dialog">
    <div class="modal-dialog">
	 <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:black">Update your Business Cards</h3>
        </div>
		<div class="modal-body">

  <form name='update_card_form' action="business_cards_visual.php"  method="post">
  <div class="form-group">
      <input type="hidden" id="id_update_card" name="id_update_card", value="idHolder">
      <label for="title_update_card" style="color:black">Title:</label>
      <input type="text" id="title_update_card" class="form-control" placeholder="Insert title" name="title_update_card">
	  <label for="name_update_card" style="color:black">Name:</label>
      <input type="text" id="name_update_card" class="form-control" placeholder="Insert name" name="name_update_card">
	   <label for="surname_update_card" style="color:black">Surname:</label>
      <input type="text" id="surname_update_card" class="form-control" placeholder="Insert surname" name="surname_update_card">
	   <label for="email_update_card" style="color:black">E-mail:</label>
      <input type="email" id="email_update_card" class="form-control" placeholder="Insert email" name="email_update_card">
	   <label for="phone_update_card" style="color:black">Phone:</label>
      <input type="text" id="phone_update_card" class="form-control" placeholder="Insert phone" name="phone_update_card">
	  <table id="education" class="display" cellspacing="0" width="90%" align="right">
        <thead>
            <tr>
                <th style="color:black">Title</th>
                <th style="color:black">Year</th>
				<th style="color:black">Place</th>
				<th style="color:black">Select</th>
            </tr>
        </thead>
    </table>
	
	<table id="work" class="display" cellspacing="0" width="90%" align="right">
        <thead>
            <tr>
                <th style="color:black">Company Name</th>
                <th style="color:black">Role</th>
				<th style="color:black">Year</th>
				<th style="color:black">Place</th>
				<th style="color:black">Select</th>
            </tr>
        </thead>
    </table>
	
	</div>
	<button id = "button_update_cards" type="submit" class="btn btn-default">Update</button>
  </form>
         </div>
		 <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
	 </div>
	</div>
</div>
</div>
	
	<script>
	
	function set_id(id){
	var x=document.getElementById("modalConfirm");
	x.dataset.id=id;
	
}




// questa funzione è strutturata esattamente come la work experience: passo l'id di una esperienza che voglio cancellare ad una pagina che fa la query di delete
function delete_all(){
	var x=document.getElementById("modalConfirm");
	
		$.post("delete_card.php", {id: x.dataset.id});
		var deletion = $('#business_cards').DataTable();
	deletion.ajax.reload();
} 
	
	
	$(document).on("click", ".update_card_form", function () {
     $('#id_update_card').attr('value', $(this).data('id'));
});
	//Facendo riferimento all'update, # indica sempre l'ID del bottone, anche in questo caso passo delle variabili POST che aggiornano le mie informazioni	
$("#button_update_cards").click(function(){
    var id = $("#id_update_card").val();
    var title = $("#title_update_card").val();
    var name = $("#name_update_card").val();
	var surname = $("#surname_update_card").val();
	var email = $("#email_update_card").val();
	var phone = $("#phone_update_card").val();
	var education_exp_id = $('.editor-active:checked').val();
	var work_exp_id = $('.editor:checked').val();
    $.post("update_business_cards.php", {title: title, name: name, surname: surname, email: email, phone: phone, edu_exp_id: education_exp_id, working_exp_id:work_exp_id, id: id });
})
  

	
	
	//mostro la tabella delle education experience con una checkbox che mi permette di selezionare un'esperienza da aggiungere al mio biglietto da visita.
	//mi serve per il modal form dell'update
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


 //analogamente al discorso fatto prima per education experience, mostro le esperienze lavorative con una checkbox. Mi serve per il modal form dell'update
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

  
//visualizzo i dati del mio biglietto da visista come datatable
	$(document).ready(function(){
	 $('#business_cards').dataTable( {
    "sAjaxSource": "business_visual.php",
	"bFilter": true,
	"ordering": false,
	"info": false,
        "dom": "Bfrti",
        "responsive": true,
        "bDestroy": true, 
        "aoColumns": [
            { "mData": "profile_name" },
            { "mData": "name"},		
            { "mData": "surname"},
			{ "mData": "email"},
			{ "mData": "phone"},
			{ "mData": "title"},
			{ "mData": "company_name"},
			{ "mData": "card_id","mRender":function(data, type, row){
           return "<button id='update_' class='update_card_form' data-toggle='modal' data-id="+data+"  type='button' data-target='#updateCardModal' value='Update'><i class = 'fa fa-edit' color='white'></i></button><button id='delete_' data-toggle='modal' data-target='#modalConfirm' onclick='set_id("+data+")' type='button' value='Delete'><i class = 'fa fa-trash-o' color='black'></i></button>"; 
         }},//metto i pulsanti di cancellazione e modifica che attivano delle funzioni che si riferiscono a pagine che fanno le dovute query
        ],
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                 $('td', nRow).css( 'background', 'black' );
				 $('td', nRow).css( 'text-align', 'center' );
				 $('td', nRow).css( 'border-style', 'none' );
				 $('td', nRow).css( 'border-color', 'grey' );
            }
    })
})

	</script>
	
	</body>
	
	</html>
			<?php 
}

else {
	echo "Si è verificato un errore, non puoi accedere a questa pagina<br>";	//inserisco un controllo che nel caso anche uno solo dei dati session non sia presente, allora stampo un messaggio di errore
	header('location: login.html'); //rimando l'utente direttamente al login
	}

mysqli_close($conn);
?>
<br ><input align="right" class='button' type="button" value="Add new business cards" onclick="window.location.href='business_cards.php'" /><br>
</html>

<style>
.button{
	color:white;
	text-align: center;
	transition-duration: 0.4s;
	background-color: black;
	position: relative;
    left: 125px;
	
}

#update_, #delete_{
	background-color: Transparent;
	border: none;
	
}

.button:hover{
	background-color: #404040;
}

.button2{
	border: none;
	background-color: Transparent;
}
</style>