<?php

$GLOBALS['TL_CTE']['br24']['ipage'] = 'Anker\IPageBundle\ContentIPage';

array_insert($GLOBALS['BE_MOD']['br24'], 1, [
	'ipage' => [
		'tables'      => ['tl_ipage', 'tl_ipage_info', 'tl_ipage_slide', 'tl_ipage_feature', 'tl_content'],
		'table'       => ['TableWizard', 'importTable'],
		'list'        => ['ListWizard', 'importList']
	]
]);
