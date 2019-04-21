    $(document).on('click','#addToFav',function(){
        var id_recipe = $('#addToFav').attr('data-recipe_id');
        var id_user = $('#addToFav').attr('data-user_id');
        var actionType = $('#addToFav').attr('data-actionType');
        $.ajax({
            type: "POST",
            cache: false,
            url: 'php_updateFavourite.php',
            data: {'id_recipe':id_recipe , 'id_user': id_user, 'actionType': actionType},
            success: function(data) {
                $('#addToFav').html('Usuń z ulubionych');
                $('#addToFav').attr('data-actiontype','remove');
                $('#removeFromFav').unbind();
                $('#addToFav').attr('id', 'removeFromFav');
            }
        });
    });

    $(document).on('click','#removeFromFav',function(){
        var id_recipe = $('#removeFromFav').attr('data-recipe_id');
        var id_user = $('#removeFromFav').attr('data-user_id');
        var actionType = $('#removeFromFav').attr('data-actionType');
        $.ajax({
            type: "POST",
            cache: false,
            url: 'php_updateFavourite.php',
            data: {'id_recipe':id_recipe , 'id_user': id_user, 'actionType': actionType},
            success: function(data) {
              $('#removeFromFav').html('Dodaj do ulubionych');
              $('#removeFromFav').attr('data-actiontype','add');
              $('#removeFromFav').unbind();
              $('#removeFromFav').attr('id', 'addToFav');
            }
        });
    });
