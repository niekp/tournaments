(function($){
    $(function() {
        $("[data-games] [data-game]").on("click", openGame);
    });
  
    function openGame(e) {
        $("[data-game-modal]").remove();

        var $match = $(e.currentTarget),
            gameUrl = $match.data("game");
        $.get(gameUrl, function(data) {
            $("body").append(data);
            $("[data-game-modal]").modal()
        })
    }
})(jQuery);