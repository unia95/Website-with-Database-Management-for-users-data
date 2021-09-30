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

	$userid=$_SESSION["userid"];

$query = "SELECT * FROM cards WHERE user_id=$userid";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Wizard</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/jquery.steps.js"></script>
  <script src="js/jquery.steps.min.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.steps.css">


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
</head>
<body class="w3-black">
<div class="w3 m3">


<div class="col-container" align="right">
<div class="col">
<form id="example-form" action="#" class="wizard">
    <div>
        <h3>Add a meeting</h3>
        <section>
            <label for="title">Title *</label> 
             <input id="title" name="title" type="text" class="required"> 
            <label for="data">Data *</label>
            <input id="data" name="data" type="date" class="required">
           <!--  <label for="time">Time *</label>
            <input id="time" name="time" type="time" class="required"> -->
			<label for="place">Place *</label>
            <input id="place" name="place" type="text" class="required">
			<label for="topic">Topic *</label>
            <input id="topic" name="topic" type="text" class="required">
			<label for="lang">Language *</label>
            <input id="lang" name="lang" type="text" class="required">
            <p>(*) Mandatory</p>
        </section>
        <h3>Partecipants</h3>
        <section> 
		
          <table id="partecipants" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
				<th>Role</th>
				<th>Options</th>
            </tr>
        </thead>
    </table>
            
        </section> 

        <h3>Choose Profile</h3>
        <section>
		    <div id="fh5co-main">
        <div class="fh5co-narrow-content">
            <div class="container">
				
					<div class="w3-content w3-display-container">
						<?php
					$i=0;
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
						{
							$i++;
						?>
						<div class="mySlides">

							<div class="fh5co-narrow-content" style="border:solid">
								<div class="container">
									<h2 align="justify">
										Title: <?php echo  $row["title"]; ?>
									</h2>
									<form>
										<div class="form-group">
											<label for="nome">Nome</label>
											<div>
												<?php echo $row["name"];?>
											</div>
										</div>
										<div class="form-group" align="left">
											<label for="cognome">Cognome</label>
											<div>
												<?php echo $row["surname"];?>
											</div>
										</div>
										<div class="form-group">
											<label for="email">Email</label>
											<div>
												<?php echo $row["email"];?>
											</div>
										</div>
										<div class="form-group">
											<label for="data_di_nascita"></label>
											<input type="checkbox" id="<?php echo $i;?>" onchange="toggle(this)" value=<?php echo $row["card_id"];?> />
										</div>
										<div>
											<!-- questo div in più è fatto per mettere il submit distaccato dagli inserimenti -->
										</div>

									</form>
								</div>
							</div>


							<!--<img  src="images/img_fjords.jpg" style="width:100%">-->

						</div>
						<?php }?>

						<a class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</a>
						<a class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</a>
					</div>

				</div>
        </div>
    </div>
</div>

     
        </section>
    </div>
</form>
</div>
</div>
</div>

<script>
var i=0;
var userid=[];
var j=0;
var card_id=0;
function invite_people(user_id, btn){
	userid.push(user_id);
	i=i+1;
	document.getElementById(user_id).classList.add('disabled');
}

function toggle(element){
	if (j==1){
		if (!element.checked)
			j=0;
		else {
			alert("hai già selezionato una card, deselezionala per procedere");
			element.checked= !element.checked;
		}
	}
	else {
		j=1;
		card_id=element.value;
	}
	
}

function insert_messages(data){
		$.post("send_invitation.php", {user_id: userid, meeting_id: data});
}

var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = $(".mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}

  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  x[slideIndex-1].style.display = "block";
}
	
$(document).ready(function(){

	var form = $("#example-form");
		
	form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
	
	//quando clicco il bottone di finish
    onFinished: function (event, currentIndex)
    {
	var title = $("#title").val();
	var lang = $("#lang").val();
	var place = $("#place").val();
    var date= $("#data").val();
	var topic = $("#topic").val();
	var inv=i;
    $.post("meeting_insert.php", { title: title, place: place, lang: lang, date: date, topic: topic, card_id: card_id, inv: inv}, function(data){
		insert_messages(data)});

	alert("Submitted!");
	window.open("meetings_visual.php", "_self");
	
	}
	
})
	
	

  $('#partecipants').dataTable( {
    "sAjaxSource": "partecipants.php",
	"bFilter": true,
        "dom": "Bfrtip",
        "responsive": true,
        "bDestroy": true, 
		"rowID": 'user_id',
        "aoColumns": [
            { "mData": "name" },
            { "mData": "company"},
			{ "mData": "role" },
			{ "mData": "button_1","mRender":function(data, type, row){
           return "<a id="+row.user_id+" class='btn' onclick='invite_people("+row.user_id+", this)'>Invite</a>"
         }},			
        ],
    });
	

 
})
    
	

	</script>
	
	<style>
	#example-form{
	width: 90%;
	text-align: left;
}

	
	</style>
	
</body>

</html>

		
		<?php 
}

else {
	echo "Si è verificato un errore, non puoi accedere a questa pagina<br>";	//inserisco un controllo che nel caso anche uno solo dei dati session non sia presente, allora stampo un messaggio di errore
	}

mysqli_close($conn);
?>