function loadPlaylist(target, myPlaylist, id, listclass, limit) {
    var players = Plyr.setup(target);
    $("li.pls-playing").removeClass("pls-playing");
    $(".plyr-playlist-wrapper").remove();


    limit = limit - 1;


    if (myPlaylist) {

        PlyrPlaylist(".plyr-playlist", myPlaylist, limit, id, listclass);
        //return
    }

    function PlyrPlaylist(target, myPlaylist, limit, id, listclass) {
        $('<div class="plyr-playlist-wrapper  ' + listclass + '"><ul class="plyr-playlist"></ul></div>').insertAfter(id);
      

        var startwith = 0; // Maybe a playlist option to start with choosen video

        var playingclass = "";
        var items = [];
        $.each(myPlaylist, function (id, val) {

            if (0 === id) playingclass = "pls-playing";
            else playingclass = "";


            items.push(
                '<li class="' + playingclass + '"><a href="#" data-plyr-provider="' + val.sources[0].type + '" data-plyr-embed-id="' + val.sources[0].src + '">' +
                val.title + "" + val.author + "</a></li> ");

            if (id == limit)
                return false;

        });
        $(target).html(items.join(""));
      
 
      
       players[0].on("ended", function (event) {
            var $next = $(".plyr-playlist .pls-playing")
                .next()
                .find("a")
                .trigger("click");
        });
		

      
    }

    $(document).on("click", "ul.plyr-playlist li a", function (event) {
        event.preventDefault();
        $("li.pls-playing").removeClass("pls-playing");
        $(this)
            .parent()
            .addClass("pls-playing");
        var video_id = $(this).data("plyr-embed-id");

        var video_type = $(this).data("plyr-provider");
        var video_title = $(this).text();
        players[0].source = {
            type: 'video',
            title: "video_title",
            sources: [{ provider: video_type, src: video_id, type: video_type }]
        };

        players[0].on("ready", function (event) {
            players[0].play();
        });


        $(".plyr-playlist").scrollTo(".pls-playing", 300);

    });

    players[0].on("ready", function (event) {
     
       
    });    
 
}


/****** GC ScrollTo **********/
jQuery.fn.scrollTo = function (elem, speed) {
    jQuery(this).animate(
        {
            scrollTop:
                jQuery(this).scrollTop() -
                jQuery(this).offset().top +
                jQuery(elem).offset().top
        },
        speed === undefined ? 1000 : speed
    );
    return this;
};
		


		
