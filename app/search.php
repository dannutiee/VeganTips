<?php

session_start();
require ("db_connection.php");
$db = new mysqli( $_DB_SERVER_ , $_DB_USER_, $_DB_PASSWD_, $_DB_NAME_);

$input = $_POST['search'];
//print_r($input);

$query="SELECT * FROM recipes
        WHERE TITLE LIKE '%$input%' OR
        ABOUT LIKE '%$input%' OR
        RECIPE LIKE '%$input%' ORDER BY ID_RECIPE DESC";

$results = $db->query($query);

?>

<?php include("header.php"); ?>

<?php include('breadcrumbs.php'); ?>

		<section class="container categoryNavigation">
			<h3>Wyniki wyszukiwania: '<?php echo $input;?>'</h3>
      <div class="resultsCount">
        <span>Znaleziono: 2 wyników</span>
      </div>
		</section>
		<section class="container">
      <?php
      $licznik = 0;
      while ($search=mysqli_fetch_array($results,MYSQLI_ASSOC)) {

        //print_r ($search);
        if ($licznik == 0 || $licznik %3 == 0) {
          echo '<div class="row cards">' ;
        }
        $licznik++;

        $sqlImageQuery = "SELECT PHOTO_PATH FROM photos WHERE RECIPE_ID ='$search[ID_RECIPE]'";
        $imagePath = $db->query($sqlImageQuery);
        $imagePath = mysqli_fetch_array($imagePath,MYSQLI_ASSOC);

              echo '
                <div class="col-sm-12 col-md-4">
                  <a href=" fullrecipe.php?title='.$search["TITLE"].'">
                    <div class="card">
                      <div class="card-img-top" style="background-image: url('.$imagePath["PHOTO_PATH"].')">
                          <div class="card__awarded">
                            ';
                              if( $search["KIDS"] == 1)
                              {
                                echo '<span class="card__awarded__icon kids_icon_svg"></span>';
                              }
                              if( $search["GLUTEN_FREE"] == 1)
                              {
                                echo	'<span class="card__awarded__icon glutenfree_icon_svg"></span>';
                              }
                  echo	'</div>
                          <div class="cardOverlay">
                              <div class="cardOverlay__iconBox">
                                <div class="cardOverlay__icon">
                                  <span class="cardOverlay__icon-svg time"></span>
                                  <div class="cardOverlay__label">
                                    <span>'.$search["CATEGORY"].'</span>
                                  </div>
                                </div>

                                <div class="cardOverlay__icon">
                                  <span class="cardOverlay__icon-svg clock"></span>
                                  <div class="cardOverlay__label">
                                    <span>'.$search["PREPARE_TIME"].'</span>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                      <div class="card__body">
                        <h4 class="card__title">
                          '.$search["TITLE"].'
                        </h4>
                        <p class="card-text overflow hide-on-mobile">
                          '.mb_strimwidth($search["ABOUT"], 0, 200, "..."). '
                        </p>
                        <p class="card-text date">02/02/2018</p>
                      </div>
                    </div>
                  </a>
                </div>
              ';

        if ($licznik==0 || $licznik % 3 == 0) {
          echo '</div> <!--end-->'  ;   // end of section
        }
      }
      ?>
    </section>
