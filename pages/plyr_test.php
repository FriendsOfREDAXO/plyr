<?php

//Variablen
$autoplayStandard = rex_config::get('video', 'autoplay_plyr');
$hideControls = rex_config::get('video', 'controls_plyr');
$clickToPlay = rex_config::get('video', 'click_plyr');
//YOUTUBE
	echo '<div class="rex_video '.$autoplayStandard.' '.$hideControls.' '.$clickToPlay.'" data-type="youtube"  data-video-id="YH3c1QZzRK4"></div></br>';
	echo '<div style="text-align: center;"><a href="https://www.youtube.com/watch?v=YH3c1QZzRK4"><i class="fa fa-youtube" aria-hidden="true"></i>Video-Credits</a></div>';
	echo '<i class="fa fa-youtube" aria-hidden="false"></i>';
?>