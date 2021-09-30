<?php
session_start(); 
include("db.php"); //includo i dati del mio database
include("header.html");
//include("business_visual.php");

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

if(isset($_SESSION["userid"]))
{
	$userid=$_SESSION["userid"];

$query = "SELECT * FROM cards WHERE user_id=$userid";

$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>

<html class="no-js"> 
<head>

 <title>Business Cards</title> 
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
	
<body>


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

							<div class="fh5co-narrow-content" style="border:solid; ">
							<img src="business_card.png" style="width:600px; height:300px" />
								<div class="container" >
									<h2 align="center" id="title">
									 <?php echo  $row["title"]; ?>
									</h2>
									<form>
										<div class="form-group" >
											<h3 for="nome" align="center" id="nome"><?php echo $row["name"]." ".$row["surname"];?></h3>
										</div>
										
										<div class="form-group">
											<h3 for="email" align="center" id="email"><br> <br><?php echo $row["email"];?><br><br>
											<?php echo $row["phone"];?>
											</h3> 
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
						<br><br><br>
						<a class="btn btn-default" href="business_cards.php">Add</a>
						<a class="btn btn-default" href="business_cards_visual.php">See your card's list</a>

						<button class="w3-button w3-black w3-display-left" id="indietro" onclick="plusDivs(-1)">&#10094;</button>
						<button class="w3-button w3-black w3-display-right" id="avanti" onclick="plusDivs(1)">&#10095;</button>
					</div>

				</div>
        </div>
    </div>
</div>

<?php
}
?>
<style>
#fh5co-main, .fh5co-narrow-content, .w3-content w3-display-container .container {
	position: relative;
	left:120px;
	width: 600px;
	height: 305px;
	
}
#avanti{
	position:absolute;
	top:325px;
	right:490px;
	
}
#indietro{
	position:absolute;
	top:325px;
	left: 380px;
}
#title{
	color:black;
	position:relative;
	bottom: 190px;
	right:440px;
	
}
#nome{
	color:black;
	position:absolute;
	bottom: 90px;
	right:380px;
}

#email{
	color:black;
	position:absolute;
	bottom: 133px;
	right:5px;
}
</style>

	<script>
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
	 x[slideIndex-1].style.width= "50%";
	 x[slideIndex-1].style.height= "100%";
	 
  }
  x[slideIndex-1].style.display = "block";
  x[slideIndex-1].style.width= "50%";
	 x[slideIndex-1].style.height= "100%";
   
}
	</script>
</body>
</html>