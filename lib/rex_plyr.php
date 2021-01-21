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
        if (filter_var($url, FILTER_VALIDATE_URL) === true) {
            $checkSource = get_headers($url, 1);
            if (isset($checkSource['Content-Type']) && $checkSource['Content-Type'] === 'video/mp4') {
                return true;
            }
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
            $player_conf = json_encode(explode(",", $controls));
            $controls = ' data-plyr-config=\'{"controls":' . $player_conf . '}\'';
        }

        if ($player->checkYoutube($link) == true) {
            $out = '<div class="rex-plyr'.$consent_suffix.'" data-plyr-provider="youtube" data-plyr-embed-id="' . $player->getYoutubeId($link) . '"' . $controls . '>'.$consent_content.'</div>';
        }
        if ($player->checkVimeo($link) == true) {
            $out = '<div class="rex-plyr'.$consent_suffix.'" data-plyr-provider="vimeo" data-plyr-embed-id="' . $player->getVimeoId($link) . '"' . $controls . '>'.$consent_content.'</div>';
        }
        if ($player->checkMedia($url) !== false || $player->checkExternalMp4($url) === true) {
            if ($poster) {
                $poster = ' poster="' . $poster . '"';
            }

            $out = '
                        <video class="rex-plyr"' . $controls . ' playsinline volume=1' . $poster . '>
                            <source src="' . $link . '" type="video/mp4">
                        </video>
                    ';
        }

        if ($player->checkAudio($url) !== false) {
            $out = '
                        <audio class="rex-plyr"' . $controls . '>
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
    {
        $plyr_id = rand();
        $out = '<div class="plyr-container">';
        $out .= '<div id="player-'. $plyr_id .'">';
        $plyr_media = rex_plyr::outputMedia($media_filenames[0], $controls);
         $out .= str_replace('class="rex-plyr"', 'class="rex-plyr" id="plyr-'. $plyr_id .'"', 
        	str_replace("data-plyr-config='{", 'data-plyr-config=\'{"plyrId":"'. $plyr_id .'",', $plyr_media)
        );
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '<script>';
        $out .= '$(document).ready(function () {';
	    $out .= 'loadPlaylist(Plyr.setup("#plyr-'. $plyr_id .'", {';
		$out .= 'youtube: { ';
		$out .= 'noCookie: true ';
		$out .= '},';
		$out .= 'iconUrl: "assets/addons/plyr/vendor/plyr/dist/plyr.svg",';
		$out .= 'blankVideo: "assets/addons/plyr/vendor/plyr/dist/blank.mp4"';
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
