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
  <title>Education and Work Experience</title>
	
	
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

</style>

<script>
/*sono tutte funzioni già viste in altre pagine che controllano che tutti i campi dei vari form siano stati validati. dopo il document, il primo parametro si riferisce all'id del form che 
stiamo controllando e il secondo invece si riferisce all'id del campo che vogliamo riempire. In questo caso se anche uno solo dei campi è vuoto, la funzione ritorna false non mandando
valori all'alra pagina php tramite post, ma appare un messaggio che invita l'utente a riempire tutti i campi*/

function validate_1()
{
	
	if(document.education_experience_form.title.value == '' ||
	   document.education_experience_form.year.value == '' ||
       document.education_experience_form.place.value == ''	   )	
	{
		alert("You have to fill all the fields to continue!");
		return false;
	}
	
	else
	return true;
}

 function validate_update_1()
   {
   if( document.update_education_form.title_update_education.value == '' ||
       document.update_education_form.year_update_education.value == ''	||
       document.update_education_form.place_update_education.value == ''	
	   )	
	{
		alert("You have to fill all the fields to continue!");
		return false;
	}
	else
	return true;
   }



	function validate_2()
{
	
	if(document.work_experience_form.company.value == '' ||
	   document.work_experience_form.role.value == '' ||
       document.work_experience_form.year2.value == ''	||
       document.work_experience_form.place2.value == ''	
	   )	
	{
		alert("You have to fill all the fields to continue!");
		return false;
	}
	else
	return true;

}
  
   function validate_update_2()
   {
   if (document.update_work_form.company_update_work.value == '' ||
       document.update_work_form.role_update_work.value == ''	||
       document.update_work_form.year_update_work.value == ''	||
	   document.update_work_form.place_update_work.value == '')	
	{
		alert("You have to fill all the fields to continue!");
		return false;
	}
	else
	return true;
   }


	function validate_company()
{
	
	if(document.company_form.name.value == '' ||
	   document.company_form.role.value == '' ||
       document.company_form.address.value == ''	||
       document.company_form.employees_number.value == ''	
	   )	
	{
		alert("You have to fill all the fields to continue!");
		return false;
	}
	
	else 
	return true;

}

</script>

<body class="w3-black" background="work.jpg">
	<h2>Your Profile</h2>
	

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
	   <a href="eduexp.php" class="w3-bar-item w3-button w3-padding-large w3-black">
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

<div class="col-container">

<div class="col1" id="card" style="background-color:red">
  <?php 

if( file_exists("./uploads/".$_SESSION['userid'].".jpg") ){
	 echo "<img src='uploads/".$_SESSION['userid'].".jpg' style='width:100%'>";
	
}else { 
	echo "<img src='avatar3.png' style='width:100%'>";
} 


?>
  <h1><?php echo $_SESSION["name"]." ".$_SESSION["surname"]; ?></h1>
  <div style="margin: 24px 0; text-decoration: none; font-size: 22px; color: black; ">
    <a href="#"><i class="fa fa-dribbble"></i></a> 
    <a href="#"><i class="fa fa-twitter"></i></a>  
    <a href="#"><i class="fa fa-linkedin"></i></a>  
    <a  href="#"><i class="fa fa-facebook"></i></a> 
 </div>
 </div>
 
<div class="col">
<div class="container"> <!--Abbiamo settato la classe "container" per separare le cose, inoltre è buona norma mettere form e finestre modali dentro un container -->
<h2 id="edu">Education Experience </h2>
<div class="modal fade" id="education_experience_modal" role="dialog">	<!--abbiamo definito il fatto che è una finestra modale e abbiamo settato l'id così da poter richiamare il form tramite ajax-->
    <div class="modal-dialog">
	 <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:black"><b>Insert a new education experience</b></h3>
        </div>
		<div class="modal-body">
 <!-- Questo è il form che serve ad aggiungere education experience. Utilizza il metodo POST perchè cliccando il tasto "Add" prima controlla che tutti i campi siano stati
riempiti tramite la funzione validate_1() e poi se è tutto a posto, tramite una funzione che utilizza Ajax, invia i dati ad un'ulteriore pagina che li salva sul database e 
ricarica questa pagina, cosicchè l'utente possa vedere la nuova esperienza inserita. Lo stesso ragionamento vale per gli altri form, compresi gli update -->
  <form name='education_experience_form' action="eduexp.php"  method="post" onsubmit='return validate_1()'>
  <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" id="title" class="form-control" placeholder="Insert title" name="title">		<!-- il placeholder serve a far vedere ciò che noi scriviamo all'interno dell'input, in questo caso è un pò inutile perchè ripete l'etichetta però mi piaceva e l'ho messo lo stesso -->
	  <label for="year">Year:</label>
	  <input type="text" id="year" class="form-control" placeholder="Insert year" name="year">
	  <label for="place">Place:</label>
	  <input type="text" id="place" class="form-control" placeholder="Insert place " name="place">
	</div>
	<button id = "button_1" type="submit" class="btn btn-default">Add</button>		<!--Questo bottone viene richiamato successivamente e tramite chiamata Ajax fa sì che i dati possano essere inviati al database. Si trova anch'esso all'interno della finestra modale -->
  </form>
         </div>
		 <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>		<!--se l'utente decide di non voler proseguire c'è anche il tasto close che riporta alla pagina di visualizzazione chiudendo la finestra modale descritta sopra -->
        </div>
	 </div>
	</div>
</div>

</div>


<!--creo un altro container questa volta per fare l'update dei dati già inseriti, per modificarli. Funziona analogamente all'inserimento, ma questa volta il bottone permette di chiamare una funzione
che fa una chiamata Ajax ad una pagine php che fa la query di update anzichè l'add -->

<div class="container">
<div class="modal fade" id="updateEducationModal" role="dialog">
    <div class="modal-dialog">
	 <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:black"><b>Update Education Experience</b></h3>
        </div>
		<div class="modal-body">

  <form name='update_education_form' action="eduexp.php"  method="post" onsubmit='return validate_update_1()'>
  <div class="form-group">
      <input type="hidden" id="id_update_education" name="id_update_education", value="idHolder">
      <label for="title_update_education">Title:</label>
      <input type="text" id="title_update_education" class="form-control" placeholder="Insert title" name="title_update_education">
	  <label for="year_update_education">Year:</label>
	  <input type="text" id="year_update_education" class="form-control" placeholder="Insert year" name="year_update_education">
	  <label for="place_update_education">Place:</label>
	  <input type="text" id="place_update_education" class="form-control" placeholder="Insert place" name="place_update_education">
	</div>
	<button id = "button_update_education" type="submit" class="btn btn-default">Update</button>
  </form>
         </div>
		 <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
	 </div>
	</div>
</div>
</div>


<!-- Questo è il codice della tabella che invece noi vediamo quando si carica la pagina. In questo caso la document ready function di ajax fa in modo da caricare i dati che appaiono
nella tabella quando si carica la pagina, prendendo i dati da una pagina che fa la query e li invia qui -->
<table id="education" class="display" cellspacing="0" width="60%" align="right">
        <thead>
            <tr>
                <th>Title</th>
                <th>Year</th>
				<th>Place</th>
				<th>Options</th>
            </tr>
        </thead>
    </table>
	  <button id="exp_edu" type="button" class="btn-lg btn-dark" data-toggle="modal" data-target="#education_experience_modal">Add</button> <!-- questo bottone si trova invece fuori e al suo click apre la finestra modale che permette di aggiungere in questo caso, education experience --> 

	
<!--lo stesso ragionamento fatto con education experience può essere ripetuto con work experience, anche qui si apre una finestra modale che permette di inserire un'esperienza lavorativa -->	
	<div class="container">
<h2 id="wo" >Work Experience </h2>
<div class="modal fade" id="work_experience_modal" role="dialog">
    <div class="modal-dialog">
	 <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:black"><b>Insert a new work experience</b></h3>
        </div>
		<div class="modal-body">

  <form name='work_experience_form' action="eduexp.php"  method="post" onsubmit='return validate_2()'>
  <div class="form-group">
  <!--Qui possiamo scegliere una compagnia per cui un utente lavora tramite una select che ci fa vedere una lista di compagnie già presenti. Abbiamo anche la possibilità di aggiungere una nuova 
compagnia aprendo un'ulteriore finestra modale che fa appunto aggiungere la compagnia. Anche in questo caso i dati vengono prelevati tramite chiamate Ajax a pagine che comunicano con il database -->
      <label for="company">Company</label> 
      <select id = "company"></select><button type="button" class="btn btn-default" data-toggle="modal" data-target="#company_modal">Add company</button><br><br>
	  <label for="role">Role</label>
	  <input type="text" id = "role" class="form-control" placeholder="Insert your role" name="role">
	  <label for="year_2">Year</label>
	  <input type="text" id = "year2" class="form-control" placeholder="Insert work experience year" name="year2">
	  <label for="place">Place</label>
	  <input type="text" id = "place2" class="form-control" placeholder="Insert work experience place" name="place2">
	</div>
	<button type="submit" id = "button_2" class="btn btn-default">Add</button>
  </form>
         </div>
		 <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
	 </div>
	</div>
</div>
 
</div>

	
<!--analogamente all'update dell'education experience, qui possiamo fare l'update della work experience-->	
	
	<div class="container">
<div class="modal fade" id="updateWorkModal" role="dialog">
    <div class="modal-dialog">
	 <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:black"><b>Update your work experience</b></h3>
        </div>
		<div class="modal-body">

  <form name='update_work_form' action="eduexp.php"  method="post" onsubmit='return validate_update_2()'>
  <div class="form-group">
      <input type="hidden" id="id_update_work" name="id_update_work">
	  <label for="company_update_work">Company</label> 
      <select id = "company_update_work"></select>
	  <br><br>
	  <label for="role_update_work">Role:</label>
      <input type="text" id="role_update_work" class="form-control" placeholder="Insert your role" name="role_update_work">
	  <label for="year_update_work">Year:</label>
	  <input type="text" id="year_update_work" class="form-control" placeholder="Insert the year" name="year_update_work">
	  <label for="place_update_work">Place:</label>
	  <input type="text" id="place_update_work" class="form-control" placeholder="Insert place" name="place_update_work">
	</div>
	<button id = "button_update_work" type="submit" class="btn btn-default">Update</button>
  </form>
         </div>
		 <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
	 </div>
	</div>
</div>
</div>

<!--qui vediamo la tabella delle nostre work experience che tramite la document ready function prende i dati dal database e li stampa, usando chiamate Ajax -->
	
	<table id="work" class="display" cellspacing="0" width="60%" align="right">
	
        <thead>
		
            <tr>
                <th>Company Name</th>
                <th>Role</th>
				<th>Year</th>
				<th>Place</th>
				<th>Options</th>
            </tr>
        </thead>
    </table>
	 <button id="exp_work" type="button" class="btn-lg btn-dark" data-toggle="modal" data-target="#work_experience_modal">Add</button>
	<!--questo è un altro form realizzato come finestra modale che permette di inserire una nuova compagnia -->
			<div class="container">  
<div class="modal fade" id="company_modal" role="dialog">
    <div class="modal-dialog">
	 <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:black"><b>Insert Company</b></h3>
        </div>
		<div class="modal-body">

  <form name='company_form' action="eduexp.php"  method="post" onsubmit='return validate_company()'>
  <div class="form-group">
      <label for="name">Company name</label>
      <input type="text" id = "name" class="form-control" placeholder="Insert company name" name="name">
	  <label for="place">Place</label>
	  <input type="text" id = "place" class="form-control" placeholder="Insert place" name="place">
	  <label for="site">Site</label>
	  <input type="site" id = "site" class="form-control" placeholder="Insert company site" name="site">
	  <label for="email">Email</label>
	  <input type="email" id = "email" class="form-control" placeholder="Insert company email address" name="email">
	</div>
	<button type="submit" id = "button_3" class="btn btn-default">Add</button>
  </form>
         </div>
		 <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
	 </div>
	</div>
</div>
</div>
</div>
 </div>

		</body>

<script>

//prende il valore dei bottoni e lo sostituisce. Quando clicco, value diventa l'ID che poi passo alle funzioni per fare le mie operazioni
$(document).on("click", ".update_edu", function () {
     $('#id_update_education').attr('value', $(this).data('id'));
});

$(document).on("click", ".update_work", function () {
     $('#id_update_work').attr('value', $(this).data('id'));
});

	
function set_id(id, type){
	var x=document.getElementById("modalConfirm");
	x.dataset.id=id;
	if (type==1)
		x.dataset.type=1; 	//if il modal viene aperto dal delete dell'education_experience metto 1 in data-type nel modalConfirm
	else x.dataset.type=2;  //else metto 2 in data-type nel modalConfirm
	
}




// questa funzione è strutturata esattamente come la work experience: passo l'id di una esperienza che voglio cancellare ad una pagina che fa la query di delete
function delete_all(){
	var x=document.getElementById("modalConfirm");
	if(x.dataset.type==1){
		$.post("delete_education_experience.php", {id: x.dataset.id});
		var deletion = $('#education').DataTable();
	}
	else{
		$.post("delete_work_experience.php", {id : x.dataset.id }) 	//passa alla pagina di delete il valore dell'ID tramite POST
		var deletion = $('#work').DataTable();
	}
	deletion.ajax.reload();
} 


//è la funzione che manda i dati del form "education experience" alla pagina php che fa la query. Quando clicco il pulsante definisco delle variabili
//che passo tramite il metodo POST alla pagine education_experience.php che fa la query. Quelli segnati con #sono gli id della variabili del form
 $("#button_1").click(function(){
    var title = $("#title").val();
    var year = $("#year").val();
	var place = $("#place").val();
    $.post("education_experience.php", { title: title, year: year, place: place })
	})

//questa funzione invece premendo button_2 passa i dati alla pagina work_experience che inserisce l'esperienza	
$("#button_2").click(function(){
	  
    var company = $("#company").val();
	var role = $("#role").val();
    var year2 = $("#year2").val();
	var place2 = $("#place2").val();
    $.post("work_experience.php", { company: company, role: role, year: year2, place: place2 })
	})

//Facendo riferimento all'update, # indica sempre l'ID del bottone, anche in questo caso passo delle variabili POST che aggiornano le mie informazioni	
$("#button_update_education").click(function(){
    var id = $("#id_update_education").val();
    var title = $("#title_update_education").val();
    var year = $("#year_update_education").val();
	var place = $("#place_update_education").val();
    $.post("update_education_experience.php", { title: title, year: year, place: place, id: id })
	});
  
	
	//da qui prendo i valori della compagnia che ho eventualmnete inserito
    $.ajax({
            type: "POST",
            url: "company_select.php",
            
            success: function(data){
                // analizza i dati ritornati da json
                var back = $.parseJSON(data);
				// usa jquery per iterare tutti i valori presi dalla funzione precedente
                $.each(back, function(i, d){
                // Mi prendo i valori corretti ritornati come oggetti json
                $('#company').append('<option value="' + d.company_id + '">' + d.name + '</option>');
				document.getElementById("company").style.color="black";
                });
            }
        });
		
		
				


//Anche in questo caso passo dei valori tramite il POST ad una pagina che mi fa la query di update
$("#button_update_work").click(function(){
    var id = $("#id_update_work").val();
    var company_id = $("#company_update_work").val();
	var role = $("#role_update_work").val();
    var year = $("#year_update_work").val();
	var place = $("#place_update_work").val();
    $.post("update_work_experience.php", { company_id: company_id, role: role, year: year, place: place, id: id })
	})

//mi permette di inserire una nuova compagnia	
$("#button_3").click(function(){
    var name = $("#name").val();
	var place = $("#place").val();
    var site = $("#site").val();
	var email = $("#email").val();
    $.post("company.php", { name: name, place: place, site: site, email: email })
	})

$('#company_update_work').empty(); 
  
     <!--funzione ajax da dove riprendo i valori  -->
    $.ajax({
            type: "POST",
            url: "company_select.php",
            
            success: function(data){
                // analizza i dati ritornati da json
                var back = $.parseJSON(data);
				// usa jquery per iterare tutti i vali presi dalla funzione precedente
                $.each(back, function(i, d){
                // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                $('#company_update_work').append('<option value="' + d.company_id + '">' + d.name + '</option>');
				document.getElementById("company_update_work").style.color="black";
                });
            }
        });
	

//queste sono funzioni che mi permettono di visualizzare dei dati non appena la pagina è stata caricata. Prendono tramite ajax dei valori da pagine che effettuano le query di select
//e riempiono le righe della tabella
$(document).ready(function() {
  
  $('#education').dataTable( {
    "sAjaxSource": "education_visual.php",
	"ordering": false,
	"info":false,
        "dom": "Brti",
        "responsive": true,
        "bDestroy": true, 
        "aoColumns": [
            { "mData": "title" },
            { "mData": "year"},		
            { "mData": "place"},
			{ "mData": "education_experience_id",
			  "mRender":function(data, type, row){ //i bottoni mi permettono di eliminare o modificare la mia esperienza e appaiono dentro la tabella, all'interno della label Options
					return "<button id='update_' class='update_edu' data-toggle='modal' data-id="+data+"  type='button' data-target='#updateEducationModal' value='Update'><i class = 'fa fa-edit' color='white'></i></button> <button id='delete_' data-toggle='modal' type='button' data-target='#modalConfirm' onclick='return set_id("+data+", 1 )'><i class = 'fa fa-trash-o' color='white'></i></button>"
         }},
 
        ],
		//serve a dare delle formattazioni css a tutte le td corrispondenti alla tabella di cui fanno parte, cioè education_visual
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				$('td', nRow).css( 'background', 'black' );
				$('td', nRow).css( 'text-align', 'left' );
				$('td', nRow).css( 'border-style', 'none' );
				$('td', nRow).css( 'border-color', 'grey' );
		}
    });

 //analogamente a prima, anche qui richiamo dei valori da una pagina php
   $('#work').dataTable( {

    "sAjaxSource": "work_visual.php",
	"ordering": false,
	"info":false,
        "dom": "Brti",
        "responsive": true,
        "bDestroy": true,         
        "aoColumns": [
             
			{ "mData": "company" }, 
			{ "mData": "role" },
			{ "mData": "year" },
			{ "mData": "place" },
			{ "mData": "work_experience_id",
			  "mRender":function(data, type, row){
					return "<button id='update_' class='update_work' data-id="+data+" data-toggle='modal'  type='button' data-target='#updateWorkModal' value='Update'><i class = 'fa fa-edit' color='white'></i></button><button id='delete_' data-toggle='modal' data-target='#modalConfirm' onclick='return set_id("+data+", 2)' type='button' value='Delete'><i class = 'fa fa-trash-o' color='white'></i></button>" 
         }},			
        ],
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				$('td', nRow).css( 'background', 'black' );
				$('td', nRow).css( 'text-align', 'left' );
				$('td', nRow).css( 'border-style', 'none' );
				$('td', nRow).css( 'border-color', 'grey' );
		}
    });
})
	
</script>
		
		</html>
		
		
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
/*Utilizzo exp_edu, exp_work per i bottoni. la loro posizione è relativa alla tabella di riferimento.  */
#exp_edu{
	position: relative;
	top:20px;
	left:800px;
}

#exp_work{
	position:relative;
	top:120px;
	left:800px;
}

/* la tabella education ha una posizione relativa al div in cui sta.  */
#education{
	position:relative;
	right:600px;
	
	
}
/* la tabelle work e la scritta work experience(wo). la posizione della tabella è relativa rispetto alla tabella superiore e alla tabella di riferimento (work). */

#wo{
	position:relative;
	top:100px;
	right:160px;
}
#work{
	position:relative;
	right:600px;
	top:100px;
	
	
}
/* la scritta "education experience" è fissa in alto.  */
#edu{
	position:absolute;
	top:-50px;
	left:20px;
	
} 
#delete_, #update_{
	background-color: Transparent;
	border: none;
}
.button_2, .button_3{
	position: relative;
    left: 500px;
	bottom:300px;
	
}
.col {
	align: center;
	height:70%;
	width: 100%;
	position: absolute;
	top:150px;
	left: 560px;
	
}
.col1 {
	align: center;
	height:70%;
	width: 30%;
	position: absolute;
	top:150px;
	left: 560px;
	
}

#card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 400px;
  margin: auto;
  text-align: center;
  font-family: arial;
  position: absolute;
  left: 150px;
  bottom: 70px;
}


#a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

#social:hover, #a:hover {
  opacity: 0.7;
}


</style>