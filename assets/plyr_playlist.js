/**
 * Create HTML playlist below video player 
 * @param Plyr[] players
 * @param int player_id 
 * @param string myPlaylist JSON playlist
 */
function loadPlaylist(players, player_id, myPlaylist) {
	$('<div class="plyr-playlist-wrapper" id="wrapper-' + player_id + '"><ul class="plyr-playlist" id="playlist-' + player_id + '"></ul></div>').insertAfter('#player-' + player_id);

	var playingclass = "";
	var items = [];
	$.each(myPlaylist, function (id, val) {
		if (0 === id) {
			playingclass = "pls-playing";
		}
		else {
			playingclass = "";
		}

		items.push(
				'<li class="' + playingclass + '"><a href="#" data-type="' + val.type + '" data-video-id="' + val.src + '">' +
				(val.poster ? '<img class="plyr-miniposter" src="' + val.poster + '"> ' : '') +
				val.title + (val.author ? " - " + val.author : "") + "</a></li> ");

	});
	$('#playlist-' + player_id).html(items.join(""));

	setTimeout(function () {}, 600);

	$(document).on("click", "ul.plyr-playlist#playlist-"+ player_id +" li a", function (event) {
		event.preventDefault();

		$("ul.plyr-playlist#playlist-"+ player_id +" li.pls-playing").removeClass("pls-playing");
		$(this)
				.parent()
				.addClass("pls-playing");

		var video_id = $(this).data("video-id");
		// var video_type = $(this).data("type");
		// var video_title = $(this).text();
		
		var playlistID = $(this).parent().parent().attr('id');
		players.forEach(function (instance) {
			if(('playlist-' + instance.config.plyrId) === playlistID) {
				instance.media.setAttribute('src', video_id);
				instance.play();
			}
		});

		$('#playlist-' + player_id).scrollTo(".pls-playing", 300);
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
