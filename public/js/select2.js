(function($) {
  'use strict';

  if ($(".js-example-basic-single").length) {
    $(".js-example-basic-single").select2();
  }
  if ($(".js-example-basic-single-tags").length) {
    $(".js-example-basic-single-tags").select2({
      tags: true
    });
  }
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2({
      tags: true
    });
  }
  if ($(".js-example-basic-multiple2").length) {
    $(".js-example-basic-multiple2").select2({
      tags: false
    });
  }

  if ($(".js-data-example-ajax").length) {
    $('.js-data-example-ajax').select2({
    ajax: {
      url: 'https://api.github.com/search/repositories',
      dataType: 'json'
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });
  }


})(jQuery);
