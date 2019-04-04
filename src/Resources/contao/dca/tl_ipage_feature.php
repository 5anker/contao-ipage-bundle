<?php

System::loadLanguageFile('tl_content');
System::loadLanguageFile('tl_page');

$GLOBALS['TL_DCA']['tl_ipage_feature'] = [

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
			'child_record_callback'   => ['tl_ipage_feature', 'parseRow']
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
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage_feature']['edit'],
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
				'label'               => &$GLOBALS['TL_LANG']['tl_ipage_feature']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			],
		]
	],

	// Palettes
	'palettes' => [
		'default'                     => '{title_legend},title,icon;{content_legend},content'
	],

	// Fields
	'fields' => [
		'id' => [
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		],
		'pid' => [
			'foreignKey'              => 'tl_ipage.id',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => ['type'=>'belongsTo', 'load'=>'lazy']
		],
		'title' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage_feature']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => ['maxlength'=>200],
			'sql'                     => "varchar(255) NOT NULL default ''"
		],
		'icon' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage_feature']['icon'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => ['fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'mandatory'=>true],
			'sql'                     => "binary(16) NULL"
		],
		'content' => [
			'label'                   => &$GLOBALS['TL_LANG']['tl_ipage_feature']['content'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => ['mandatory'=>true, 'rte'=>'tinyMCE', 'helpwizard'=>true],
			'explanation'             => 'insertTags',
			'sql'                     => "mediumtext NULL"
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


class tl_ipage_feature
{
	public function parseRow($arrRow)
	{
		$objTemplate = new \BackendTemplate('be_wildcard');
		$objTemplate->wildcard = $arrRow['content'];
		$objTemplate->title = $arrRow['title'];

		$objModel = \FilesModel::findByUuid($arrRow['icon']);

		if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path)) {
			$objTemplate->wildcard = '<div style="padding-top: 10px"><img src="'.$objModel->path.'" style="height: 50px; margin-right: 10px" align="left" />' . $objTemplate->wildcard . '</div>';
		}

		return $objTemplate->parse();
	}
}
