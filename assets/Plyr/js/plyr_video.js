$(document).ready(function() {
	var hideControls = true;
	var autoplay = false;
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
	var player = plyr.setup({
 		 	hideControls		: hideControls,
 			autoplay			: autoplay,
 			clickToPlay			: clickToPlay,
 			disableContextMenu  : true
 	});


 	
});

