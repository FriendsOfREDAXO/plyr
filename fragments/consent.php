<?php if($this->type == 'youtube' ):?>
<div class="aspect-ratio-16-9 plyr-consent-box">
        <div class="plyr-consent-box-content">
            <h2>Externes Video: Youtube</h2>
            <p class="plyr-consent-text">Bitte aktivieren Sie die Optionen zur Darstellung der Youtube-Videos in den Datenschutzeinstellungen</p>
            <p><button class="plyr-consent-box-content-button btn btn-primary uk-button uk-button-default consent_manager-show-box" onclick="javascript:consent_manager_showBox();">Datenschutz-Einstellungen</button></p>
            <p><a class="plyr-source-link" title="Video aufrufen beim Anbieter" href="<?=$this->url?>">Video bei youtube.com aufrufen</a></p>
        </div>
</div>
<?php endif; ?>
<?php if($this->type == 'vimeo' ):?>
<div class="aspect-ratio-16-9 plyr-consent-box">
        <div class="plyr-consent-box-content">
            <h2>Externes Video: Vimeo</h2>
            <p class="plyr-consent-text">Bitte aktivieren Sie die Optionen zur Darstellung der Vimeo-Videos in den Datenschutzeinstellungen</p>
            <p><button class="plyr-consent-box-content-button btn btn-primary uk-button uk-button-default consent_manager-show-box" onclick="javascript:consent_manager_showBox();">Datenschutz-Einstellungen</button></p>
            <p><a class="plyr-source-link" title="Video aufrufen beim Anbieter" href="<?=$this->url?>">Video bei vimeo.com aufrufen</a></p>
        </div>
</div>
<?php endif; ?>
