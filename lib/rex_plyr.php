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
/* add return types*/
class rex_plyr
{
    /**
     * @param string $url
     *
     * @return string
     */
    public static function checkUrl($url): string
    {
        if ($url) {
            if (false === filter_var($url, FILTER_VALIDATE_URL)) {
            }
            if (true === file_exists(rex_path::media($url))) {
                return rex_url::media($url);
            }

        }return $url;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public static function checkYoutube($url): bool
    {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|shorts/)|youtu\.be/)([^"&?/ ]{11})%i', $url)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function getYoutubeId($url): string
    {
        $youtubeID = '';
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|shorts/)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $youtubeID = $match[1];
        }
        return $youtubeID;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public static function checkMedia($url): bool
    {
        $media = rex_media::get($url);
        $checkPath = pathinfo($url);
        if ($media) {
            if ('mp4' == strtolower($checkPath['extension'])) {
                return true;
            }
            if ('mov' == strtolower($checkPath['extension'])) {
                return true;
            }
            if ('m4v' == strtolower($checkPath['extension'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public static function checkVideo($url): bool
    {
        if (self::checkYoutube($url) || self::checkVimeo($url) || self::checkMedia($url) || self::checkExternalMp4($url)) {
            return true;
        }
        return false;
    }

    /**
     * Check if the provided audio URL corresponds to a supported audio format.
     *
     * @param string $url The URL of the audio file to check.
     *
     * @return string|bool If the audio format is supported, returns the audio format's extension (e.g., 'mp3', 'ogg', etc.).
     *                     If the audio format is not supported or the provided URL is invalid, returns false.
     */
    public static function checkAudio($url): string | bool
    {
        // Get the audio object from the given URL
        $audio = rex_media::get($url);
        $checkPath = pathinfo($url);
        if ($audio) {
            $extension = strtolower($checkPath['extension']);
            $supportedFormats = ['mp3', 'ogg', 'wav', 'webm', 'm4a'];
            if (in_array($extension, $supportedFormats)) {
                return $extension;
            }
        }
        return false;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public static function checkVimeo($url): bool
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
    public static function getVimeoId($url): string
    {
        $vimeoID = '';
        if (preg_match('~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/(progressive_redirect\/playback|external|videos?))?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $url, $match)) {
            $vimeoID = $match[2];
        }
        return $vimeoID;
    }

    /**
     * checkExternalMp4.
     *
     * @param  string $url
     * @return bool
     */
    public static function checkExternalMp4($url): bool
    {
        if (true == filter_var($url, FILTER_VALIDATE_URL)) {
            if ($checkurl = get_headers($url, 1)) {
                if ('video/mp4' == $checkurl['Content-Type']) {
                    return true;
                }
            }

        }return false;
    }

    /**
     * @param string $url
     * @param string $setup
     * @param string $poster
     *
     * @return string
     */
    public static function outputMedia($url, $setup = null, $poster = null, $consent = null): string
    {
        $player = new self();
        $link = $player->checkUrl($url);
        $consent_content = '';
        $consent_suffix = ' ';
        $out = $nopreload = '';

        if ($consent) {
            $consent_suffix = '_consent_';
            $consent_content = $consent;
        }
        if ($setup) {
            $control_attr = explode(',', $setup);
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

        if (true == $player->checkYoutube($link)) {
            $provider = 'youtube';
            $embed_id = $player->getYoutubeId($link);
        }

        if (true == $player->checkVimeo($link)) {
            $provider = 'vimeo';
            $embed_id = $player->getVimeoId($link);
        }

        if ('' != $provider) {
            $out = '<div class="rex-plyr' . $consent_suffix . $provider . '" data-plyr-provider="' . $provider . '" data-plyr-embed-id="' . $embed_id . '"' . $setup . '>' . $consent_content . '</div>';
        }

        if (false !== $player->checkMedia($url) || true === $player->checkExternalMp4($url)) {
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

        $audioFormat = $player->checkAudio($url);

        if (false != $audioFormat) {
            $out = '
        <audio controls class="rex-plyr"' . $setup . $autoplay . $loop . $control_nojs . '>
            <source src="' . $link . '" type="audio/' . $audioFormat . '">
        </audio>
        ';
        }

        return $out;
    }

    /**
     * consent_helper.
     *
     * @param  string $url
     * @param  string $return_when_empty
     */
    public static function consent($url = '', $setup = null, $poster = null, $return_when_empty = ''): string
    {
        $consent = '';
        if (self::checkVimeo($url)) {
            $fragment = new rex_fragment();
            $fragment->setVar('url', $url, false);
            $fragment->setVar('type', 'vimeo', false);
            $consent = $fragment->parse('consent.php');
            return self::outputMedia($url, $setup, $poster, $consent);
        }
        if (self::checkYoutube($url)) {
            $fragment = new rex_fragment();
            $fragment->setVar('url', $url, false);
            $fragment->setVar('type', 'youtube', false);
            $consent = $fragment->parse('consent.php');
            return self::outputMedia($url, $setup, $poster, $consent);
        }
        if ('cke5' == $return_when_empty) {
            return '<oembed url="' . $url . '"></oembed>';
        }
        return self::outputMedia($url, $setup, $poster);
    }

    /**
     * cke_oembed_helper.
     */
    public static function cke_oembed_helper($setup = null): void
    {
        rex_extension::register('OUTPUT_FILTER', static function ($ep) {
            $string = $ep->getSubject();
            return preg_replace_callback('/<oembed url="(.+?)"><\/oembed>/is', static function ($video) {
                return self::consent($video[1], $setup = '', $poster = '', 'cke5');
            }, $string);
        }, rex_extension::LATE);
    }

    /**
     * cke_oembed_helper.
     *
     * @return void
     */
    public static function oembed_replace($string, $setup = null): string
    {
        return preg_replace_callback('/<oembed url="(.+?)"><\/oembed>/is', static function ($video) {
            return self::consent($video[1], $setup, $poster, 'cke5');
        }, $string);
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
        $svg_url = $plyr->getAssetsUrl('vendor/plyr/dist/plyr.svg');
        $blank_mp4 = $plyr->getAssetsUrl('vendor/plyr/dist/blank.mp4');
        $plyr_id = random_int(0, getrandmax());
        $out = '<div class="plyr-container">';
        $out .= '<div id="player-' . $plyr_id . '">';
        $plyr_media = self::outputMedia($media_filenames[0], $setup);
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
        return $out . '</script>';
    }
}
