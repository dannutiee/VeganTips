<?php
require ("db_connection.php");
session_start();

error_reporting(E_ALL); // poziom raportowania, http://pl.php.net/manual/pl/function.error-reporting.php
ini_set('display_errors', 1);

$db = new mysqli( $_DB_SERVER_ , $_DB_USER_, $_DB_PASSWD_, $_DB_NAME_);   //nawiazuje poleczenie z baza

if ( !isset($_POST['kids']) ){
  $_POST['kids'] = 0 ;
}
if (!isset($_POST['glutenfree'])){
  $_POST['glutenfree'] = 0;
}

$newRecipe = [
  "title" => $_POST['title'],
  "about" => $_POST['about'],
  "recipe" => $_POST['recipe'],
  "category" => $_POST['category'],
  "time" => $_POST['time'],
  "kids" => $_POST['kids'],
  "glutenfree" => $_POST['glutenfree']
];

// var_dump($_SESSION);
// die();

// ad to table RECIPES
$sqlRecipes="INSERT INTO recipes ( ID_RECIPE , TITLE, ABOUT, RECIPE, USER_ID, CATEGORY, PREPARE_TIME, KIDS, GLUTEN_FREE) VALUES (default, '$newRecipe[title]','$newRecipe[about]','$newRecipe[recipe]','$_SESSION[userID]', '$newRecipe[category]' , '$newRecipe[time]', '$newRecipe[kids]', '$newRecipe[glutenfree]' );
";
$sqlsetRecipeID = "SET @last_id_in_recipes = LAST_INSERT_ID();" ;

print_r($sqlRecipes);
// die();
//
$db->query($sqlRecipes);
$db->query($sqlsetRecipeID);

// add to table COMPONENTS
$components = [
		"component" => $_POST['component'],
		"amount" => $_POST['amount']
];

$count = count($components["component"]);
for( $i=0 ; $i<$count; $i++){
	$component = $components["component"][$i];
	$amount =  $components["amount"][$i];
	$sqlComponents = "INSERT INTO components ( ID_COMPONENT , RECIPE_ID, COMPONENT, AMOUNT) VALUES (default ,@last_id_in_recipes, '$component', '$amount')";

	print_r($sqlComponents);
	// die();
	$db->query($sqlComponents);
}

//add to table IMAGES
$imagename=$_FILES["image"]["name"];
$target_dir = "images/upload/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$sqlPhotos = "INSERT INTO photos (ID_PHOTO, PHOTO_PATH, RECIPE_ID) VALUES ( default,'$target_file', @last_id_in_recipes )";
// Upload file
move_uploaded_file($_FILES['image']['tmp_name'],$target_dir.$imagename);

print($sqlPhotos);
// die();
$db->query($sqlPhotos);

header("Location: main.php");

?>
