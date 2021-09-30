<?php
session_start(); 
include("db.php"); //includo i dati del mio database

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);

if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}

//dopo la connessione mi assicuro di avere tutte le variabili $_SESSION presenti altrimenti vuol dire che l'utente non è loggato e quindi non gli faccio vedere proprio la pagina
if (isset($_POST["meeting_id"])){
		$meeting_id=mysqli_real_escape_string($_POST["meeting_id"]);
		$query="SELECT * FROM partecipate WHERE meeting_id=$meeting_id";
		$result=mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Meetings</title>
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
	<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
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
            
            
            /* Just for the demo */
            body {
                margin: 20px;
            }
        </style>
</head>

<textarea rows="4" cols="50" id="noteArea"></textarea>
<br><input type="button" value="Submit" onclick="return submit();" /><br> 

<div id="fh5co-main">
        <div class="fh5co-narrow-content">
            <div class="container">
				
					<a class="btn btn-default" href="business_cards.php">Add</a>
					<a class="btn btn-default" href="business_cards_visual.php">See your card's list</a>
				
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
										Title: <?php echo  $row["user_id"]; ?>
									</h2>
									<form>
										<div class="form-group">
											<label for="nome">Nome</label>
											<div>
												<?php echo $row["meeting_id"];?>
											</div>
										</div>
										<div class="form-group" align="left">
											<label for="cognome">Cognome</label>
											<div>
												<?php echo $row["card_id"];?>
											</div>
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

						<button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
						<button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
					</div>

				</div>
        </div>
    </div>
</div>

<?php
}
?>

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
  }
  x[slideIndex-1].style.display = "block";
}
</script>