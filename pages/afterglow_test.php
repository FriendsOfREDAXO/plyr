<?php

//Variablen
$autoplay = rex_config::get('video', 'autoplay_afterglow');
$sounds = rex_config::get('video', 'sound_afterglow');
$theme = rex_config::get('video', 'theme_afterglow');
// YOUTUBE
	echo '<video autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" id="video1" class="afterglow" width="1920" height="1080" data-youtube-id="TT1aHnfujcs" data-autoresize="fit"></video></br>';
		echo '<div style="text-align: center;"><a href="https://www.youtube.com/watch?v=TT1aHnfujcs"><i class="fa fa-youtube" aria-hidden="true"></i>Video-Credits</a></div>';
?>
