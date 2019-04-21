<!DOCTYPE>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VeganTips</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
	  rel="stylesheet">
	  <link href="https://fonts.googleapis.com/css?family=Handlee|Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet">


  <link rel="stylesheet" href="../bower_components/bootstrap-css/css/bootstrap.min.css" >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="styles/main.css" >
  <link href="../bower_components/select2/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>
	<div id="container" class="nav__container">
		<div class="nav__bg col-md-4">
		</div>
		<div class="container">

		<?php
			if(!isset($_SESSION['zalogowany'])||($_SESSION['zalogowany']==false)){
				echo '
					<nav class="nav">
						<div class="nav__logo col-md-3">
						<a href="index.php"></a>
						</div>
						<div class="col-md-5">
							<ul class="nav__navi">
								<a href="main.php"><li class="option dark">Wszystkie przepisy</li></a>
							</ul>
						</div>
						<ul class="col-md-4 nav__navi nav__navi__corner ">
							<!-- <a href="#"><li class="option">Dodaj przepis</li></a> -->
							<a href="index.php"><li class="option">Zaloguj się</li></a>
							<a href="registration.php"><li class="option">Zarejestruj się</li></a>
						</ul>
					</nav>
				';
			}else{
				echo '

					<nav class="nav">
						<div class="nav__logo col-md-3">
						<a href="index.php"></a>
						</div>
						<div class="col-md-3">
							<ul class="nav__navi">
							<a href="addrecipe.php"><li class="option dark">Dodaj przepis</li></a>
							</ul>
						</div>
						<ul class="col-md-6 nav__navi nav__navi__corner">
							<a href="main.php"><li class="option">Przeglądaj przepisy</li></a>
							<a href="main.php?title=my_recipes"><li class="option">Moje przepisy</li></a>
							<a href="main.php?title=favourite_recipes"><li class="option favourite"></li></a>
							<a href="user_account.php"><li class="option myAccount"></li></a>
							<a href="php_wyloguj.php"><li class="option logOut"></li></a>
						</ul>
					</nav>
				';
			}
		?>
		</div>
	</div>
	<!-- <div class="container"> -->
