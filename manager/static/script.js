(function($){
  // Dialog
  (function(){
    var dialog = $(".log-dialog");

    $(".view-log").on("click", function(){
      dialog.stop().fadeIn(200).find(".inner").load($(this).attr("href"));
      return false;
    });

    dialog.on("click", function(e){
      if($(e.target).is(".log-dialog, .close")) dialog.stop().fadeOut(400);
    });

    $(document).on("keyup", function(e){
      if(e.keyCode === 27) dialog.trigger("click");
    });
  })();

  // Quick Filter
  (function(){
    var input = $("#quick-filter");
    var rows = $(".sites tr");
    var timeout_id = null;

    input.keyup(function(){
      if(timeout_id) clearTimeout(timeout_id);

      timeout_id = setTimeout(function(){
        timeout_id = null;
        try{
          var word_re = new RegExp(input.val(), "i");
          rows.each(function(){
            var row = $(this);
            row.data("search-string").match(word_re) ? row.show() : row.hide();
          });
        }catch(e){
        }
      }, 200);
    });

    input.trigger("focus");
  })();
})(jQuery);
