<?php

session_start();
$_SESSION['page'] = 'fullrecipe';

// var_dump($_SESSION);
// die();
?>
<?php include("header.php"); ?>
<?php

	require ("db_connection.php");
 //okno widoczne po przesłaniu zmiennej z pliku main.php po naciścięciu 'zobacz przepis!'

	$db = new mysqli( $_DB_SERVER_ , $_DB_USER_, $_DB_PASSWD_, $_DB_NAME_);
	$title = $_GET['title'];
	$sql="SELECT * FROM RECIPES WHERE TITLE = '$title' ";
	$results = $db->query($sql);

	while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)){

	// var_dump($row);
	$id_recipe = $row['ID_RECIPE'];

	$sqlImagePathQuery = "SELECT PHOTO_PATH FROM PHOTOS WHERE RECIPE_ID = '$id_recipe' ";
	$photoPath = $db->query($sqlImagePathQuery);
	$photoPath = mysqli_fetch_array($photoPath,MYSQLI_ASSOC);

	$sqlGetComponents = "SELECT * FROM components WHERE RECIPE_ID = '$id_recipe' ";
	$getComponents = $db->query($sqlGetComponents);
	$getComponentsToEdit = $db->query($sqlGetComponents);

	if(!isset($_SESSION['zalogowany'])||($_SESSION['zalogowany']==false)){
	}else {
		$user_id = $_SESSION['userID'];
		$recipe_id = $row['ID_RECIPE'];
		$sqlGetFavRecipes = "SELECT ID_FAV_RECIPE FROM `favourite_recipes` WHERE USER_ID = $user_id AND RECIPE_ID= $recipe_id ";
		$getFavRecipes = $db->query($sqlGetFavRecipes);
	}

	// $photo_path_r = mysqli_fetch_array($photo_path,MYSQLI_ASSOC );
	// var_dump($sqlImagePathQuery);
	// var_dump($photoPath);

	// var_dump($row);
	// 	die();
	?>

<?php include('breadcrumbs.php'); ?>


	<div class="container">

<?php

	echo "<div class='content fullrecipe'>";
		echo "<div class = 'fullrecipe__title'><h3>";
		echo $row['TITLE'];
		echo "</h3>";
		if( $_SESSION['userID'] == $row['USER_ID'])
		{
			echo "<button type='button' class='editButton btn btn-info btn-lg' data-toggle='modal' data-target='#editRecipe'>Edytuj</button>";
			include('modal_editRecipe.php');
		}
		echo "</div>";
		echo "<div class='row' ><div class = 'col-md-5 col-sm-5 noPadding'><div class='fullrecipe__photo col-md-12 col-sm-12'><img class='mainPhoto' src=' ";
		echo $photoPath['PHOTO_PATH'];
		echo "'></div>";
					if(!isset($_SESSION['zalogowany'])||($_SESSION['zalogowany']==false))
					{

					}else {
						echo	"<div class='eventButtons co-md-12 col-sm-12'>";
						if ($rowFavRecipes=mysqli_fetch_array($getFavRecipes,MYSQLI_ASSOC)){
								echo "<div id='removeFromFav' data-recipe_id='".$row['ID_RECIPE']."' data-user_id='".$_SESSION['userID']."' data-actionType='remove' class='button button__favourite'>Usuń z ulubionych</div>";
						}else{
								echo	"<div id='addToFav' data-recipe_id='".$row['ID_RECIPE']."' data-user_id='".$_SESSION['userID']."' data-actionType='add' class='button button__favourite'>Dodaj do ulubionych</div>";
						}
						echo	"	<div class='button button__report'>Zgłoś naruszenie zasad</div>
									</div>";
					}

		echo	"</div>";
		// end photo div
		echo "<div class='col-md-7 col-sm-7 components'>
						<h4 class='subtitle'>Składniki</h4>
						<table class='components__table'>";

		while ($rowComponents=mysqli_fetch_array($getComponents,MYSQLI_ASSOC)){
				echo "<tr><td>".$rowComponents['COMPONENT']."</td>
				<td>".$rowComponents['AMOUNT']."</td></tr>";
		}
		echo "</table>";
		echo "<div class = 'fullrecipe__about'><h4 class='subtitle'>Opis</h4><p>";
		echo $row['ABOUT'];
		echo "</p></div>";
		echo "<div class = 'fullrecipe__recipe'><h4 class='subtitle'>Wykonanie</h4><p>";
		echo $row['RECIPE'];
		echo "</p></div>";
		echo "</div>";
 		echo "</div> <!--row end -->";

	echo "</div>";
}
?>
<?php include("footer.php"); ?>
</div>
</body>
</html>
