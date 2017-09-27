<?php
function smarty_function_desc($paramer,&$smarty){
	global $db,$db_config,$config;

    include(PLUS_PATH.'/desc.cache.php');

    foreach($desc_class as $k=>$v){
        foreach($desc_list as $val){
            if($v['id']==$val['nid']){
				if($val['is_type']>0){
					$val['url'] =$config['sy_weburl'].'/'.$val['url'];
				}	
                $desc_class[$k]['list'][]=$val;
            }
        }
    }

	$smarty->assign("$paramer[assign_name]",$desc_class);
}