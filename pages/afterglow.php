<?php

$content = '';
$buttons = '';

// Einstellungen speichern
if (rex_post('formsubmit', 'string') == '1') {
    $this->setConfig(rex_post('config', [
        ['autoplay_afterglow', 'string'],
        ['sound_afterglow', 'int'],
        ['theme_afterglow', 'string']
  
    ]));

    echo rex_view::success($this->i18n('config_saved'));
}


//////////////
//AFTERGLAXO//
/////////////


// AUTOPLAY //
$formElements = [];
$n = [];
$n['label'] = '<label for="Autoplay_afterglow">' . $this->i18n('Autoplay_afterglow') . '</label>';
$select = new rex_select();
$select->setId('autoplay_afterglow');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[autoplay_afterglow]');
$select->addOption('Ja', 'Autoplay');
$select->addOption('Nein', '');

$select->setSelected($this->getConfig('autoplay_afterglow'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

// HIDE CONTROLS //

$formElements = [];
$n = [];
$n['label'] = '<label for="Sounds_afterglow">' . $this->i18n('Sounds_afterglow') . '</label>';
$select = new rex_select();
$select->setId('sound_afterglow');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[sound_afterglow]');
$select->addOption('An', '1');
$select->addOption('Aus', '0');

$select->setSelected($this->getConfig('sound_afterglow'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

// THEME //
$formElements = [];
$n = [];
$n['label'] = '<label for="Theme_afterglow">' . $this->i18n('Theme_afterglow') . '</label>';
$select = new rex_select();
$select->setId('theme_afterglow');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[theme_afterglow]');
$select->addOption('Dark', 'dark');
$select->addOption('Light', 'light');

$select->setSelected($this->getConfig('theme_afterglow'));
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
