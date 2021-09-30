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
  <title>Meetings</title>
	
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
	
<body class="w3-black">
	<h2>Meetings and Meeting Room</h2>
	

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
	   <a href="meetings_visual.php" class="w3-bar-item w3-button w3-padding-large w3-black">
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

<script src="jquery.barrating.js"></script>
<style>
            .rating {
                overflow: hidden;
                display: inline-block;
                position: relative;
                font-size:20px;
                color: #FFCA00;
            }
            .rating-star {
                padding: 0 5px;
                margin: 0;
                cursor: pointer;
                display: block;
                float: right;
            }
            .rating-star:after {
                position: relative;
                font-family: FontAwesome;
                content:'\f006';
            }
            
            .rating-star.checked ~ .rating-star:after,
            .rating-star.checked:after {
                content:'\f005';
            }
            
            .rating:hover .rating-star:after {content:'\f006';}
            
            .rating-star:hover ~ .rating-star:after, 
            .rating-star:hover:after {
                content:'\f005' !important;
            }
            
            
            
			
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
</head>
<div>
	

<!-- creo un container che conterrà le info del mio meeting. In questo modo quando clicco il pulsante, vedo i dettagli del meeting perchè passo l'id alla funzione che mi 
ritorna tutti i dettagli del meeting -->	
<div class="container">
<div class="modal fade" id="ModalCard" role="dialog">
    <div class="modal-dialog">
	 <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title">Meeting Info</h3>
        </div>
		<div class="modal-body">
<table id="meeting_modal" class="display" cellspacing="0" width="60%" method="POST"> <!-- è la finestra modale a cui mi dovrò riferire ogni volta che premo il pulsante che mi mostra
tutte le info del meeting che ho selezionato -->
        <thead>
            <tr>
                <th>Title</th>
				<th>Place</th>
				<th>Date</th>
				<th>Topic</th>
				<th>Invitation</th>
				<th>Card_ID</th>
				<th>Language</th>
            </tr>
        </thead>
    </table>
	 </form>
         </div>
		 <div class="modal-footer">
		 <!--quando premo questo pulsante mi chiude la finestra modale-->
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
	 </div>
	</div>
</div>
</div>

<div class="container">
<div class="modal fade" id="updateMeetingModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
	 <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title" style="color:black"><b>Update Meeting</b></h3>
        </div>
		<div class="modal-body">

  <form name='update_meeting_form' action="meetings_visual.php"  method="post" onsubmit='return validate_update_1()'>
  <div class="form-group">
      <input type="hidden" id="id_update_meeting" name="id_update_meeting" value="idHolder">
      <label for="title_update_meeting">Title:</label>
      <input type="text" id="title_update_meeting" class="form-control" placeholder="Insert title" name="title_update_meeting">
	  <label for="date_update_meeting">Date:</label>
	  <input type="date" id="date_update_meeting" class="form-control" placeholder="Insert date" name="date_update_meeting">
	  <label for="place_update_meeting">Place:</label>
	  <input type="text" id="place_update_meeting" class="form-control" placeholder="Insert place" name="place_update_meeting">
	</div>
	<button id = "button_update_meeting" type="submit" class="btn btn-default">Update</button>
  </form>
         </div>
		 <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
	 </div>
	</div>
</div>
</div>

<!--questa è la tabella che vedo quando apro la pagina. Per vedere le altre informazioni riguardo il mio meeting devo cliccare il tasto che mi mostra le informazioni -->
<div class="br-wrapper br-theme-fontawesome-stars">
<table id="meeting" class="display" cellspacing="0" width="80%" style="position:relative; top: 30px; left: 150px">
        <thead>
            <tr>
                <th>Title</th>
				<th>Place</th>
				<th>Invitation</th>
				<th>Role</th>
				<th>Options</th>
            </tr>
        </thead>
    </table>
	</div>
<!--premendo questo bottone mi porta al wizard che crea un nuovo meeting -->	
<br><input type="button" id='new_meeting_btn' value="Add a new meeting" onclick="window.location.href='meeting_insert_wizard.php'" /><br> 


<div id="box" method="POST" data-value="" data-star1="" data-star2="" style="display:none"><br>

  <div class="rating" id="rating1">
			<h3 style "color:#FFFFF">Usefull:</style>
            <span class="rating-star"  data-id="1" data-value="5"></span>
            <span class="rating-star"  data-id="1" data-value="4"></span>
            <span class="rating-star"  data-id="1" data-value="3"></span>
            <span class="rating-star"  data-id="1" data-value="2"></span>
            <span class="rating-star"  data-id="1" data-value="1"></span>

        </div>
		<br>
		 <div class="rating" id="rating2">
			<h3 style "color:#FFFFF">Importance:</style>
            <span class="rating-star" data-id="2" data-value="5"></span>
            <span class="rating-star" data-id="2" data-value="4"></span>
            <span class="rating-star" data-id="2" data-value="3"></span>
            <span class="rating-star" data-id="2" data-value="2"></span>
            <span class="rating-star" data-id="2" data-value="1"></span>

        </div>
		
		<br>
		<textarea rows="4" cols="50" id="noteArea"></textarea>
		<br><input type="button" value="Submit" onclick="return submit();" /><br> 
		<br>
		
	<div class="slideshow" id="box1">
	
	</div>
	
	



		
</div>

		

<script>

$(document).on("click", ".update_meeting", function () {
     $('#id_update_meeting').attr('value', $(this).data('id'));
});


function set_id(id){
	var x=document.getElementById("modalConfirm");
	x.datset.value=id;
	
}

function setta(id){
	var x=document.getElementById("id_update_meeting")
	x.value=id; 
}



// questa funzione è strutturata esattamente come la work experience: passo l'id di una esperienza che voglio cancellare ad una pagina che fa la query di delete
function delete_all(){
	var x=document.getElementById("modalConfirm");
	
		$.post("delete_meeting.php", {id: x.dataset.id});
		var deletion = $('#meeting').DataTable();
	deletion.ajax.reload();
} 


	var x = document.getElementById("card_id_box");

function showCardDetails(meeting_id)
{
	$.ajax({
		type: 'POST',
		url: 'carousel_meet.php',
		data: {"meeting_id": meeting_id},
		success:
			function (data) {
				
				$("#box1").html(data);
			}
	})
}





	function submit(){
		var x = document.getElementById("box");
		var text = document.getElementById("noteArea").value;
		var meeting_id=x.dataset.value;
		var submitStars= x.dataset.star1;
		var submitStars2= x.dataset.star2;
		
		$.post("submit_stars.php", {meeting_id:meeting_id, submitStars: submitStars,submitStars2: submitStars2, text:text}, function(data){
			alert(data);
		});
		
			
			}
			
			
        $('.rating-star').click(function() {
			var x = document.getElementById("box");
			
            $(this).parents('.rating').find('.rating-star').removeClass('checked');
            $(this).addClass('checked');
			$(this).val('');
            var submitStars = $(this).attr('data-value');
			if ($(this).attr('data-id')==1)
				x.dataset.star1=submitStars;
			else x.dataset.star2=submitStars;
			
		
			
		
			
        
        });
       



//mostra le informazioni riguardanti il meeting. Quando premo il pulsante passo anche qui l'ID del meeting che mi mostra tutte le informazioni prese dalla pagina 
//meetings.php che fa la query sul database e mi ritorna tutti i campi richiesti
function ShowMeetingDetails(id){	
$('#meeting_modal').dataTable( {
	"destroy":true,
	"serverSide": true,
	"ajax": {
            "url": "show_all_meetings.php",
			"type":"POST",
            "data": {
				"id":id
			}
	},
        "aoColumns": [
             
            { "mData": "title" },
            { "mData": "place"},
			{ "mData": "date" },
			{ "mData": "topic" }, 
			{ "mData": "invitation" },
			{ "mData": "card_id" },
			{ "mData": "language" }			
        ],
    });
	

}

$("#button_update_meeting").click(function(){
    var id = $("#id_update_meeting").val();
    var title = $("#title_update_meeting").val();
    var date = $("#date_update_meeting").val();
	var place = $("#place_update_meeting").val();
    $.post("update_meeting.php", { title: title, date: date, place: place, id: id });
	});


     //qui anzichè passare l'id faccio in modo che mi vengano ritornati tutti i meeting. Grazie ai bottoni posso mostrare i dettagli oppure eliminare il meeting. 
    $(document).ready( function() {
 var table= $('#meeting').dataTable( {
    "sAjaxSource": "show_all_meetings.php",
	"select": true,
	"bFilter": false,
        "dom": "Bfrti",
		"info":false,
        "responsive": true,
        "bDestroy": true,
        "aoColumns": [
             
            { "mData": "title" },
            { "mData": "place"},
			{ "mData": "invitation" },
			{"mData": "role"},
			{ "mData": "button_1","mRender":function(data, type, row){
           return "<button id='update_' class='update_meeting' data-toggle='modal' onclick='return setta("+row.meeting_id+")'  type='button' data-target='#updateMeetingModal'><i class = 'fa fa-edit' color='white'></i></button>  <button onclick='set_id("+row.meeting_id+")' type='button' id='delete_' data-toggle='modal' data-target='#modalConfirm' value='Delete'><i class = 'fa fa-trash-o'></i> <button onclick ='ShowMeetingDetails("+row.meeting_id+")' data-toggle='modal' id='delete_' data-target='#ModalCard' type='button' value='Show'><i class = 'fa fa-eye' color='white'></i></button></button>" 
         }},			
        ],
		
		
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				$('td', nRow).css( 'background', 'black' );
				$('td', nRow).css( 'text-align', 'left' );
				$('td', nRow).css( 'border-style', 'none' );
				$('td', nRow).css( 'border-color', 'grey' );
		}
		
		
    });
	
	
	 $('#meeting tbody').on( 'click', 'tr', function () {
		 var d = table.fnGetData(this);
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
			var x = document.getElementById("box");
				x.style.display = "none";
		}
        else {
			var x = document.getElementById("box");
            table.$('tr.selected').removeClass('selected');
			x.style.display = "none";
            $(this).addClass('selected');
			x.dataset.value = d.meeting_id;
			x.style.display = "block";
			showCardDetails(d.meeting_id);
		
	
       }
   } );
 
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );

	});






</script>
</body>
<style>
#new_meeting_btn{
	position:relative;
	left:1100px;
	top: 20px;
	background-color:black;
    transition-duration: 0.4s;
}
#new_meeting_btn:hover{
	 background-color: grey; /* Green */
    color: white;
}

#new_meeting_btn{
	position:relative;
	left:1100px;
	top: 20px;
	background-color:black;
    transition-duration: 0.4s;
}
#new_meeting_btn:hover{
	 background-color: grey; /* Green */
    color: white;
}





</style>

		
		</html>
		
		
		<?php 
}

else {
	echo "Si è verificato un errore, non puoi accedere a questa pagina<br>";	//inserisco un controllo che nel caso anche uno solo dei dati session non sia presente, allora stampo un messaggio di errore
	}

mysqli_close($conn);
?>
</html>
