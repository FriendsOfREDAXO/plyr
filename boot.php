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
$plyr = rex_addon::get('plyr');
if (rex::isBackend() && is_object(rex::getUser())) {
    rex_view::addCssFile($plyr->getAssetsUrl('vendor/plyr/dist/plyr.css'));
    rex_view::addJsFile($plyr->getAssetsUrl('vendor/plyr/dist/plyr.min.js'));   
    rex_view::addJsFile($plyr->getAssetsUrl('plyr_be_init.js'));
    rex_extension::register('MEDIA_DETAIL_SIDEBAR', 'plyr_mediapool::show_sidebar');
}

