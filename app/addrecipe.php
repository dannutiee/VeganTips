<?php

session_start();
$_SESSION['page'] = 'addrecipe';


?>

<?php include("header.php"); ?>
<?php include("breadcrumbs.php");?>
<section class="container">
<?php include("addRecipeForm.php");?>
</section>
<?php include("footer.php"); ?>
