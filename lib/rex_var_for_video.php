<?php class rex_var_for_video extends rex_var 
{
   protected function getOutput() 
   {
	$id = $this->getArg('id', 0, true);
        if (!in_array($this->getContext(), ['module', 'action']) || !is_numeric($id) || $id < 1 || $id > 20) {
            return false;
        }
    $value = $this->getContextData()->getValue('value' . $id);
        
		//Variablen
		$localAutoplay = $out = "";
		$url = $value;
		// GET INPUT LINK AND CHECK IS IT URL/MEDIA
		$player = new rex_video();
		$link = $player->getVideoType($url);
		// GET STANDARD CONFIG VARIABLES
		if(rex_config::get('video', 'player') == 'Plyr') {
			$autoplayStandard = rex_config::get('video', 'autoplay_plyr');
			$hideControls = rex_config::get('video', 'controls_plyr');
			$clickToPlay = rex_config::get('video', 'click_plyr');
			//$autoplay_audio = rex_config::get('video', 'autoplay_audio');
			$loop_audio = rex_config::get('video', 'loop_audio');
			
			if($player->checkYoutube($link) == true) {
				$out = '<div class="rex_video '.$autoplayStandard.' '.$hideControls.' '.$clickToPlay.'" data-type="youtube"  data-video-id="'.$player->getYoutubeId($link).'"></div></br>';
			}
			if($player->checkVimeo($link) == true) {
				$out =  '<div class="rex_video '.$hideControls.' '.$autoplayStandard.' '.$clickToPlay.'" data-type="vimeo" data-video-id="'.$player->getVimeoId($link).'"></div></br>';
			}
			if($player->checkMedia($url) !== false) {
				if($autoplayStandard == 'Ja') {
					$localAutoplay = "autoplay";
				}
				$out =  '
						<video '.$localAutoplay.' volume=1>
							<source src="'.$link.'" type="video/mp4">
						</video>
					';
				
			}
			if($player->checkAudio($url) !== false) {
				$out =   '
						<audio '.$loop_audio.'>
							<source src="'.$link.'" type="audio/mp3">
						</audio>
					';
			}
		}
		if(rex_config::get('video', 'player') == 'Afterglow') {
			$autoplay = rex_config::get('video', 'autoplay_afterglow');
			$sounds = rex_config::get('video', 'sound_afterglow');
			$theme = rex_config::get('video', 'theme_afterglow');
			
			// YOUTUBE mit LIGHTBOX-Feature   
			if($player->checkYoutube($link) == true) {
			    echo '
			        <video  autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" class="afterglow" id="video1" width="1920" height="1080"  data-youtube-id="'.$player->getYoutubeId($link).'" data-autoresize="fit"></video>
			        ';
			}
			
			if($player->checkVimeo($link) == true) {
				echo '
					 <video class="afterglow" id="myvideo" width="960" height="540" data-vimeo-id="'.$player->getVimeoId($link).'"></video>
					';
			}
			// Lokales MP4 Video als Standard-Player
			if($player->checkMedia($url) !== false) {
			    echo '
			        <video autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" class="afterglow" id="myvideo" width="1080" height="720">
			            <source type="video/mp4" src="'.$link.'" />
			        </video>
			        ';
			}
		}
	// Reine Textausgaben müssen mit 'self::quote()' als String maskiert werden.
	return self::quote($out);
   }
}
