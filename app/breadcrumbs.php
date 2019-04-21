<?php

$page = $_SESSION['page'];
// var_dump($_SESSION);
// var_dump($page);
// die();
switch ($page) {
    case 'main':
        echo '
        <div class="breadcrumbs">
        <div class="container">';
            if(isset($_GET['category']))
            {
                $currentCategory = $_GET['category'];
                echo '
                <ul class="breadcrumbs__list list-unstyled col-md-6 col-sm-6">
                    <a href="index.php"><li class="home crumb"></li></a>
                    <li class="category crumb">
                        <a href="main.php?category='.$currentCategory.'">
                              '.$currentCategory.'
                        </a>
                    </li>
                </ul>
                ';
            }


            if(isset($_GET['title']))
            {
                echo '
                <ul class="breadcrumbs__list list-unstyled col-md-6 col-sm-6">
                    <a href="index.php"><li class="home crumb"></li></a>
                    <li class="category crumb">
                        <a href="#">';
                              if($_GET['title'] == 'my_recipes')
                              {
                                 echo 'Moje przepisy';
                              }
                              if($_GET['title'] == 'favourite_recipes')
                              {
                                echo 'Ulubione przepisy';
                              }

                echo '  </a>
                    </li>
                </ul>
                ';
            }
            if(!isset($_GET['title']) && !isset($_GET['category']))
            {
                echo '
                <ul class="breadcrumbs__list list-unstyled col-md-6 col-sm-6">
                    <a href="index.php"><li class="home crumb"></li></a>
                    <li class="category crumb">
                        <a href="#">
                          Przeglądaj przepisy
                        </a>
                    </li>
                </ul>
                ';
            }
        break;

    case 'fullrecipe':
        echo '
        <div class="breadcrumbs">
            <div class="container">
                <ul class="breadcrumbs__list list-unstyled col-md-6 col-sm-6">
                    <a href="index.php"><li class="home crumb"></li></a>
                    <li class="category crumb">
                        <a href="main.php?category='.$row['CATEGORY'].'">'
                             .$row['CATEGORY'].
                       '</a>
                    </li>
                    <li class="title crumb">
                        <a href="#">'
                            .$row['TITLE'].
                        '</a>
                    </li>
                </ul>
        ';
        break;
    case 'addrecipe':
        echo '
        <div class="breadcrumbs">
            <div class="container">
                <ul class="breadcrumbs__list list-unstyled col-md-6 col-sm-6">
                    <a href="index.php"><li class="home crumb"></li></a>
                    <li class="title crumb">
                        <a href="#">
                          Dodaj przepis
                        </a>
                    </li>
                </ul>
        ';
        break;
    case 'useraccount':
        echo '
        <div class="breadcrumbs">
            <div class="container">
                <ul class="breadcrumbs__list list-unstyled col-md-6 col-sm-6">
                    <a href="index.php"><li class="home crumb"></li></a>
                    <li class="title crumb">
                        <a href="#">
                          Moje konto
                        </a>
                    </li>
                </ul>
        ';
        break;


} // end switch case
?>
      <div class="searchEngine col-md-6 col-sm-6">
        <form action="search.php" method="post">
          <input type="text" name="search" placeholder="Znajdź przepis"/>
          <input type="submit" value="Szukaj"/>
        </form>
      </div>
    </div>
  </div>
</div> <!--container end -->
