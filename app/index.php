<?php
	session_start();
	


	if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true))
	{
		header("Location: main.php");
		exit();
	}

?>

<?php include("header.php"); ?>

		<section class="container-fluid noPadding loginSectionContainer">
			<div class="loginSection">
				<div class="container d-flex">
					<form autocomplete="off" class="loginSection__form" action="php_zaloguj.php" method="post">
					<?php
							if(isset($_SESSION['success'])){
								echo '<div class="success">'.$_SESSION['success'].'</div>';
								unset($_SESSION['success']);
							}
				    ?>  <!-- udana rejestracja -->
					 <?php
							 if(isset($_SESSION['blad'])) {
							 	echo $_SESSION['blad'];
							 	unset($_SESSION['blad']);     // jak tego nie bedzie nie zniknie napis o bledzie
							 }
						?>  <!-- nieudane logowanie -->

						<label for="login">Login:</label>
						<input type="text" name="login" id="login">
						<label for="password:">Hasło:</label>
						<input type="password" name="password" id="password"></br>
						<input type="submit" value="Zaloguj" class="submit" /></br>
						<p>Nie masz jeszcze konta ?</p>
						<a href="registration.php"><p>Zarejestruj się</p></a>
					</form>
				</div>
			</div>

		</section>
		<section class="container">

				<div class="titleBox">
					 <h3>Najnowsze przepisy</h3>
				</div>
				<?php

					$db = new mysqli( $_DB_SERVER_ , $_DB_USER_, $_DB_PASSWD_, $_DB_NAME_);

					if($db->connect_errno > 0){
						die('Unable to connect to database [' . $db->connect_error . ']');
					}

					$sql="SELECT recipes.ID_RECIPE ,recipes.TITLE, recipes.ABOUT, recipes.RECIPE, recipes.USER_ID , recipes.CATEGORY, recipes.PREPARE_TIME, recipes.KIDS, recipes.GLUTEN_FREE FROM RECIPES ORDER BY ID_RECIPE DESC LIMIT 0, 6";
					$results = $db->query($sql);

						$licznik = 0;
						while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)) {

							print_r ($row);
							if ($licznik == 0 || $licznik %3 == 0) {
								echo '<div class="row cards">' ;

							}
							$licznik++;

							$sqlImageQuery = "SELECT PHOTO_PATH FROM photos WHERE RECIPE_ID ='$row[ID_RECIPE]'";
							$imagePath = $db->query($sqlImageQuery);
							$imagePath = mysqli_fetch_array($imagePath,MYSQLI_ASSOC);

										echo '
											<div class="col-sm-12 col-md-4">
										  	<a href=" fullrecipe.php?title='.$row["TITLE"].'">
														<div class="card">
															<div class="card-img-top" style="background-image: url('.$imagePath["PHOTO_PATH"].')">
																<!--	<div class="card__label hide-on-mobile">
																		<p>DZIECI</p>
																	</div> -->
																	<div class="card__awarded">
																		';
																			if( $row["KIDS"] == 1)
																			{
																				echo '<span class="card__awarded__icon kids_icon_svg"></span>';
																			}
																			if( $row["GLUTEN_FREE"] == 1)
																			{
																				echo	'<span class="card__awarded__icon glutenfree_icon_svg"></span>';
																			}
													echo	'</div>
																	<div class="cardOverlay">
																			<div class="cardOverlay__iconBox">
																				<div class="cardOverlay__icon">
																					<span class="cardOverlay__icon-svg time"></span>
																					<div class="cardOverlay__label">
																						<span>'.$row["CATEGORY"].'</span>
																					</div>
																				</div>

																				<div class="cardOverlay__icon">
																					<span class="cardOverlay__icon-svg clock"></span>
																					<div class="cardOverlay__label">
																						<span>'.$row["PREPARE_TIME"].'</span>
																					</div>
																				</div>
																			</div>
																	</div>
															</div>
											      <div class="card__body">
											        <h4 class="card__title">
											        	'.$row["TITLE"].'
											        </h4>
											        <p class="card-text overflow hide-on-mobile">
																'.mb_strimwidth($row["ABOUT"], 0, 200, "..."). '
											        </p>
											        <p class="card-text date">02/02/2018</p>
											      </div>
										    	</div>
										    </a>
										  </div>
										';

							if ($licznik==0 || $licznik % 3 == 0) {
								echo '</div> <!--end-->'  ;   // end of section
							}
						}


				?>
		</section>
		<section class="seeMore container-fluid flexCentered">
			<div class="col-md-7 hidden-xs"></div>
			<div class="col-md-5 col-xs-12">
				<a href="main.php">
					<div class="seeMore__button">
						<h3>Wszystkie przepisy</h3>
					</div>
				</a>
			</div>
		</section>
	</div>

<?php include("footer.php"); ?>
