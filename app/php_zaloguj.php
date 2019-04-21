<?php

session_start();
require ("db_connection.php");

	if ((!isset($_POST['login'])) || (!isset($_POST['password']))){
		header('Location: index.php');
		exit();
	}

	$polaczenie = new mysqli( $_DB_SERVER_ , $_DB_USER_, $_DB_PASSWD_, $_DB_NAME_);

	$login=$_POST['login'];
	$haslo=$_POST['password'];

	$sql="SELECT * FROM users where login='$login' and password='$haslo'";


	if($results = $polaczenie->query($sql))     /*moze wystapic pusty rezultat */
	{
		$row=mysqli_fetch_array($results,MYSQLI_ASSOC);

		$rows=count($row);
		echo $rows;
		// var_dump($rows);
		// die();
			if($rows == 5){
			$_SESSION['zalogowany'] = true;

			$_SESSION['user']= $row['LOGIN'];
			$_SESSION['userID'] = $row['ID'];

			unset($_SESSION['blad']);

			mysqli_free_result($results) ;  //czysci rezultat zapytania
			header("Location: main.php");

			}else{

			$_SESSION['blad'] = "<p id='blad' class='error'>Niepoprawny login lub haslo</p>" ;
			header("Location: index.php");
			}
	}

die();
$polaczenie ->close();
 ?>
