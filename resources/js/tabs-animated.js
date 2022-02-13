let TabsAnimated = {
    'init': function() {
        $(".tabs-animated a").click(function() {
        
          var position = $(this).parent().position();
          var width = $(this).parent().width();
        
        
          $(this).closest('.classic-tabs').find(".floor").css({
            "left": position.left,
            "width": width
          });
        
        });
      
        var actWidth = $(".tabs-animated").find(".active").parent("li").width();
        var actPosition = $(".tabs-animated .active").position();
      
        $(".floor").css({
          "left": actPosition.left,
          "width": actWidth
        });
    }
}

export default TabsAnimated;