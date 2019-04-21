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
$existingCategory = $_POST['existingCategory'];
if ( $_POST['category'] == 'category-edit' ){
  $_POST['category'] = $existingCategory;
}
$existingTime = $_POST['existingTime'];
if ( $_POST['time'] == 'time-edit' ){
  $_POST['time'] = $existingTime;
}

$newRecipe = [
  "title" => $_POST['title'],
  "about" => $_POST['about'],
  "recipe" => $_POST['recipe'],
  "category" => $_POST['category'],
  "time" => $_POST['time'],
  "kids" => $_POST['kids'],
  "glutenfree" => $_POST['glutenfree'],
  "idRecipe" => $_POST['idRecipe']
];

// var_dump($_SESSION);
// var_dump($newRecipe);
// die();

// update for table RECIPES
$sqlRecipesUpdate="UPDATE recipes
             SET TITLE='$newRecipe[title]' , ABOUT ='$newRecipe[about]' , RECIPE = '$newRecipe[recipe]',
             CATEGORY= '$newRecipe[category]', PREPARE_TIME = '$newRecipe[time]', KIDS='$newRecipe[kids]', GLUTEN_FREE='$newRecipe[glutenfree]'
             WHERE ID_RECIPE = '$newRecipe[idRecipe]' ";

// print_r($sqlRecipesUpdate);
// die();
//
$db->query($sqlRecipesUpdate);


// add to table COMPONENTS
$components = [
		"component" => $_POST['component'],
		"amount" => $_POST['amount']
];

$count = count($components["component"]);
$db->query($sqlDeleteOldComponents);
for( $i=0 ; $i<$count; $i++){
	$component = $components["component"][$i];
	$amount =  $components["amount"][$i];
  $sqlDeleteOldComponents = "DELETE FROM components WHERE RECIPE_ID = '$newRecipe[idRecipe]' ";
  // $sqlComponentsUpdate = "UPDATE components
  //                   SET COMPONENT = '$component' , AMOUNT = '$amount'
  //                   WHERE RECIPE_ID = '$newRecipe[idRecipe]' ";
  $sqlComponentsReplace ="INSERT INTO components ( ID_COMPONENT , RECIPE_ID, COMPONENT, AMOUNT) VALUES (default ,'$newRecipe[idRecipe]', '$component', '$amount')";

  print_r($sqlDeleteOldComponents);
	print_r($sqlComponentsReplace);

	$db->query($sqlComponentsReplace);
}
// die();
//add to table IMAGES
$existingPhoto = $_POST['existingPhoto'];
$imagename=$_FILES["image"]["name"];
$target_dir = "images/upload/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
if( $target_file == $target_dir)
{
  $target_file = $existingPhoto;
}

$sqlPhotosUpdate = "UPDATE photos
                    SET PHOTO_PATH = '$target_file'
                    WHERE RECIPE_ID = '$newRecipe[idRecipe]' ";

// Upload file
move_uploaded_file($_FILES['image']['tmp_name'],$target_dir.$imagename);

print($sqlPhotosUpdate);
// $db->query($sqlPhotosUpdate);



header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;

?>
