<?php
/**
 * This file is part of the videopackage.
 *
 * @author (c) Friends Of REDAXO
 * @author <friendsof@redaxo.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (rex::isBackend() && is_object(rex::getUser())) {
      rex_view::addCssFile($this->getAssetsUrl('vendor/plyr/dist/plyr.css'));
    	rex_view::addJsFile($this->getAssetsUrl('vendor/plyr/dist/plyr.min.js'));   
    	rex_view::addJsFile($this->getAssetsUrl('plyr_be_init.js'));
}
