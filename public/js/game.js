(function($){
    $(function() {
        $("[data-games] [data-game]").on("click", openGame);
        $("[data-copy-url]").on('click', copyUrl)
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

    function copyUrl() {
        copyToClipboard(window.location.href);
    }

    const copyToClipboard = str => {
        const el = document.createElement('textarea');
        el.value = str;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
    };
    
})(jQuery);