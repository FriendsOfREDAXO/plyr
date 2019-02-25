$(document).on('rex:ready',function() {
	var hideControls = true;
	var autoplay = false;
	var volume = 5;
	var clickToPlay = true;
	
	if($('.rex_video').hasClass('Ausblenden')) {
		hideControls = true;
	}
	if($('.rex_video').hasClass('Anzeigen')) {
		hideControls = false;
	}
	if($('.rex_video').hasClass('Ja')) {
		autoplay = true;
	}
	if($('.rex_video').hasClass('Nein')) {
		autoplay = false;
	}
	if($('.rex_video').hasClass('Aktivieren')) {
		clickToPlay = true;
	}
	if($('.rex_video').hasClass('Deaktivieren')) {
		clickToPlay = false;
	}
	const player = Plyr.setup('.rex_video',{
 		 	hideControls		: hideControls,
 			autoplay			: autoplay,
 			volume				: volume,
 			clickToPlay			: clickToPlay,
 			disableContextMenu  : true
 	});


 	
});

