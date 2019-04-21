<?php
require ("db_connection.php");
session_start();

error_reporting(E_ALL); // poziom raportowania, http://pl.php.net/manual/pl/function.error-reporting.php
ini_set('display_errors', 1);

$db = new mysqli( $_DB_SERVER_ , $_DB_USER_, $_DB_PASSWD_, $_DB_NAME_);   //nawiazuje poleczenie z moja baza

$newFavourite = [
    "id_recipe" => $_POST['id_recipe'],
    "id_user" => $_POST['id_user'],
];
$actionType = $_POST['actionType'];

if ($actionType == 'add'){
  var_dump('pierwszy');
  $sqlFavourites="INSERT INTO favourite_recipes ( ID_FAV_RECIPE , RECIPE_ID, USER_ID) VALUES (default, '$newFavourite[id_recipe]','$newFavourite[id_user]')";
}
if ( $actionType == 'remove'){
  var_dump('drugi');
  $sqlFavourites="DELETE FROM favourite_recipes WHERE RECIPE_ID = '$newFavourite[id_recipe]' AND USER_ID = '$newFavourite[id_user]' ";
}

$db->query($sqlFavourites);

?>
