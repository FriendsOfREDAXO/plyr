
REDAXO-AddOn: Video
================================================================================

Das AddOn stellt die Video-Player [Plyr](https://plyr.io) und die aktuelle [Afterglow](https://afterglowplayer.com) beta zur Auswahl.

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/video/assets/video_01.png)

Es können lokale Videos und Youtube- sowie Vimeo-Videos (aktuell nur Plyr) eingebunden werden.  
Wir haben uns bewußt gegen eine automatische Einbindung im Frontend entschieden um dem Entwickler alle Freiheiten zu lassen. 


## Features
- Auswahl des gewünschten Players
- Einbindung des Players im Backend
- Konfigurationsseiten für die jeweiligen Player
- Test der Grundeinstellungen
- Funktionen zur Ermittlung von VIMEO und Youtube-IDs


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

Afterglow benötigt nur das eigentliche Skript. 


CSS für Plyr

```html
<link rel="stylesheet" href="<?= rex_url::base('assets/addons/video/Plyr/css/plyr.css') ?>">
```

JS für Plyr

```html
<script type="text/javascript" src="<?= rex_url::base('assets/addons/video/Plyr/js/plyr.js') ?>"></script>
<script type="text/javascript" src="<?= rex_url::base('assets/addons/video/Plyr/js/plyr_video.js') ?>"></script>

```

JS für Afterglow

```html
<script type="text/javascript" src="<?= rex_url::base('assets/addons/video/Afterglow/dist/afterglow.min.js') ?>"></script> 
```


## Hilfsfunktionen

`checkYoutube($url)` 
Prüft ob es sich um eine Youtube-URL handelt

`getYoutubeId($url)` 
Ermittelt die Youtube-ID eines Videos

`checkVimeo($url)` 
Prüft ob es sich um eine Vimeo-URL handelt

`getVimeoId($url)` 
Ermittelt die Vimeo-Id eines Videos


## Bugtracker

Du hast einen Fehler gefunden oder ein nettes Feature parat? [Lege ein Issue an](https://github.com/FriendsOfREDAXO/video/issues). Bevor du ein neues Issue erstellts, suche bitte ob bereits eines mit deinem Anliegen existiert und lese die [Issue Guidelines (englisch)](https://github.com/necolas/issue-guidelines) von [Nicolas Gallagher](https://github.com/necolas/).


## Changelog

siehe [CHANGELOG.md](https://github.com/FriendsOfREDAXO/video/blob/master/CHANGELOG.md)

## Lizenz

siehe [LICENSE.md](https://github.com/FriendsOfREDAXO/video/blob/master/LICENSE.md)

Plyr und Afterglow stehen unter MIT-Lizenz. Die Player bedienen sich jedoch teils unterschiedlicher Quellen, deren Lizenzen sich unterscheiden können. 


## Autor

**Friends Of REDAXO**

* http://www.redaxo.org
* https://github.com/FriendsOfREDAXO

**Projekt-Lead**

[KLXM Crossmedia / Thomas Skerbis](https://klxm.de)


## Credits:

First Release: [Christian Gehrke](https://github.com/chrison94)


