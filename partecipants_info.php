<?php
session_start();

 include ("db.php");		//includo il mio database
 $conn = mysqli_connect($servername, $user, $pass, $db_name);	//instauro una connessione
  
 if (isset($_POST["card_id"])) {
	 
	 $card_id=mysqli_real_escape_string($conn, $_POST["card_id"]);
	 $userid= $_SESSION["userid"];

	 $query = "SELECT * FROM cards WHERE card_id=$card_id";
	 $result = mysqli_query($conn, $query);
	 $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
?>


	<div class="form-group" id="box_info">
		<label for="name_surname">Name: <?php echo $row["name"]. " " . $row["surname"];?></label>
		<div>
		<label for="photo"><?php echo $row["photo"]; ?></label>	
		</div>
		
		<div id="box_people" method="POST" data-ruser="<?php echo $row["user_id"];?>" data-value="" data-star_1="" data-star_2="" data-star_3=""><br>

  <div class="rating" id="rating_1">
			<h3 style "color:#FFFFF">Professionality:</style>
            <span class="rating-star"  data-id="1" data-value="5"></span>
            <span class="rating-star"  data-id="1" data-value="4"></span>
            <span class="rating-star"  data-id="1" data-value="3"></span>
            <span class="rating-star"  data-id="1" data-value="2"></span>
            <span class="rating-star"  data-id="1" data-value="1"></span>

        </div>
		<br>
		 <div class="rating" id="rating_2">
			<h3 style "color:#FFFFF">Impression:</style>
            <span class="rating-star" data-id="2" data-value="5"></span>
            <span class="rating-star" data-id="2" data-value="4"></span>
            <span class="rating-star" data-id="2" data-value="3"></span>
            <span class="rating-star" data-id="2" data-value="2"></span>
            <span class="rating-star" data-id="2" data-value="1"></span>

        </div>
		
		<br>
		 <div class="rating" id="rating_3">
			<h3 style "color:#FFFFF">Availability:</style>
            <span class="rating-star" data-id="3" data-value="5"></span>
            <span class="rating-star" data-id="3" data-value="4"></span>
            <span class="rating-star" data-id="3" data-value="3"></span>
            <span class="rating-star" data-id="3" data-value="2"></span>
            <span class="rating-star" data-id="3" data-value="1"></span>

        </div>
		
		<br>
		<textarea rows="4" cols="50" id="noteArea2"></textarea>
		<br><input type="button" value="Submit" onclick="return submit2();" /><br> 
		<br>
		
		
		
	</div>


	 
	 	 


<script>
	function submit2(){
		var z = document.getElementById("box_people");
		var text2 = document.getElementById("noteArea2").value;
		var meeting_id=<?php echo $_POST["meeting_id"];?>;
		var submitStars_1= z.dataset.star_1;
		var submitStars_2= z.dataset.star_2;
		var submitStars_3= z.dataset.star_3;
		var rated_user=z.dataset.ruser;
		
		$.post("submit_stars_people.php", {meeting_id:meeting_id, rated_user:rated_user, submitStars_1: submitStars_1, submitStars_2: submitStars_2, submitStars_3: submitStars_3, text2: text2}, function(data){
			alert(data);
		});
		
			
			}
			
			
        $('.rating-star').click(function() {
			var x = document.getElementById("box_people");
			
            $(this).parents('.rating').find('.rating-star').removeClass('checked');
            $(this).addClass('checked');
			$(this).val('');
            var submitStars = $(this).attr('data-value');
			if ($(this).attr('data-id')==1)
				x.dataset.star_1=submitStars;
			else if ($(this).attr('data-id')==2)
				x.dataset.star_2=submitStars;
			else x.dataset.star_3=submitStars;
			
		
			
		
			
        
        });
</script>

<?php
 }				
 ?>