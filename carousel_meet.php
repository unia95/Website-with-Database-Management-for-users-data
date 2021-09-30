<?php
session_start(); 
include("db.php"); //includo i dati del mio database

// Connessione al database
$conn = mysqli_connect($servername, $user, $pass, $db_name);
//dopo la connessione mi assicuro di avere tutte le variabili $_SESSION presenti altrimenti vuol dire che l'utente non è loggato e quindi non gli faccio vedere proprio la pagina
if (isset($_POST["meeting_id"])){
		$userid=$_SESSION["userid"];
		$meeting_id=mysqli_real_escape_string($conn, $_POST["meeting_id"]);
		$query="SELECT * FROM partecipate WHERE meeting_id=$meeting_id";
		$result=mysqli_query($conn,$query);
?>


<?php
$query2="";
$i=0;
$numrows=mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
						{
							$query2="SELECT * FROM cards WHERE user_id=".$row['user_id']." AND user_id <> $userid ";
							$result2=mysqli_query($conn, $query2);
						while($row2=mysqli_fetch_array($result2, MYSQLI_ASSOC)){
							$i++;
?>
        <div class='fh5co-narrow-content'>
        
				
				<div class='w3-content w3-display-container'>
					
					
						
						
					<!--<div class="mySlides" id="card_id_box"style="border:solid" data-card_id="<?php echo $row2["card_id"];?>">-->

							<div class="mySlides" id="card_id_box"  data-card_id="<?php echo $row2["card_id"];?>"style='border:solid'>
								
									<h2 align='justify'>
										Title: <?php echo $row2['title'];?> 
									</h2>
									<form>
										<div class='form-group'>
											<label for='name' data-value="<?php echo $row2['name'];?>">Name</label>
											<div>
												 <?php echo $row2['name'];?>
											</div>
										</div>
										<div class='form-group' align='left'>
											<label for='surname' data-value="<?php echo $row2['surname'];?>">Surname</label>
											<div>
											<?php echo $row2['surname'];?>
											</div>
										</div>
										<div class='form-group' align='left'>
											<label for='email' data-value="<?php echo $row2['email'];?>">Email</label>
											<div>
											<?php echo $row2['email'];?>
											</div>
										</div>
										<div class='form-group' align='left'>
											<label for='phone' data-value="<?php echo $row2['phone'];?>">Phone</label>
											<div>
											<?php echo $row2['phone'];?>
											</div>
										</div>
										<div class='form-group' align='left'>
											<label for='card_id' data-value="<?php echo $row2['card_id'];?>">Card ID</label>
											<div>
											<?php echo $row2['card_id'];?>
											</div>
										</div>

									</form>
							</div>
						
					</div>
						<?php }}
						if ($numrows>0){?>
						
						<button class='w3-button w3-black w3-display-left' id="indietro" onclick='plusDivs(-1)'>&#10094;</button>
						<button class='w3-button w3-black w3-display-right' id="avanti" onclick='plusDivs(1)'>&#10095;</button>

			</div>
        </div>
	
	<div class="col-sm-6">
				<h2>Partecipant Notes</h2>
				<div id="partecipants_notes" style="border:solid">
				
				</div>
			</div>		
	
												
<script>



var slideIndex = 1;
showDivs(slideIndex);

function showDetails(card_id)
{
	$.ajax({
		type: 'POST',
		url: 'partecipants_info.php',
		data: {"card_id":card_id ,"meeting_id":<?php echo $meeting_id;?>},
		success:
			function (data) {
				$("#partecipants_notes").html(data);
			}
	})
}



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
  var card_id = $(x[slideIndex - 1]).attr("data-card_id");
  showDetails(card_id);
}


</script>

<style>

#card_id_box{
	padding-left:100px;
	width: 300px;
	height: 400px;
	top: 300px;
}
#indietro{
	position:relative;
	left:230px;
	bottom:269px;
}

#avanti{
	position:relative;
	left:260px;
	bottom:269px;
}
</style>
<?php
						}
						else{
							echo "<p> No partecipant available</p>";
						}
}
?>

