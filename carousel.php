<div class="carousel" data-flickity>
						<?php
							while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
								echo	"<div class='carousel-cell'>
											<div class='card'>
												<div class='card-img-top card-img-top-250'>
													<img class='img-thumbnail' src='".$row['photo']."' alt='Carousel 1'>
												</div>
												<div class='card-block p-t-2'>
													<h6> ".$row['title']."	</h6>
													
													<h4> ".$row['name']." ".$row['surname']." </4><br>
													<h5>	".$row['email']." 
													</h5>
													<center>
													<button class='btn btn-outline-danger'  onclick='OpenEditModal(".$row['card_id'].");'><i class='fas fa-pencil-alt'></i> </button>
													</center>
												</div>
											</div>
										</div>";
							}
						?>
				</div>