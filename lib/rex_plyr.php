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
     * @param string $url
     *
     * @return string
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
     * @param string $url
     *
     * @return boolean
     */
    public static function checkYoutube($url)
    {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function getYoutubeId($url)
    {
        $youtubeID = "";
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $youtubeID = $match[1];
        }
        return $youtubeID;
    }

    /**
     * @param string $url
     *
     * @return boolean
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
     * @param string $url
     *
     * @return boolean
     */
    public static function checkVideo($url)
    {
        if (rex_plyr::checkYoutube($url) || rex_plyr::checkVimeo($url) || rex_plyr::checkMedia($url) || rex_plyr::checkExternalMp4($url)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $url
     *
     * @return boolean
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
     * @param string $url
     *
     * @return boolean
     */
    public static function checkVimeo($url)
    {
        if (preg_match('~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/(progressive_redirect\/playback|external|videos?))?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $url)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function getVimeoId($url)
    {
        $vimeoID = "";
        if (preg_match('~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/(progressive_redirect\/playback|external|videos?))?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $url, $match)) {
            $vimeoID = $match[2];
        }
        return $vimeoID;
    }

    /**
     * checkExternalMp4
     *
     * @param  string $url
     * @return boolean
     */
    public static function checkExternalMp4($url)
    {

        if (filter_var($url, FILTER_VALIDATE_URL) == true) {

            if ($checkurl = get_headers($url, 1)) {
                if ($checkurl['Content-Type'] == 'video/mp4') {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * @param string $url
     * @param string $setup
     * @param string $poster
     *
     * @return string
     */
    public static function outputMedia($url, $setup = null, $poster = null, $consent = null)
    {
        $player = new rex_plyr();
        $link = $player->checkUrl($url);
        $consent_suffix = $consent_content = '';
        $out = $nopreload = '';

        if ($consent) {
            $consent_suffix = '_consent_';
            $consent_content = $consent;
        }
        if ($setup) {
            $control_attr = explode(",", $setup);
            if ($control_attr && in_array('nopreload', $control_attr)) {
                $nopreload = ' preload="none"';
            }
            $player_conf = json_encode($control_attr);
            $setup = ' data-plyr-config=\'{"controls":' . $player_conf . '}\'';
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
        } else {
            $setup = '';
            $autoplay = '';
            $loop = '';
            $control_nojs = '';
        }
        $provider = '';
        $embed_id = '';

        if ($player->checkYoutube($link) == true) {
            $provider = 'youtube';
            $embed_id = $player->getYoutubeId($link);
        }

        if ($player->checkVimeo($link) == true) {
            $provider = 'vimeo';
            $embed_id = $player->getVimeoId($link);
        }

        if ($provider != '') {
            $out = '<div class="rex-plyr' . $consent_suffix . $provider . '" data-plyr-provider="' . $provider . '" data-plyr-embed-id="' . $embed_id . '"' . $setup . '>' . $consent_content . '</div>';
        }

        if ($player->checkMedia($url) !== false ||  $player->checkExternalMp4($url) === true) {
            if ($poster) {
                $poster = ' data-poster="' . $poster . '"';
            } else {
                $poster = '';
            }
            $out = '
                        <video controls class="rex-plyr"' . $setup . $autoplay . $loop . $nopreload . $control_nojs . ' playsinline volume=1' . $poster . '>
                            <source src="' . $link . '" type="video/mp4">
                        </video>
                    ';
        }

        if ($player->checkAudio($url) !== false) {
            $out = '
                        <audio controls class="rex-plyr"' . $setup . $autoplay . $loop . $control_nojs . '>
                            <source src="' . $link . '" type="audio/mp3">
                        </audio>
                    ';
        }

        return $out;
    }

    /**
     * consent_helper
     *
     * @param  string $url
     * @param  string $return_when_empty
     * @return string
     */
    public static function consent($url = '', $setup = null, $poster = null, $return_when_empty = ''): string
    {

        $consent = '';
        if (rex_plyr::checkVimeo($url)) {
            $fragment = new rex_fragment();
            $fragment->setVar('url', $url, false);
            $fragment->setVar('type', 'vimeo', false);
            $consent = $fragment->parse('consent.php');
            return rex_plyr::outputMedia($url, $setup, $poster, $consent);
        }
        if (rex_plyr::checkYoutube($url)) {
            $fragment = new rex_fragment();
            $fragment->setVar('url', $url, false);
            $fragment->setVar('type', 'youtube', false);
            $consent = $fragment->parse('consent.php');
            return rex_plyr::outputMedia($url, $setup, $poster, $consent);
        }
        if ($return_when_empty == 'cke5') {
            return '<oembed url="' . $url . '"></oembed>';
        }
        return rex_plyr::outputMedia($url, $setup, $poster);
    }

    /**
     * cke_oembed_helper
     *
     * @return void
     */
    public static function cke_oembed_helper($setup = null): void
    {
        rex_extension::register('OUTPUT_FILTER', function ($ep) {

            $string = $ep->getSubject();
            $string = preg_replace_callback('/<oembed url="(.+?)"><\/oembed>/is', function ($video) {
                return rex_plyr::consent($video[1], $setup, $poster, 'cke5');
            }, $string);
            return $string;
        }, rex_extension::LATE);
    }
    
    
     /**
     * cke_oembed_helper
     *
     * @return void
     */
    public static function oembed_replace($string, $setup = null): string
    {
            $string = preg_replace_callback('/<oembed url="(.+?)"><\/oembed>/is', function ($video) {
                return rex_plyr::consent($video[1], $setup, $poster, 'cke5');
            }, $string);
            return $string;
    }
    

    /**
     * @param array $media_filenames Array with video/mp4 audio/mp3 file names from media pool
     * @param string $setup
     *
     * @return string
     */
    public static function outputMediaPlaylist($media_filenames, $setup = null)
    {
        $plyr = rex_addon::get('plyr');
        $svg_url = $plyr->getAssetsUrl("vendor/plyr/dist/plyr.svg");
        $blank_mp4 = $plyr->getAssetsUrl("vendor/plyr/dist/blank.mp4");
        $plyr_id = rand();
        $out = '<div class="plyr-container">';
        $out .= '<div id="player-' . $plyr_id . '">';
        $plyr_media = rex_plyr::outputMedia($media_filenames[0], $setup);
        $out .= str_replace(
            'class="rex-plyr"',
            'class="rex-plyr" id="plyr-' . $plyr_id . '"',
            str_replace("data-plyr-config='{", 'data-plyr-config=\'{"plyrId":"' . $plyr_id . '",', $plyr_media)
        );
        $out .= '</div>';
        $out .= '</div>';
        $out .= '<script>';
        $out .= '$(document).ready(function () {';
        $out .= 'loadPlaylist(Plyr.setup("#plyr-' . $plyr_id . '", {';
        $out .= 'youtube: { ';
        $out .= 'noCookie: true ';
        $out .= '},';
        $out .= 'iconUrl: "' . $svg_url . '",';
        $out .= 'blankVideo: "' . $blank_mp4 . '"';
        $out .= '}),';
        $out .= $plyr_id . ',';
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
