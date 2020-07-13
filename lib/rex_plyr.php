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

    public static function checkYoutube($url)
    {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url)) {
            return true;
        }
        return false;
    }

    public static function getYoutubeId($urL)
    {
        $youtubeID = "";
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $urL, $match)) {
            $youtubeID = $match[1];
        }
        return $youtubeID;
    }

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

    public static function checkVimeo($url)
    {
        if (preg_match('~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $url)) {
            return true;
        }
        return false;
    }

    public static function getVimeoId($url)
    {
        $vimeoID = "";
        if (preg_match('~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $url, $match)) {
            $vimeoID = $match[1];
        }
        return $vimeoID;
    }

    public static function checkExternalMp4($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === TRUE) 
        {    
            $checkSource = get_headers($url, 1);
            if (isset($checkSource['Content-Type']) && $checkSource['Content-Type'] === 'video/mp4') {
            return true;
            }
        }
        return false;
    }
    
        public static function checkVideo($url)
    {
        if (rex_plyr::checkYoutube($url) || rex_plyr::checkVimeo($url) || rex_plyr::checkMedia($url) || checkExternalMp4($url)) {
            return true;
        }
        return false;
    }
    

    public static function outputMedia($url, $controls = NULL, $poster = NULL)
    {

        $player = new rex_plyr();
        $link = $player->checkUrl($url);

        if ($controls) {
            $player_conf = json_encode(explode(",", $controls));
            $controls = ' data-plyr-config=\'{"controls":' . $player_conf . '}\'';
        }

        if ($player->checkYoutube($link) == true) {
            $out = '<div class="rex-plyr" data-plyr-provider="youtube" data-plyr-embed-id="' . $player->getYoutubeId($link) . '"' . $controls . '></div>';
        }
        if ($player->checkVimeo($link) == true) {
            $out = '<div class="rex-plyr" data-plyr-provider="vimeo" data-plyr-embed-id="' . $player->getVimeoId($link) . '"' . $controls . '></div>';
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
}


