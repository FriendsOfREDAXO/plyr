<?php
class rex_video {

//Variablen


  function getVideoType($url) {
  if ($url) {
    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
    }
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