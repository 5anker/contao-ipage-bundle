<?php

if (Input::get('do') == 'ipage') {
	$GLOBALS['TL_DCA']['tl_content']['config']['ptable'] = 'tl_ipage';
}


$GLOBALS['TL_DCA']['tl_content']['palettes']['ipage'] = '{type_legend},type;{content_legend},ipage;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['ipage'] = [
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['ipage'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'foreignKey'              => 'tl_ipage.title',
	'eval'                    => ['fieldType'=>'radio'], // do not set mandatory (see #5453)
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'relation'                => ['type'=>'hasOne', 'load'=>'lazy']
];
