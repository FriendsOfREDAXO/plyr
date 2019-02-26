
REDAXO-AddOn: Video
================================================================================

Das AddOn stellt den Video-/Audio-Player [Plyr](https://plyr.io) und [Afterglow](https://afterglowplayer.com) (nur Video) zur Auswahl.

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/video/assets/video_01.jpg)

Es können lokale Audio-Dateien (Plyr), Videos und Youtube- sowie Vimeo-Videos eingebunden werden.  
Wir haben uns bewusst gegen eine automatische Einbindung im Frontend entschieden um dem Entwickler alle Freiheiten zu lassen. 

> Möchte man die mitgelieferten Player nicht verwenden, kann man deren Einbindung deaktivieren. Die Methoden der rex_video class, stehen dann weiterhin zur Verfügung. 

## Features
- Auswahl des gewünschten Players
- Einbindung des Players im Backend
- Konfigurationsseiten für die jeweiligen Player
- Test der Grundeinstellungen
- Methoden zur Ermittlung von VIMEO und Youtube-IDs
- REX_FOR_VIDEO[] Variable


## Installation

1. Über Installer laden oder Zip-Datei im AddOn-Ordner entpacken, der Ordner muss „video“ heißen.
2. AddOn installieren und aktivieren.
3. Bevorzugten Video-Player auswählen
4. Standard Konfigurationen setzen
5. Skripte und CSS für das Frontend bitte manuell einbinden. 


## Module
Den Modulcode findet man oben in den Reitern. 


## Einbindung im Frontend

Die nötigen Dateien findet man in den Assets-Ordnern der jeweiligen Player. 

Eigene CSS und JS sollten nach Möglichkeit an anderer Stelle abgelegt werden um Probleme nach einem Update zu vermeiden. 


### Plyr

Plyr benötigigt 2 JS-Dateien und eine CSS. In der `plyr_video.js` wird der Player initialisiert. 

Afterglow liefert kein separates CSS aktuell mit. 


CSS für Plyr

```html
<link rel="stylesheet" href="<?= rex_url::base('assets/addons/video/Plyr/plyr.css') ?>">
```

JS für Plyr

```html
<script type="text/javascript" src="<?= rex_url::base('assets/addons/video/Plyr/plyr.min.js') ?>"></script>
<script type="text/javascript" src="<?= rex_url::base('assets/addons/video/js/plyr_video.js') ?>"></script>

```

JS für Afterglow

```html
<script type="text/javascript" src="<?= rex_url::base('assets/addons/video/Afterglow/afterglow.min.js') ?>"></script> 
```




## Hilfsmethoden in der rex_video class

`getVideoType($url)`
Gibt sofern es sich um eine Mediapool-Datei handelt die URL zum Medium zurück. 

`checkYoutube($url)` 
Prüft ob es sich um eine Youtube-URL handelt

`getYoutubeId($url)` 
Ermittelt die Youtube-ID eines Videos

`checkVimeo($url)` 
Prüft ob es sich um eine Vimeo-URL handelt

`getVimeoId($url)` 
Ermittelt die Vimeo-Id eines Videos

`checkMedia($url)` 
Überprüft ob es sich um ein MP4-Video aus dem Medienpool handelt

`checkAudio($url)` 
Überprüft ob es sich um eine MP3-Audio-Datei aus dem Medienpool handelt

**Beispiel**

```php
$plyr = new rex_video();
$url = $plyr->getVideoType($url);
```

## Direkte Verarbeitung über statische Methode

`$video = rex_video::outputVideo($url);`

Bei Dateien aus dem Medienpool muss nur der Dateiname angegeben werden. Bei Youtube und Vimeo immer die vollständige URL. 



## Bugtracker

Du hast einen Fehler gefunden oder ein nettes Feature parat? [Lege ein Issue an](https://github.com/FriendsOfREDAXO/video/issues). Bevor du ein neues Issue erstellst, suche bitte ob bereits eines mit deinem Anliegen existiert.

## Lizenz

siehe [LICENSE.md](https://github.com/FriendsOfREDAXO/video/blob/master/LICENSE.md)

Plyr und Afterglow stehen unter MIT-Lizenz. Die Player bedienen sich jedoch teils unterschiedlicher Quellen, deren Lizenzen sich unterscheiden können. 


## Autor

**Friends Of REDAXO**

* http://www.redaxo.org
* https://github.com/FriendsOfREDAXO

**Projekt-Lead**
[Thomas Skerbis](https://github.com/skerbis)


## Credits:

First Release: [Christian Gehrke](https://github.com/chrison94)

