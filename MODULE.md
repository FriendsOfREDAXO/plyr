##PLYR
**Eingabe**
```
<?php
	$mform = new MForm();
	$mform->addFieldset("Video");
    $mform->addCustomLinkField("3", array('label'=>'Video', 'class'=>'test', 'data-tel'=>'disable', 'data-mailto'=>'disable', 'data-formlink'=>'disable', 'data-intern'=>'disable'));
    echo $mform->show();
 ?>
```
**Ausgabe**
```
<?php
//Variablen
$localAutoplay = "";
$Media = "/media/";
$url = 'REX_VALUE[3]';
// GET INPUT LINK AND CHECK IS IT URL/MEDIA
$plyr = new rex_video();
$link = $plyr->getVideoType($url);
// GET STANDARD CONFIG VARIABLES
$autoplayStandard = rex_config::get('video', 'autoplay_plyr');
$hideControls = rex_config::get('video', 'controls_plyr');
$clickToPlay = rex_config::get('video', 'click_plyr');

if($plyr->checkYoutube($link) == true) {
	echo '<div class="rex_video '.$autoplayStandard.' '.$hideControls.' '.$clickToPlay.'" data-type="youtube"  data-video-id="'.$plyr->getYoutubeId($link).'"></div></br>';
}
if($plyr->checkVimeo($link) == true) {
	echo 'Vimeo';	
	echo '<div class="rex_video '.$hideControls.' '.$autoplayStandard.' '.$clickToPlay.'" data-type="vimeo" data-video-id="'.$plyr->getVimeoId($link).'"></div></br>';
}
if(strpos($link, $Media) !== false) {
	if($autoplayStandard == 'Ja') {
		$localAutoplay = "autoplay";
	}
	echo '
		<section>
			<video '.$localAutoplay.' volume=1>
				<source src="'.$link.'" type="video/mp4">
			</video>
		</section>
		'; 
}
?>
```

##AFTERGLOW
**Eingabe**
```
<?php
	$mform = new MForm();
	$mform->addFieldset("Video");
    $mform->addCustomLinkField("3", array('label'=>'Link', 'class'=>'test', 'data-tel'=>'disable', 'data-mailto'=>'disable', 'data-formlink'=>'disable', 'data-intern'=>'disable'));
    echo $mform->show();
 ?>
```
**Ausgabe**
```
<?php

//Variablen
$Media = "/media/";
$url = 'REX_VALUE[3]';
$afterglow = new rex_video();
$link = $afterglow->getVideoType($url);
$autoplay = rex_config::get('video', 'autoplay_afterglow');
$sounds = rex_config::get('video', 'sound_afterglow');
$theme = rex_config::get('video', 'theme_afterglow');
// YOUTUBE
	
if($afterglow->checkYoutube($link) == true) {
	echo '<video autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" id="video1" class="afterglow" width="1920" height="1080" data-youtube-id="YH3c1QZzRK4" data-autoresize="fit"></video>';
}
	
// LOKALES MP4 Video
if(strpos($link, $Media) !== false) {
echo '
<video autoplay="'.$autoplay.'" data-volume="'.$sounds.'" data-skin="'.$theme.'" class="afterglow" id="myvideo">
  <source type="video/mp4" src="'.$link.'" />
</video>';
}
```