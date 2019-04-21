$(document).ready(function(){

//addrecipe
  $('#select2-time').select2({
    minimumResultsForSearch: -1,
    placeholder: {
    id: 'time', // the value of the option
    text: 'Wybierz czas przygotowania'
    },
  });

  $('#select2-category').select2({
    minimumResultsForSearch: -1,
    placeholder: {
    id: 'category', // the value of the option
    text: 'Wybierz kategorię'
    },
  });

// modal editable

  var data_time = $('#select2-time-edit').attr('data-name');
  $('#select2-time-edit').select2({
    minimumResultsForSearch: -1,
    placeholder: {
    id: 'time-edit', // the value of the option
    text: data_time
    },
  });

  var data_category = $('#select2-category-edit').attr('data-name');
  $('#select2-category-edit').select2({
    minimumResultsForSearch: -1,
    placeholder: {
    id: 'category-edit', // the value of the option
    text: data_category
    },
  });
});
