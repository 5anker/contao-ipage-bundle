<?php

System::loadLanguageFile('tl_content');
System::loadLanguageFile('tl_ipage');

$GLOBALS['TL_DCA']['tl_ipage_slide'] = [

	// Config
	'config' => [
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_ipage',
		'sql' => [
			'keys' => [
				'id' => 'primary',
			]
		]
	],

	// List
	'list' => [
		'sorting' => [
			'mode'                    => 4,
			'fields'                  => ['sorting'],
			'panelLayout'             => 'filter;search,limit',
			'headerFields'            => ['title'],
			'child_record_callback'   => ['tl_ipage_slide', 'parseRow']
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
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage_slide']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg'
			],
			'copy' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_content']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.svg',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			],
			'delete' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_content']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			],
			'show' => [
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage_slide']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			],
		]
	],

	// Palettes
	'palettes' => [
		'__selector__'                => ['type'],
		'default'                     => '{title_legend},type,title',
		'image'                       => '{title_legend},type,title;{media_legend},singleSRC,href',
		'video'                       => '{title_legend},type,title;{media_legend},href',
	],

	// Fields
	'fields' => [
		'id' => [
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		],
		'pid' => [
			'foreignKey'              => 'tl_ipage_slide.id',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => ['type'=>'belongsTo', 'load'=>'lazy']
		],
		'title' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage_slide']['title'],
			'exclude'                 => false,
			'search'                  => true,
			'sorting'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => ['maxlength'=>200, 'tl_class' => 'w50' ],
			'sql'                     => "varchar(255) NOT NULL default ''"
		],
		'singleSRC' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => ['fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'mandatory'=>true],
			'sql'                     => "binary(16) NULL"
		],
		'type' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage_slide']['type'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'default'                 => 'image',
			'options'                 => ['image', 'video'],
			'reference'               => &$GLOBALS['TL_LANG']['tl_ipage_slide'],
			'eval'                    => [
				'includeBlankOption' => true,
				'submitOnChange'     => true,
				'mandatory'          => true,
				'tl_class'           => 'w50 clr',
			],
			'sql'                     => "varchar(50) NULL"
		],
		'href' => [
			'label' => &$GLOBALS['TL_LANG']['tl_ipage_slide']['href'],
			'exclude' => true,
			'search' => true,
			'inputType' => 'text',
			'eval' => [
				'rgxp' => 'url',
				'decodeEntities' => true,
				'dcaPicker' => true,
				'fieldType' => 'radio',
				'filesOnly' => true,
				'tl_class' => 'clr wizard',
			],
			'sql' => ['type' => 'text', 'notnull' => false],
		],
		'sorting' => [
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		],
		'tstamp' => [
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		],
		'last_update' => [
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		],
	]
];

class tl_ipage_slide
{
	public function parseRow($arrRow)
	{
		$objTemplate = new \BackendTemplate('be_wildcard');
		$objTemplate->wildcard = $arrRow['href'];
		$objTemplate->title = $arrRow['title'];

		return $objTemplate->parse();
	}
}
