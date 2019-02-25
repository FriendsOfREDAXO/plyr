<?php

//Variablen VIDEO
$autoplayStandard = rex_config::get('video', 'autoplay_plyr');
$hideControls = rex_config::get('video', 'controls_plyr');
$clickToPlay = rex_config::get('video', 'click_plyr');
//YOUTUBE
	echo '<h2>Plyr Video</h2>';
	echo '<div class="rex_video '.$autoplayStandard.' '.$hideControls.' '.$clickToPlay.'" data-plyr-provider="youtube" data-plyr-embed-id="TT1aHnfujcs"></div></br>';
	echo '<div style="text-align: center;"><a href="https://www.youtube.com/watch?v=TT1aHnfujcs"><i class="fa fa-youtube" aria-hidden="true"></i>Video-Credits</a></div>';
	
//Variablen AUDIO

//$autoplay_audio = rex_config::get('video', 'autoplay_audio');
$loop_audio = rex_config::get('video', 'loop_audio');
$link = rex_url::assets('addons/video/crowd.mp3');

	echo '<h2>Plyr Audio</h2>';
	echo '
			<section>
				<audio class="rex_video" '.$loop_audio.'>
					<source src="'.$link.'" type="audio/mp3">
				</audio>
			</section>
		';
	echo '<div style="text-align: center;"><a href="http://www.sample-videos.com/audio/mp3/crowd-cheering.mp3"><i class="fa fa-volume-up" aria-hidden="true"></i> Audio-Credits</a></div>';
?>



