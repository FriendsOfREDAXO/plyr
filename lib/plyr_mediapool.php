<?php
class plyr_mediapool
{
    public static function show_sidebar(rex_extension_point $ep)
    {
        $params = $ep->getParams();
        $file   = $params['filename'];
        $player = new rex_plyr();

        if ($player->checkMedia($file) or $player->checkAudio($file)) {
            $media = rex_plyr::outputMedia($file);
            return $media;
        }
        

    }

}
