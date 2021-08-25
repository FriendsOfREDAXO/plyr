$(document).on('rex:ready',function() {

 const players = Plyr.setup('.rex-plyr',{
	 youtube: { 
		 noCookie: true
	 },
	 iconUrl: '../assets/addons/plyr/vendor/plyr/dist/plyr.svg',
    blankVideo: '../assets/addons/plyr/vendor/plyr/dist/blank.mp4'
 });
    // Stop other videos    
    players.forEach(function (player) {
        player.on('play', function () {
            var others = players.filter(other => other != player)
            others.forEach(function (other) {
                other.pause();
            })
        });
    });
});
