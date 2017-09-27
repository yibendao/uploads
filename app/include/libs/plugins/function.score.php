<?php

function smarty_function_score($paramer,&$smarty){
	global $db,$db_config,$config;
	
	
	if($paramer['uid']){
		$uid = $paramer['uid'];
		
		$avg = $db->DB_select_once('company_msg',"`cuid`='".(int)$uid."' AND `status`='1'","count(*) as num,AVG(score) as score,AVG(desscore) as desscore,AVG(comscore) as comscore,AVG(hrscore) as hrscore");

		 $avgArr = array('num'=>$avg['num'],'score'=>round($avg['score'],1),'desscore'=>round($avg['desscore'],1),'hrscore'=>round($avg['hrscore'],1),'comscore'=>round($avg['comscore'],1));

		 $smarty->assign("$paramer[item]",$avgArr);
	}
	
}