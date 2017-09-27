<?php
function smarty_function_backurl($paramer,&$smarty){
		global $config;
		
		//设立返回模块对应数组 不在数组对应中的直接返回首页
		$backArray['1'] = array('modify'=>'resume','addexpect'=>'modify','info'=>'resume','');

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
		if(!($config['sy_wapdomain'])){

			$sy_wapdomain = $config['sy_weburl'].'/'.$config['sy_wapdir'];

		}else{
			if(strpos($config['sy_wapdomain'],$protocol)===false)
			{
				$sy_wapdomain = $protocol.$config['sy_wapdomain'];
			}
		}
		
			
		$getC = $_GET['c'];

		if($getC){
				$path = explode('&',$wapMemUrl['query']);
				foreach($path as $v){
					$vList = explode('=',$v);
					$newPath[$vList[0]] = $vList[1];
				}
		}else{

			$backUrl = $sy_wapdomain.'/member/';
		}
		//无来路域名 或 来路域名为第三方 则返回链接为首页
		if(!$wapMemUrl['host'] || $wapMemUrl['host']!=$_SERVER['HTTP_HOST']){

			

		}else{
			
			
			
			

			//同一模块下不同参数的跳转，返回链接为父模块
			if($newPath['c']==$getC && $newPath['a']==$getA){
			
			
			}elseif($newPath['c']==$getC){//只有父模块相似 则返回原链接
			
				
			}
			if($getArr['a']){
				if(!empty($getArr)){
					$backUrl = $sy_wapdomain.'/member/index.php?c='.$getC.'&a='.$getA;
				}else{
					$backUrl = $sy_wapdomain.'/member/index.php?c='.$getC;
				}
			}elseif($getArr['c']){
				
				$backUrl = $sy_wapdomain.'/member/';
			}
		}
		
		//return $backUrl;
	}
?>