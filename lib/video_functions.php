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

}
?>
