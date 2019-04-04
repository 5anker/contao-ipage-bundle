<?php

$GLOBALS['TL_CTE']['includes']['ipage'] = '\Anker\IPageBundle\ContentIPage';

array_insert($GLOBALS['BE_MOD']['content'], 7, [
	'ipage' => [
		'tables'      => ['tl_ipage', 'tl_ipage_info', 'tl_ipage_slide', 'tl_ipage_feature', 'tl_content'],
		'table'       => ['TableWizard', 'importTable'],
		'list'        => ['ListWizard', 'importList']
	]
]);
