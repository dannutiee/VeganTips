<?php

session_start();

if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true))
{
	header("Location: main.php");
	exit();
}
?>

<?php include("header.php"); ?>

		<header id="registrationWrapper">
			<div class="panel_log container">
				<form class="loginSection__form" action="php_zarejestruj.php" method="post">
					<h3>Rejestracja</h3>
					<label for="email">E-mail:</label>
					<input type="text" name="email" id="email">
					<?php
						if(isset($_SESSION['e_email'])){
							echo '<div class="error">'.$_SESSION['e_email'].'</div>';
							unset($_SESSION['e_email']);
						}
				  ?>
					<label for="login">Login:</label>
					<input type="text" name="login" id="login">
					<?php
						if(isset($_SESSION['e_login'])){
							echo '<div class="error">'.$_SESSION['e_login'].'</div>';
							unset($_SESSION['e_login']);
						}
				  ?>
					<label for="password:">Hasło:</label>
					<input type="password" name="password" id="password">
					<?php
						if(isset($_SESSION['e_password'])){
							echo '<div class="error">'.$_SESSION['e_password'].'</div>';
							unset($_SESSION['e_password']);
						}
				  ?>
					<label for="password:">Powtórz hasło:</label>
					<input type="password" name="password_2" id="password_2"></br>

					<label>
					<input type="checkbox" name="regulamin" id="regulamin"/>Akceptuję Regulamin
					</label>
					<?php
						if(isset($_SESSION['e_regulamin'])){
							echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
							unset($_SESSION['e_regulamin']);
						}
				  ?>
					</br>
					<input type="submit" value="Zarejestruj" class="submit" />
					<div class="bottom">
						<p>Posiadasz już konto ?</p>
						<a href="index.php"><p>Zaloguj się</p></a>
					</div>
				</form>
			</div>
		</header>
	</div>

<?php include("footer.php"); ?>
