<?php
/**
 * plyr_mediapool
 *
 * @package redaxo5
 */
class plyr_mediapool
{
    public static function show_sidebar(rex_extension_point $ep)
    {
        $params = $ep->getParams();
        $file = $params['filename'];
        $player = new rex_plyr();

        if ($player->checkMedia($file) || $player->checkAudio($file)) {
            return rex_plyr::outputMedia($file);
        }
    }
}
