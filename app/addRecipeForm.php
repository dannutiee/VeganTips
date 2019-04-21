<form class="addRecipeForm" <?php
if ( $_SESSION['page'] == 'fullrecipe'){
  echo 'action="php_updateRecipe.php" ';
}else{
  echo 'action="php_dodajprzepis.php" ';
}
?>method="post" enctype='multipart/form-data' id="recipeform">
  <?php
  if ( $_SESSION['page'] == 'fullrecipe'){
    echo '
    <input type="text" name="idRecipe" value="'.$row['ID_RECIPE'].'" hidden/>
    <input type="text" name="existingCategory" value="'.$row['CATEGORY'].'" hidden/>
    <input type="text" name="existingTime" value="'.$row['PREPARE_TIME'].'" hidden/>
    <input type="text" name="existingPhoto" value="'.$photoPath['PHOTO_PATH'].'" hidden/>
    ';
  }?>
  <div class="col-md-12 col-xs-12">
    <h3 class="mainLabel">Informacje o przepisie</h3>
    <input
    <?php
    if ( $_SESSION['page'] == 'fullrecipe'){
      echo 'value="'.$row['TITLE'].'"';
    }else{
      echo 'placeholder="Nazwa dla przepisu"';
    }
    ?>
    type="text"
    name="title"
    id="title"/>
    <br />
  </div>
  <div class="col-md-6 col-xs-12">
    <br />
    <select class="select2" <?php
    if ( $_SESSION['page'] == 'fullrecipe'){
      echo 'id="select2-category-edit"';
    }else{
      echo 'id="select2-category"';
    }
    ?>
    data-name="<?php echo $row['CATEGORY'] ;?>" name="category" style="width: 100%">
      <option <?php  if( $_SESSION['page'] == 'fullrecipe') { echo 'value="category-edit"';}
      else{ echo 'value="category"';} ?>></option>
      <option value="sniadanie">Śniadanie</option>
      <option value="lunch">Lunch</option>
      <option value="obiad">Obiad</option>
      <option value="kolacja">Kolacja</option>
      <option value="deser">Deser</option>
    </select>
  </div>
  <div class="col-md-6 col-xs-12">
    <br />
    <select class="select2"  <?php
    if ( $_SESSION['page'] == 'fullrecipe'){
      echo 'id="select2-time-edit"';
    }else{
      echo 'id="select2-time"';
    }
    ?> data-name="<?php echo $row['PREPARE_TIME'] ;?>" name="time" style="width: 100%">
      <option <?php  if( $_SESSION['page'] == 'fullrecipe') { echo 'value="time-edit"';}
      else{ echo 'value="time"';} ?>></option>
      <option value="15 min">15 min</option>
      <option value="30 min">30 min</option>
      <option value="45 min">45 min</option>
      <option value="1 h">1 h</option>
      <option value="powyżej 1 h">powyżej 1 h</option>
    </select>
  </div>
  <div class="col-md-12 col-xs-12 noPadding specialCategoryBox">
    <br />
    <h3 class="mainLabel mainLabel__addpadding">Kategoria specjalna</h3>
    <div class="addRecipeForm__categoryButtons btn-group-toggle col-md-6 col-xs-12" data-toggle="buttons">
      <label
      <?php
      if( $_SESSION['page'] == 'fullrecipe'){
        if ($row['KIDS'] == '1'){
          echo 'class="btn btn-secondary catOption active" ';
        }else{
          echo 'class="btn btn-secondary catOption" ';
        }
      }else{
        echo 'class="btn btn-secondary catOption" ';
      }
      ?>
      id="kids">
        <input type="checkbox"  name="kids" value="1"  autocomplete="off"
        <?php
        if( $_SESSION['page'] == 'fullrecipe'){
          if ($row['KIDS'] == '1'){
            echo 'checked';
          }
        }
        ?>
        > Dla dzieci
      </label>
    </div>
    <div class="addRecipeForm__categoryButtons btn-group-toggle col-md-6 col-xs-12" data-toggle="buttons">
      <label
      <?php
      if( $_SESSION['page'] == 'fullrecipe'){
        if ($row['GLUTEN_FREE'] == '1'){
          echo 'class="btn btn-secondary catOption active" ';
        }else{
          echo 'class="btn btn-secondary catOption"';
        }
      }else{
        echo 'class="btn btn-secondary catOption"';
      }
      ?>
      id="glutenfree" >
        <input type="checkbox"  name="glutenfree" value="1" autocomplete="off"
        <?php
        if( $_SESSION['page'] == 'fullrecipe'){
          if ($row['GLUTEN_FREE'] == '1'){
            echo 'checked';
          }
        }
        ?>
        > Bez glutenu
      </label>
    </div>

  </div>
  <div class="col-md-12 col-xs-12">
   <br />
     <h3 class="mainLabel">Składniki</h3>
     <div id="componentsRowContainer">
     <?php
     if ( $_SESSION['page'] != 'fullrecipe')
     {
       echo '
         <div class="componentRowContainer" data-index="0">
           <input type="text" class="input" name="component[]" id="component" placeholder="Wpisz nazwę składniku" />
           <input type="text" class="input" name="amount[]" id="amount" placeholder="Wpisz ilość składniku" />
           <button class="removeComponent" type="button" data-index="0"></button>
         </div>
       ';
     }else{
       $i = 0;
       while ($rowComponentsToEdit=mysqli_fetch_array($getComponentsToEdit,MYSQLI_ASSOC)){
          echo '
          <div class="componentRowContainer" data-index="'.$i.'">
            <input type="text" class="input" name="component[]" id="component" value="'.$rowComponentsToEdit['COMPONENT'].'" />
            <input type="text" class="input" name="amount[]" id="amount" value="'.$rowComponentsToEdit['AMOUNT'].'" />
            <button class="removeComponent" type="button" data-index="'.$i.'"></button>
          </div>
          ';
          $i++;
       }
     }
     ?>
     </div>
     <br />
     <button class="button addComponentBtn" type="button" id="addComponent">Dodaj składnik</button>
  </div>
  <div class="col-md-12 col-xs-12">
   <br />
     <h3 class="mainLabel">Opis i przygotowanie</h3>
     <textarea rows="6" cols="70" name="about" id="about"
       <?php
       if ( $_SESSION['page'] != 'fullrecipe')
       {
         echo 'placeholder="Krótki opis dania"';
       }
      ?>
     ><?php
     if ( $_SESSION['page'] == 'fullrecipe')
     {
       echo $row['ABOUT'];
     }?></textarea>
  </div>
  <div class="col-md-12 col-xs-12">
     <br />
     <textarea rows="14" cols="70" name="recipe" id="recipe"
       <?php
       if ( $_SESSION['page'] != 'fullrecipe')
       {
         echo 'placeholder="Treść przepisu i informacje dotyczące przygotowania"';
       }
      ?>
     ><?php
     if ( $_SESSION['page'] == 'fullrecipe')
     {
       echo $row['RECIPE'];
     }?></textarea>
     <br />
  </div>
  <div class="col-md-12 col-xs-12">
      <h3 class="mainLabel">Zdjęcia</h3>
      <br />
      <?php
      if ( $_SESSION['page'] == 'fullrecipe')
      {
        echo '<span>Aktualne zdjecie:'.$photoPath['PHOTO_PATH'].'</span>';
      }?>
      <input  id="inputImage" type="file" name="image" >
  </div>
  <div class="col-md-12 col-xs-12">
      <br />
     <input type="submit"
     <?php
     if ( $_SESSION['page'] == 'fullrecipe')
     {
       echo 'value = "Zapisz zmiany"';
     }else{
       echo 'value = "Dodaj przepis!"';
     }
     ?> class="submit addRecipeBtn"/>
     <br />
  </div>
</form>
<br/>


<!-- </div> -->
