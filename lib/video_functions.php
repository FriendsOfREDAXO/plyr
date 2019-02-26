<?php
/**
 * This file is part of the video package.
 *
 * @author (c) Friends Of REDAXO
 * @author <friendsof@redaxo.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class rex_video {

	function getVideoType($url) {
		if ($url) {
			if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {	}
			if (file_exists(rex_path::media($url)) === true) {
    			$url = rex_url::media($url);
				return $url;
			} 
			return $url; 
		}
	}
	
	function checkYoutube($url) {
		if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url)) {
			return true;
		}
		return false;
	}
	
	function getYoutubeId($urL) {
		$youtubeID = "";
		if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $urL, $match)) {
			$youtubeID = $match[1];
		}
		return $youtubeID;
	}
	
	function checkMedia($url) {
		$media = rex_media::get($url);
		$checkPath = pathinfo($url);
		if($media) {
			if(strtolower($checkPath['extension']) == "mp4") {
				return true;
			}
		}
		return false;
	}
	
	function checkAudio($url) {
		$audio = rex_media::get($url);
		$checkPath = pathinfo($url);
		if($audio) {
			if(strtolower($checkPath['extension']) == "mp3") {
				return true;
			}
		}
		return false;
	}
	
// FÜR AFTERGLOW NACH UPDATE ODER PLYR  
	function checkVimeo($url) {
		if(preg_match('~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix',$url)) {
			return true;
		}
		return false;
	}
	
	function getVimeoId($url) {
		$vimeoID = "";
		if(preg_match('~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix',$url, $match)) {
			$vimeoID = $match[1];
		}
		return $vimeoID;	
	}
    
    
    public static function outputVideo($url)
        {
        
        //Variablen
		$localAutoplay = $out = "";
		$url = $url;
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
				$out = '<div class="rex_video '.$autoplayStandard.' '.$hideControls.' '.$clickToPlay.'" data-plyr-provider="youtube" data-plyr-embed-id="'.$player->getYoutubeId($link).'"></div></br>';
			}
			if($player->checkVimeo($link) == true) {
				$out =  '<div class="rex_video '.$hideControls.' '.$autoplayStandard.' '.$clickToPlay.'" data-plyr-provider="vimeo" data-plyr-embed-id"'.$player->getVimeoId($link).'"></div></br>';
			}
			if($player->checkMedia($url) !== false) {
				if($autoplayStandard == 'Ja') {
					$localAutoplay = "autoplay";
				}
				$out =  '
						<video class="rex_video '.$hideControls.' '.$autoplayStandard.' '.$clickToPlay.'" '.$localAutoplay.' playsinline volume=1>
							<source src="'.$link.'" type="video/mp4">
						</video>
					';

			}

			if($player->checkAudio($url) !== false) {
				$out =   '
						<audio class="rex_video" '.$loop_audio.'>
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
			    $out = '
			        <video  autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" class="afterglow" id="video1" width="1920" height="1080"  data-youtube-id="'.$player->getYoutubeId($link).'" data-autoresize="fit"></video>
			        ';
			}
			
			if($player->checkVimeo($link) == true) {
				$out = '
					 <video class="afterglow" id="myvideo" width="960" height="540" data-vimeo-id="'.$player->getVimeoId($link).'"></video>
					';
			}
			// Lokales MP4 Video als Standard-Player
			if($player->checkMedia($url) !== false) {
			   $out =  '
			        <video autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" class="afterglow" id="myvideo" width="1080" height="720">
			            <source type="video/mp4" src="'.$link.'" />
			        </video>
			        ';
			}
		}
        return $out; 
    }






}
?>

