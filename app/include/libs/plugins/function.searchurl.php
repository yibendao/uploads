<?php
//用于后台高级搜索
function smarty_function_searchurl($paramer,$_smarty_tpl){
	extract($paramer);
    global $config;
	global $ModuleName;
	global $adminDir;
	global $siteAdminDir;
	unset($_GET['page']);
	$url=$_GET;
	$return_url="index.php?";
	if($m=='member'){
		$return_url="member/index.php?";
		unset($m);
	}
	if($m){
        if(trim($config['sy_'.$m.'domain'])){
            $ModulePath='http://'.trim($config['sy_'.$m.'domain']).'/';
        }else{
            if(trim($config['sy_'.$m.'dir']) && !$adminDir && !$siteAdminDir){
			    $ModulePath=trim($config['sy_'.$m.'dir']).'/';unset($m);unset($paramer['m']);
		    }else{
                $return_url_new[]="m=".$m;
            }
        }
	}
	foreach($paramer as $key=>$va){
		if($key!="m" && $key!="untype" && $key!="thisdir" && $key!="adt"  && $key!="adv" && $va!=''){
			$return_url_new[]=$key."=".$va;
		}
	}	
	$url['m']='';unset($url['m']);
    
	$untype=@explode(",",$untype);
	foreach($url as $key=>$va){
		if($key!='c' && $va!="" && !in_array($key,$untype)){
			$return_url_new[]=$key."=".$va;
		}
	}
    if(($ModuleName=='siteadmin' && !$ModulePath)||($ModuleName==$adminDir && !$ModulePath)){
          $ModulePath=$ModuleName.'/';
    }
	if($paramer['adt']){
		$return_url_new[]=$paramer['adt']."=".$paramer['adv'];
	}
    if(substr($ModulePath,0,7)=='http://'){
	    $return_url=$ModulePath.$return_url.@implode('&',$return_url_new);
    }else{
        $return_url=$config['sy_weburl'].'/'.$ModulePath.$return_url.@implode('&',$return_url_new);
    }
    $return_url=FormatUrl($return_url);
	return $return_url;
}
?>