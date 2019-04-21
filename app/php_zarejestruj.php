<?php
session_start();
require ("db_connection.php");

error_reporting(E_ALL); // poziom raportowania, http://pl.php.net/manual/pl/function.error-reporting.php
ini_set('display_errors', 1);


if(isset($_POST['email'])){

	//udana walidacja
	$wszystko_OK = true ;

	//sprawdzenie loginu
	$login = $_POST['login'];

	// sprawdzenie poprawnosci loginu
	if ( (strlen($login)<3) || (strlen($login)>20) ){
		$wszystko_OK = false;
		$_SESSION['e_login'] = 'Login musi posiadac od 3 do 20 znakow !';
		if($_SESSION['zalogowany'] == true){
			header("Location: user_account.php");
		}else{
			header("Location: registration.php");
		}
	}

	if (ctype_alnum($login) == false){
		$wszystko_OK = false;
		$_SESSION['e_login'] = 'Login nie moze zawierac cyfr i polskich znaków';
		if($_SESSION['zalogowany'] == true){
			header("Location: user_account.php");
		}else{
			header("Location: registration.php");
		}
	}

	// email
	$email = $_POST['email'];

	// sprawdzenie poprawnosci emaila
	$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

	if( (filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email) ){
		$wszystko_OK == false;
		$_SESSION['e_email'] = 'Niepoprawny adres e-mail!';
		if($_SESSION['zalogowany'] == true){
			header("Location: user_account.php");
		}else{
			header("Location: registration.php");
		}

	}

	//sprawdzanie haslła
	$password = $_POST['password'];
	$password_2 = $_POST['password_2'];

	if ( (strlen($password) <6 ) ||  (strlen($password) >15) ){
		$wszystko_OK == false;
		$_SESSION['e_password'] = 'Hasło musi posiadać od 6 do 15 znaków';
		if($_SESSION['zalogowany'] == true){
			header("Location: user_account.php");
		}else{
			header("Location: registration.php");
		}
	}

	if ($password != $password_2){
		$wszystko_OK == false;
		$_SESSION['e_password'] = 'Hasło nie są identyczne!' ;
		if($_SESSION['zalogowany'] == true){
			header("Location: user_account.php");
		}else{
			header("Location: registration.php");
		}
	}

	// akceptacja regulaminu
	if($_SESSION['zalogowany'] != true){
		if( !isset($_POST['regulamin']) ){
			$wszystko_OK == false;
			$_SESSION['e_regulamin'] = 'Wymagana jest akceptacja regulaminu' ;
			if($_SESSION['zalogowany'] == true){
				header("Location: user_account.php");
			}else{
				header("Location: registration.php");
			}
		}
	}

	if($wszystko_OK == true){
		 //rejestrjemy -wszytsko jest OK
		  $polaczenie = new mysqli( $_DB_SERVER_ , $_DB_USER_, $_DB_PASSWD_, $_DB_NAME_);   //nawiazuje poleczenie z moja baza
		  $login=$_POST['login'];
		  $haslo=$_POST['password'];
		  $email=$_POST['email'];
			$userID = $_SESSION['userID'];

		//	add to table IMAGES
			if(isset($_FILES['image'])){
			 $imagename=$_FILES["image"]["name"];
			 $target_dir = "images/avatar/";
			 $target_file = $target_dir . basename($_FILES["image"]["name"]);
			 // Upload file
			 move_uploaded_file($_FILES['image']['tmp_name'],$target_dir.$imagename);

			}


			if($_SESSION['zalogowany'] != true){
		  	$sql="INSERT INTO users (ID, LOGIN, PASSWORD,EMAIL) VALUES (default,'$login','$haslo','$email')";
			}else{
				$sql="UPDATE users
				             SET  PASSWORD ='$haslo' , EMAIL = '$email',
										 AVATAR = '$target_file'
				             WHERE ID = '$userID' ";
			}

			var_dump($sql);
			// die();
		  // $polaczenie->exec($sql);
		  // $stmt = $polaczenie->prepare($sql);
		  // $stmt->execute();

		  $polaczenie->query($sql);

		  mysqli_close($polaczenie);//zamykanie połaczenia z baza
		  $_SESSION['success'] ="Dziękujemy za rejestrację. Możesz się zalogować na swoje konto";


			if($_SESSION['zalogowany'] == true){
				header("Location: user_account.php");
			}else{
				 header('Location: index.php');
			}
	}
}
?>
