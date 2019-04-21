<?php
	session_start();
	$_SESSION['page'] = 'main';
	//var_dump($_SESSION);

	require ("db_connection.php");

?>

<?php include("header.php"); ?>

<?php include('breadcrumbs.php'); ?>

		<section class="container categoryNavigation">
			<?php
			if(isset($_GET['category'])){
				$category = $_GET['category'];
						echo '<h3 class="title">Kategoria: \''.$category.'\'</h3>';
						
			}
			if( isset($_GET['title']))
			{
				if( $_GET['title'] == 'favourite_recipes')
					echo '<h3 class="title">Moje ulubione przepisy</h3>';
				if( $_GET['title'] == 'my_recipes')
					echo '<h3 class="title">Moje przepisy</h3>';
			}else{
				if( !isset($_GET['category']))
					echo '<h3 class="title">Wszystkie przepisy kulinarne</h3>';
			}
			?>

			<div <?php
				if(( isset($_GET['title'])) && ( $_GET['title'] == 'favourite_recipes' || $_GET['title'] == 'my_recipes')){
					echo'class="mealType categoryNavigation__nav hidden"';
				}else{
					echo'class="mealType categoryNavigation__nav"';
				}
			?>>
				<a href="main.php" <?php
					if(!isset($_GET['category'])){
						echo 'class="categoryBtn activeCategory"';
					}else{
						echo 'class="categoryBtn"';
					}
				 ;?>>Wszystkie przepisy</a>
        <a href="main.php?category=sniadanie" <?php
					if( $category == 'sniadanie'){
						echo 'class="categoryBtn activeCategory"';
					}else{
						echo 'class="categoryBtn"';
					}
				 ;?>>śniadanie</a>
				 <a href="main.php?category=lunch" <?php
 					if( $category == 'lunch'){
 						echo 'class="categoryBtn activeCategory"';
 					}else{
 						echo 'class="categoryBtn"';
 					}
 				 ;?>>lunch</a>
				 <a href="main.php?category=obiad" <?php
					if( $category == 'obiad'){
						echo 'class="categoryBtn activeCategory"';
					}else{
						echo 'class="categoryBtn"';
					}
				 ;?>>obiad</a>
				 <a href="main.php?category=kolacja" <?php
					if( $category == 'kolacja'){
						echo 'class="categoryBtn activeCategory"';
					}else{
						echo 'class="categoryBtn"';
					}
				 ;?>>kolacja</a>
				 <a href="main.php?category=deser" <?php
					if( $category == 'deser'){
						echo 'class="categoryBtn activeCategory"';
					}else{
						echo 'class="categoryBtn"';
					}
				 ;?>>deser</a>
      </div>
		</section>
		<section class="container border"></section>
		<section class="container">

				<?php

					$db = new mysqli( $_DB_SERVER_ , $_DB_USER_, $_DB_PASSWD_, $_DB_NAME_);

					if(isset($_GET['title'])){
						$userID = $_SESSION["userID"];
						//  moje przepisy
						if( $_GET['title'] == 'my_recipes'){
							$sql="SELECT recipes.ID_RECIPE ,recipes.TITLE, recipes.ABOUT, recipes.RECIPE, recipes.USER_ID , recipes.CATEGORY, recipes.PREPARE_TIME, recipes.KIDS, recipes.GLUTEN_FREE FROM RECIPES WHERE USER_ID = '$userID'  "; // tutaj trzeba zmienic to 8 na id usera
						}
						//  ulubione przepisy
						if( $_GET['title'] == 'favourite_recipes'){
							$sql= "SELECT recipes.ID_RECIPE ,recipes.TITLE, recipes.ABOUT, recipes.RECIPE, recipes.USER_ID , recipes.CATEGORY, recipes.PREPARE_TIME, recipes.KIDS, recipes.GLUTEN_FREE
											FROM recipes
											INNER JOIN favourite_recipes ON recipes.ID_RECIPE = favourite_recipes.RECIPE_ID
											WHERE favourite_recipes.USER_ID = $userID ";
						}
					}else{
						// wszystkie przepisy
						$sql="SELECT recipes.ID_RECIPE ,recipes.TITLE, recipes.ABOUT, recipes.RECIPE, recipes.USER_ID , recipes.CATEGORY, recipes.PREPARE_TIME, recipes.KIDS, recipes.GLUTEN_FREE  FROM RECIPES ORDER BY ID_RECIPE DESC ";
					}

					// strona kategorii
					if(isset($_GET['category'])){
						$category = $_GET['category'];
						// var_dump($category);
						// die();
						switch ($category) {
							case 'sniadanie':
								$sql="SELECT * FROM RECIPES WHERE CATEGORY = 'SNIADANIE' ";
								break;
							case 'lunch':
								$sql="SELECT * FROM RECIPES WHERE CATEGORY = 'LUNCH' ";
								break;
							case 'obiad':
								$sql="SELECT * FROM RECIPES WHERE CATEGORY = 'OBIAD' ";
								break;
							case 'kolacja':
								$sql="SELECT * FROM RECIPES WHERE CATEGORY = 'KOLACJA' ";
								break;
							case 'deser':
								$sql="SELECT * FROM RECIPES WHERE CATEGORY = 'DESER' ";
								break;
						}
					}

					// ==================

					$results = $db->query($sql);

						$licznik = 0;
						while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)) {

							//print_r ($row);
							if ($licznik == 0 || $licznik %3 == 0) {
								echo '<div class="row cards">' ;
							}
							$licznik++;

							$sqlImageQuery = "SELECT PHOTO_PATH FROM photos WHERE RECIPE_ID ='$row[ID_RECIPE]'";
							$imagePath = $db->query($sqlImageQuery);
							$imagePath = mysqli_fetch_array($imagePath,MYSQLI_ASSOC);

							// var_dump($imagePath['PHOTO_PATH']);
							// die();

							// var_dump($row);
							// die();
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
	</div>

	<?php include("footer.php"); ?>

</boody>
</html>
