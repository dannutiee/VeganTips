var oAddRecipe = {

	sel: {
		button_addComponent: 				'#addComponent'
		,componentsRowContainer: 		'#componentsRowContainer'
		,removeComponent:						'button.removeComponent'
		,specialCategoryBox: 				'.specialCategoryBox'
	}
	,data: {
		counter:  			0
	}

	,init: function(){
		oAddRecipe.allOnclickFunctions();
	}
	,allOnclickFunctions: function(){
		$(oAddRecipe.sel.button_addComponent).on('click', function(){
				oAddRecipe.data.counter ++;
				var newComponentRow = '<div class="componentRowContainer" data-index="'+oAddRecipe.data.counter+'">'
			 					 +'<input type="text" name="component[]" class="input" id="component" placeholder="Wpisz nazwę składniku" />'
			 					 +'<input type="text" name="amount[]" class="input" id="amount" placeholder="Wpisz ilość składniku" /><button data-index="'+oAddRecipe.data.counter+'" class="removeComponent" id="cos" type="button"></button>'
			 					 +' </div>';
			 	$(oAddRecipe.sel.componentsRowContainer).append(newComponentRow);
				console.log(newComponentRow);

		});
		$(oAddRecipe.sel.componentsRowContainer).on('click', '.removeComponent', function() {
			var data_index = $(this).attr('data-index');
			var componentToDelete = $('.componentRowContainer[data-index="'+data_index+'"]');
			$(componentToDelete).remove();
		});
	}

};

$(document).ready(function(){
	oAddRecipe.init();
});
