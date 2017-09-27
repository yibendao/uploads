<?php
/*
 * 分城市调用
 * ----------------------------------------------------------------------------
 *
 *
 * ============================================================================
*/
function smarty_function_listurl($paramer,&$smarty){
	global $config;
	
	$url = searchListRewrite($paramer,$config);

	return $url;
}
?>