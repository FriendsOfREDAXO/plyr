# Module

> Die hier gezeigten Module nuzten das AddOn **mform**. Es kann aber auch ein normaler Input oder Medialink genuzt werden. Die hier gezeigte Lösung hat den Vorteil, dass es eine Auswahl für einen externen und einen Medienlink in einem Value zur Verfügung stellt. 


## PLYR

**Eingabe**
```php
$mform = new MForm();
$mform->addFieldset("Video");
$mform->addCustomLinkField("1", array('label'=>'Video', 'data-tel'=>'disable', 'data-mailto'=>'disable', 'data-formlink'=>'disable', 'data-intern'=>'disable'));
echo $mform->show();
```
**Ausgabe**

Am einfachsten geht's mit:

`REX_FOR_VIDEO[1]`

Alternativ:

```php
//Variablen
$localAutoplay = "";
$Media = "/media/";
$file = 'REX_VALUE[1]';
// GET INPUT LINK AND CHECK IS IT URL/MEDIA
$plyr = new rex_video();
$link = $plyr->getVideoType($file);
// GET STANDARD CONFIG VARIABLES
$autoplayStandard = rex_config::get('video', 'autoplay_plyr');
$hideControls = rex_config::get('video', 'controls_plyr');
$clickToPlay = rex_config::get('video', 'click_plyr');

if($plyr->checkYoutube($link) == true) {
    echo '<div class="rex_video '.$autoplayStandard.' '.$hideControls.' '.$clickToPlay.'" data-type="youtube"  data-video-id="'.$plyr->getYoutubeId($link).'"></div></br>';
}
if($plyr->checkVimeo($link) == true) {
    echo '<div class="rex_video '.$hideControls.' '.$autoplayStandard.' '.$clickToPlay.'" data-type="vimeo" data-video-id="'.$plyr->getVimeoId($link).'"></div></br>';
}
if($plyr->checkMedia($file) !== false) {
    if($autoplayStandard == 'Ja') {
        $localAutoplay = "autoplay";
    }
    echo '
    	<section>
			<video>
				<source src="'.$link.'" type="video/mp4">
			</video>
		</section>
		 ';
}
if($plyr->checkAudio($file) !== false) {
	echo '	
		<section>
			<audio '.$autoplay_audio.' '.$loop_audio.'>
				<source src="'.$link.'" type="audio/mp3">
			</audio>
		</section>
		';
}
?>
```

## AFTERGLOW


**Eingabe**
```php
$mform = new MForm();
$mform->addFieldset("Video");
$mform->addCustomLinkField("1", array('label'=>'Link', 'data-tel'=>'disable', 'data-mailto'=>'disable', 'data-formlink'=>'disable', 'data-intern'=>'disable'));
    echo $mform->show();
```
**Ausgabe**

Am einfachsten geht's mit:

`REX_FOR_VIDEO[1]`

Alternativ:
```php
$file = 'REX_VALUE[1]';
$afterglow = new rex_video();
$link = $afterglow->getVideoType($file);
$autoplay = rex_config::get('video', 'autoplay_afterglow');
$sounds = rex_config::get('video', 'sound_afterglow');
$theme = rex_config::get('video', 'theme_afterglow');

if($afterglow->checkYoutube($link) == true) {
    echo '
        <video  autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" class="afterglow" id="video1" width="1920" height="1080"  data-youtube-id="'.$afterglow->getYoutubeId($link).'" data-autoresize="fit"></video>
        ';
}

if($afterglow->checkVimeo($link) == true) {
	echo '
		 <video class="afterglow" id="myvideo" width="960" height="540" data-vimeo-id="'.$afterglow->getVimeoId($link).'"></video>
		';
}
// Lokales MP4 Video als Standard-Player
if($afterglow->checkMedia($file) !== false) {
    echo '
        <video autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" class="afterglow" id="myvideo" width="1080" height="720">
            <source type="video/mp4" src="'.$link.'" />
        </video>
        ';
}
```


* Afterglow hat ein "Lightbox"-Feature, womit man das Video hinter einem Link verstecken kann.

```php
$file = 'REX_VALUE[1]';
$afterglow = new rex_video();
$link = $afterglow->getVideoType($file);
$autoplay = rex_config::get('video', 'autoplay_afterglow');
$sounds = rex_config::get('video', 'sound_afterglow');
$theme = rex_config::get('video', 'theme_afterglow');

// YOUTUBE mit LIGHTBOX-Feature 
if($afterglow->checkYoutube($link) == true) {
    echo '
    	<a class="afterglow" href="#video1">Launch lightbox</a>
        <video  autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" id="video1" width="1920" height="1080"  data-youtube-id="'.$afterglow->getYoutubeId($link).'" data-autoresize="fit"></video>
        ';
}
```
