<?php

System::loadLanguageFile('tl_content');
System::loadLanguageFile('tl_page');

$GLOBALS['TL_DCA']['tl_ipage'] = [

	// Config
	'config' => [
		'dataContainer'               => 'Table',
		'ctable'                      => ['tl_content'],
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'markAsCopy'                  => 'title',
		'sql' => [
			'keys' => [
				'id' => 'primary',
			]
		]
	],

	// List
	'list' => [
		'sorting' => [
			'mode'                    => 2,
			'fields'                  => ['title DESC'],
			'flag'                    => 1,
			'panelLayout'             => 'filter;sort,search,limit'
		],
		'label' => [
			'fields'                  => ['title'],
			'showColumns'             => true,
		],
		'global_operations' => [
			'all' => [
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			]
		],
		'operations' => [
			'edit' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage']['edit'],
				'href'                => 'table=tl_content',
				'icon'                => 'edit.svg'
			],
			'editheader' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage']['editmeta'],
				'href'                => 'act=edit',
				'icon'                => 'header.svg'
			],

			'copy' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_content']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.svg',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			],
			'slider' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage']['slider'],
				'href'                => 'table=tl_ipage_slide',
				'icon'                => 'bundles/ankeripage/gallery.svg'
			],
			'infos' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage']['infos'],
				'href'                => 'table=tl_ipage_info',
				'icon'                => 'bundles/ankeripage/accordion.svg'
			],
			'features' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage']['features'],
				'href'                => 'table=tl_ipage_feature',
				'icon'                => 'bundles/ankeripage/feature.svg'
			],
			'delete' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_content']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			],
			'show' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			],
		]
	],

	// Palettes
	'palettes' => [
		'default'                     => '{title_legend},title,headline;{content_legend},content,singleSRC,news,cruises;{options_legend},formular,bquery,slider'
	],

	// Fields
	'fields' => [
		'id' => [
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		],
		'title' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => ['maxlength'=>200],
			'sql'                     => "varchar(255) NOT NULL default ''"
		],
		'headline' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage']['headline'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => ['maxlength'=>200],
			'sql'                     => "varchar(255) NOT NULL default ''"
		],
		'content' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage']['content'],
			'exclude'                 => true,
			'search'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => ['mandatory'=>true, 'rte'=>'tinyMCE', 'helpwizard'=>true],
			'explanation'             => 'insertTags',
			'sql'                     => "mediumtext NULL"
		],
		'singleSRC' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => ['fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'mandatory'=>true],
			'sql'                     => "binary(16) NULL"
		],
		'formular' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage']['formular'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => ['allowHtml'=>true, 'class'=>'monospace', 'rte'=>'ace|html', 'helpwizard'=>true],
			'explanation'             => 'insertTags',
			'sql'                     => "text NULL"
		],
		'template' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['template'],
			'default'                 => '',
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => ['tl_ipage', 'getTemplates'],
			'eval'                    => ['includeBlankOption'=>true, 'tl_class'=>'w50'],
			'sql'                     => "varchar(64) NOT NULL default ''"
		],
		'bquery' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage']['query'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => [],
			'sql'                     => "text NULL"
		],
		'slider' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage']['slider'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => [],
			'sql'                     => "text NULL"
		],
		'news' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage']['news'],
			'exclude'                 => true,
			'inputType'               => 'checkboxWizard',
			'foreignKey'              => 'tl_news.headline',
			'eval'                    => [ 'multiple' => true, 'mandatory'=>false, 'chosen'=>true, 'tl_class' => 'w50' ],
			'sql'                     => "blob NULL",
			'relation'                => ['type'=>'hasMany', 'load'=>'lazy', 'table' => 'tl_news']
		],
		'cruises' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage']['cruises'],
			'exclude'                 => true,
			'inputType'               => 'checkboxWizard',
			'foreignKey'              => 'tl_news.headline',
			'eval'                    => [ 'multiple' => true, 'mandatory'=>false, 'chosen'=>true, 'tl_class' => 'w50' ],
			'sql'                     => "blob NULL",
			'relation'                => ['type'=>'hasMany', 'load'=>'lazy', 'table' => 'tl_news']
		],

		'tstamp' => [
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		],
		'last_update' => [
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		],
	]
];

class tl_ipage
{
	public function getTemplates()
	{
		return $this->getTemplateGroup('ipage_');
	}

	public function setPagesFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord && $dc->activeRecord->type == 'search') {
			$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['mandatory'] = false;
			unset($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['orderField']);
		}

		return $varValue;
	}
}
