<?php
	session_start();
	$_SESSION['page'] = 'useraccount';
	//var_dump($_SESSION);

	include ("db_connection.php");

?>

<?php include("header.php"); ?>
<?php include('breadcrumbs.php'); ?>
<?php
	$db = new mysqli( $_DB_SERVER_ , $_DB_USER_, $_DB_PASSWD_, $_DB_NAME_);
	$userID = $_SESSION['userID'];
	$sql="SELECT * FROM USERS WHERE ID = '$userID' ";
	$results = $db->query($sql);
	while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)){
		//var_dump($row);

echo'
<section class="container border"></section>
<section class="container userAccount">';

echo'
	<div class="col-md-12 col-sm-12 userProfile row noPadding">
		<div class="userProfile__introduce col-md-12 col-sm-12 col-xs-12">
		<div class="userProfile__details col-md-4 col-sm-4 col-xs-12">
			<div class="userProfile__details userProfile__avatar" style="background-image: url('.$row['AVATAR'].')">
			</div>
			<h3 class="mainLabel">'.$row['LOGIN'].'</h3>
			<div class="userProfile__score">
				<!-- <div class="userProfile__score__single">
					<span><3</span>
					<span>20 ulubionych przepis</span>
				</div>-->
			</div>
		</div>
			<div class="userProfile__settings col-md-8 col-sm-8 col-xs-12">
				<form class="updateUserAccount__form update" action="php_zarejestruj.php" enctype="multipart/form-data" method="post">
					<h3 class="mainLabel">E-mail</h3>
					<input type="text" name="email" id="email" value='.$row['EMAIL'].'>';
						if(isset($_SESSION['e_email'])){
							echo '<div class="error">'.$_SESSION['e_email'].'</div>';
							unset($_SESSION['e_email']);
						}
				echo'
					<h3 class="mainLabel">Login</h3>
					<input type="text" name="login" id="login" value='.$row['LOGIN'].' readonly>';

						if(isset($_SESSION['e_login'])){
							echo '<div class="error">'.$_SESSION['e_login'].'</div>';
							unset($_SESSION['e_login']);
						}
				  echo'
					<h3 class="mainLabel">Hasło</h3>
					<input type="password" name="password" id="password" value='.$row['PASSWORD'].'>';

						if(isset($_SESSION['e_password'])){
							echo '<div class="error">'.$_SESSION['e_password'].'</div>';
							unset($_SESSION['e_password']);
						}
					echo'
					<h3 class="mainLabel">Powtórz hasło</h3>
					<input type="password" name="password_2" id="password_2" value='.$row['PASSWORD'].'>
					<h3 class="mainLabel">Ustaw zdjęcie profilowe</h3>
					<input  id="inputImage" type="file" name="image" >
					</br>

					<input type="submit" value="Zapisz zmiany" class="submit addRecipeBtn" />
				</form>
			</div>

		</div>
	</div>

	</section>';
}
?>

</div>
<?php include("footer.php"); ?>
</boody>
</html>
