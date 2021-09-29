<?php
/**
 * This file is part of the plyr package.
 *
 * @author (c) Friends Of REDAXO
 * @author <friendsof@redaxo.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class rex_plyr
{

    /**
     * @param mixed $url
     *
     * @return [url]
     */

    public static function checkUrl($url)
    {
        if ($url) {
            if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            }
            if (file_exists(rex_path::media($url)) === true) {
                $url = rex_url::media($url);
                return $url;
            }
            return $url;
        }
    }

    /**
     * @param mixed $url
     *
     * @return [boolean]
     */
    public static function checkYoutube($url)
    {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url)) {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $urL
     *
     * @return [youtube_id]
     */
    public static function getYoutubeId($urL)
    {
        $youtubeID = "";
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $urL, $match)) {
            $youtubeID = $match[1];
        }
        return $youtubeID;
    }

    /**
     * @param mixed $url
     *
     * @return [boolean]
     */
    public static function checkMedia($url)
    {
        $media = rex_media::get($url);
        $checkPath = pathinfo($url);
        if ($media) {
            if (strtolower($checkPath['extension']) == "mp4") {
                return true;
            }
            if (strtolower($checkPath['extension']) == "mov") {
                return true;
            }
	    if (strtolower($checkPath['extension']) == "m4v") {
                return true;
            }
        }
        return false;
    }
    
    /**
     * @param mixed $url
     *
     * @return [boolean]
     */
    public static function checkVideo($url)
    {
        if (rex_plyr::checkYoutube($url) || rex_plyr::checkVimeo($url) || rex_plyr::checkMedia($url) || rex_plyr::checkExternalMp4($url)) {
            return true;
        }
        return false;
    }
    
    /**
     * @param mixed $url
     *
     * @return [bolean]
     */
    public static function checkAudio($url)
    {
        $audio = rex_media::get($url);
        $checkPath = pathinfo($url);
        if ($audio) {
            if (strtolower($checkPath['extension']) == "mp3") {
                return true;
            }
        }
        return false;
    }

    /**
     * @param mixed $url
     *
     * @return [boolean]
     */
    public static function checkVimeo($url)
    {
        if (preg_match('~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $url)) {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $url
     *
     * @return [VimeoID]
     */
    public static function getVimeoId($url)
    {
        $vimeoID = "";
        if (preg_match('~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $url, $match)) {
            $vimeoID = $match[1];
        }
        return $vimeoID;
    }
    
    /**
     * checkExternalMp4
     *
     * @param  mixed $url
     * @return boolean
     */
    public static function checkExternalMp4($url)
    {

      if (filter_var($url, FILTER_VALIDATE_URL) == true) {
           
	if ($checkurl = get_headers($url, 1)) {
			if ($checkurl['Content-Type'] == 'video/mp4') {
                            eturn true; }
       }
        return false;
    }
    	

    /**
     * @param mixed $url
     * @param null $controls
     * @param null $poster
     *
     * @return [player output html]
     */
    public static function outputMedia($url, $controls = null, $poster = null, $consent = null)
    {
        $player = new rex_plyr();
        $link = $player->checkUrl($url);
        $consent_suffix = $consent_content = '';
        $out = '';

        if($consent) {
            $consent_suffix = '_consent';
            $consent_content = $consent;
        }
        if ($controls) {
            $control_attr = explode(",", $controls);
            $player_conf = json_encode($control_attr);
            $controls = ' data-plyr-config=\'{"controls":' . $player_conf . '}\'';
            $autoplay = ($control_attr && in_array('autoplay', $control_attr)) ? ' autoplay muted' : '';
            $loop = ($control_attr && in_array('loop', $control_attr)) ? ' loop' : '';
            $control_nojs = '';
            if ($autoplay || $loop) {
            	if ($autoplay && $loop) {
            		$control_nojs = (count($control_attr) > 2) ? ' controls' : '';
            	} elseif (count($control_attr) > 1) {
            		$control_nojs = ' controls';
            	}
            }
        }

        if ($player->checkYoutube($link) == true) {
            $out = '<div class="rex-plyr'.$consent_suffix.'" data-plyr-provider="youtube" data-plyr-embed-id="' . $player->getYoutubeId($link) . '"' . $controls . '>'.$consent_content.'</div>';
        }
        if ($player->checkVimeo($link) == true) {
            $out = '<div class="rex-plyr'.$consent_suffix.'" data-plyr-provider="vimeo" data-plyr-embed-id="' . $player->getVimeoId($link) . '"' . $controls . '>'.$consent_content.'</div>';
        }
        if ($player->checkMedia($url) !== false ||  $player->checkExternalMp4($url) === true) {
            if ($poster) {
                $poster = ' data-poster="' . $poster . '"';
            }
            $out = '
                        <video controls class="rex-plyr"' . $controls . $autoplay . $loop . $control_nojs .' playsinline volume=1' . $poster . '>
                            <source src="' . $link . '" type="video/mp4">
                        </video>
                    ';
        }    
	  
        if ($player->checkAudio($url) !== false) {
            $out = '
                        <audio controls class="rex-plyr"' . $controls . $autoplay . $loop . $control_nojs . '>
                            <source src="' . $link . '" type="audio/mp3">
                        </audio>
                    ';
        }

        return $out;
    }
    
    /**
     * @param mixed[] $media_filenames Array with video/mp4 audio/mp3 file names from media pool
     * @param null $controls
     *
     * @return [player output html]
     */
    public static function outputMediaPlaylist($media_filenames, $controls = null)
    {   $plyr = rex_addon::get('plyr');
        $svg_url = $plyr->getAssetsUrl("vendor/plyr/dist/plyr.svg");
        $blank_mp4 = $plyr->getAssetsUrl("vendor/plyr/dist/blank.mp4");
        $plyr_id = rand(); 
        $out = '<div class="plyr-container">';
        $out .= '<div id="player-'. $plyr_id .'">';
        $plyr_media = rex_plyr::outputMedia($media_filenames[0], $controls);
         $out .= str_replace('class="rex-plyr"', 'class="rex-plyr" id="plyr-'. $plyr_id .'"', 
        	str_replace("data-plyr-config='{", 'data-plyr-config=\'{"plyrId":"'. $plyr_id .'",', $plyr_media)
        );
        $out .= '</div>';
        $out .= '</div>';
        $out .= '<script>';
        $out .= '$(document).ready(function () {';
	    $out .= 'loadPlaylist(Plyr.setup("#plyr-'. $plyr_id .'", {';
		$out .= 'youtube: { ';
		$out .= 'noCookie: true ';
		$out .= '},';
		$out .= 'iconUrl: "'.$svg_url.'",';
		$out .= 'blankVideo: "'.$blank_mp4.'"';
        $out .= '}),';
		$out .= $plyr_id .',';
		$out .= '[';
		$first_element = true;
		foreach ($media_filenames as $media_filename) {
			$media = rex_media::get($media_filename);
			if ($media instanceof rex_media) {
				if ($first_element) {
					$first_element = false;
				} else {
					$out .= ',';
				}

				$out .= '{' . PHP_EOL;
				$out .= 'type: "video/mp4",' . PHP_EOL;
				$out .= 'title: "' . $media->getTitle() . '",' . PHP_EOL;
				$out .= 'src: "' . $media->getUrl() . '",' . PHP_EOL;
				$out .= '}' . PHP_EOL;
			}
		}
		$out .= ']';
	    $out .= ');';
        $out .= '});';
        $out .= '</script>';
        return $out;
    }
}
