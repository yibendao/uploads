<?php
/*
 * 分城市调用
 * ----------------------------------------------------------------------------
 *
 *
 * ============================================================================
*/
function smarty_function_ratlogo($paramer,&$smarty){
	global $db,$db_config;
	include PLUS_PATH."/comrating.cache.php";
	if($paramer['uid'])
	{
		$comrating = $db->DB_select_once("company_statis","`uid`='".$paramer['uid']."'","`rating`");
		
		if($comrating['rating']>0)
		{
			foreach($comrat as $key=>$value)
			{
				if($value['id'] == $comrating['rating'])
				{
					$logo = $value['com_pic'];
					break;
				}
			}
		}
	}
	
	return $logo;
}
