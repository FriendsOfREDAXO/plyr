<?php

$content = '';
$buttons = '';

// Einstellungen speichern
if (rex_post('formsubmit', 'string') == '1') {
    $this->setConfig(rex_post('config', [
        ['autoplay_plyr', 'string'],
        ['controls_plyr', 'string'],
        ['click_plyr', 'string'],
        ['autoplay_audio', 'string'],
        ['loop_audio', 'string'],
    ]));

    echo rex_view::success($this->i18n('config_saved'));
}


//////////////
///PLYRAXO///
/////////////

$content .= '<fieldset><legend>' . $this->i18n('plyr_video') . '</legend>';

///////////////
/////Video/////
///////////////

// AUTOPLAY //
$formElements = [];
$n = [];
$n['label'] = '<label for="Autoplay_plyr">' . $this->i18n('Autoplay_plyr') . '</label>';
$select = new rex_select();
$select->setId('autoplay_plyr');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[autoplay_plyr]');
$select->addOption('Ja', 'Ja');
$select->addOption('Nein', 'Nein');

$select->setSelected($this->getConfig('autoplay_plyr'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

// HIDE CONTROLS //

$formElements = [];
$n = [];
$n['label'] = '<label for="Controls_plyr">' . $this->i18n('Controls_plyr') . '</label>';
$select = new rex_select();
$select->setId('controls_plyr');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[controls_plyr]');
$select->addOption('Anzeigen', 'Anzeigen');
$select->addOption('Ausblenden', 'Ausblenden');

$select->setSelected($this->getConfig('controls_plyr'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');


// Click-On-Video //
$formElements = [];
$n = [];
$n['label'] = '<label for="Click_plyr">' . $this->i18n('Click_plyr') . '</label>';
$select = new rex_select();
$select->setId('click_plyr');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[click_plyr]');
$select->addOption('Aktivieren', 'Aktivieren');
$select->addOption('Deaktivieren', 'Deaktivieren');

$select->setSelected($this->getConfig('click_plyr'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

///////////////
/////Audio/////
///////////////

$content .= '<fieldset><legend>' . $this->i18n('plyr_audio') . '</legend>';
/*
// AUTOPLAY //
$formElements = [];
$n = [];
$n['label'] = '<label for="Autoplay_audio">' . $this->i18n('Autoplay_audio') . '</label>';
$select = new rex_select();
$select->setId('autoplay_audio');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[autoplay_audio]');
$select->addOption('Ja', 'Autoplay');
$select->addOption('Nein', ' ');

$select->setSelected($this->getConfig('autoplay_audio'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');
*/
// LOOP //

$formElements = [];
$n = [];
$n['label'] = '<label for="Loop_audio">' . $this->i18n('Loop_audio') . '</label>';
$select = new rex_select();
$select->setId('loop_audio');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[loop_audio]');
$select->addOption('Wiederholen', 'loop');
$select->addOption('Nicht Wiederholen', ' ');

$select->setSelected($this->getConfig('loop_audio'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

// Save-Button
$formElements = [];
$n = [];
$n['field'] = '<button class="btn btn-save rex-form-aligned" type="submit" name="save" value="' . $this->i18n('config_save') . '">' . $this->i18n('config_save') . '</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');
$buttons = '
<fieldset class="rex-form-action">
    ' . $buttons . '
</fieldset>
';



// Ausgabe Formular
$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('title', $this->i18n('config'));
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$output = $fragment->parse('core/page/section.php');

$output = '
<form action="' . rex_url::currentBackendPage() . '" method="post">
<input type="hidden" name="formsubmit" value="1" />
    ' . $output . '
</form>

';

echo $output;
