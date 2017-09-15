<?php
$content = '';
if (rex_post('formsubmit', 'string') == '1') {
    $this->setConfig(rex_post('config', [
        ['player', 'string'],
      
    ]));

$newURL = rex_url::currentBackendPage();
// Umleitung auf die aktuelle Seite auslösen
rex_response::sendRedirect($newURL);
}


// PLAYER-AUSWAHL //

$formElements = [];
$n = [];
$n['label'] = '<label for="Player">' . $this->i18n('player') . '</label>';
$select = new rex_select();
$select->setId('player');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config[player]');
$select->addOption('Plyr', 'Plyr');
$select->addOption('Afterglow', 'Afterglow');
$select->setSelected($this->getConfig('player'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

// SAVE BUTTON // 


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

// Ausgabe Formular //

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