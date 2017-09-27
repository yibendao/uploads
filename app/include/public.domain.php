<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2017 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
 $host =  $protocol.$_SERVER['HTTP_HOST'];

if($config['sy_web_site']=="1"){
	
	if(!strpos($host,"localhost")&&!strpos($host,"127.0.0.1")){

		if($host!=$config['sy_weburl']){
			
			if($_COOKIE['sy_weburl'] == $host){
				$config['sy_weburl']	=  $_COOKIE['sy_weburl'];
				$config['province']		=  (int)$_COOKIE['province'];
				$config['cityid']		=  (int)$_COOKIE['cityid'];
				$config['three_cityid']	=  (int)$_COOKIE['three_cityid'];
				$config['cityname']		=  $_COOKIE['cityname'];
				$config['did']			=  (int)$_COOKIE['did'];
				$config['fz_type']		=  $_COOKIE['fz_type'];
				$config['hyclass']		=  (int)$_COOKIE['hyclass'];
				$config['style']		=  $_COOKIE['style'];
				if($_COOKIE['sy_webtitle']!=""){
					$config['sy_webtitle']	=  $_COOKIE['sy_webtitle'];
				}
				if($_COOKIE['sy_webname']!=""){
					$config['sy_webname']	=  $_COOKIE['sy_webname'];
				}
				if($_COOKIE['sy_webkeyword']!=""){
					$config['sy_webkeyword']	=  $_COOKIE['sy_webkeyword'];
				}
				if($_COOKIE['sy_webmeta']!=""){
					$config['sy_webmeta']	=  $_COOKIE['sy_webmeta'];
				}
				if($_COOKIE['sy_logo']!=""){
					$config['sy_logo']	=  $_COOKIE['sy_logo'];
				}
			}else{
				if(strpos($host,$config['sy_onedomain'])!==false){
					$domainUrl  = $config['sy_onedomain'];
				}else{
					$domainUrlAll  = parse_url($host);
					$domainUrl = get_domain($domainUrlAll['host']);
				}
				
				include(PLUS_PATH."/domain_cache.php");
				include(PLUS_PATH."/city.cache.php");
				include(PLUS_PATH."/industry.cache.php");
				setcookies(
					array(
					'sy_weburl'=>'',
					'did'=>'',
					'fz_type'=>'',
					'province'=>'',
					'cityid'=>'',
					'hyclass'=>'',
					'three_cityid'=>'',
					'cityname'=>'',
					'sy_webkeyword'=>'',
					'sy_weburl'=>'',
					'sy_logo'=>'',
					'style'=>'',
					'sy_webtitle'=>'',
					'sy_webmeta'=>'',
					'sy_webname'=>''

				),time()-86400,$domainUrl);
				if(is_array($site_domain)){
					foreach($site_domain as $key=>$value){
						if($value['host']==$_SERVER['HTTP_HOST']){
							$parseDate['did']=$value['id'];
							$parseDate['fz_type']=$value['fz_type'];
							if($parseDate['fz_type']=='1'){
								if($value['three_cityid']>0){
									$parseDate['three_cityid']	=	$value['three_cityid'];
									$parseDate['cityname']		=	$city_name[$value['three_cityid']];
								}elseif($value['cityid']>0){
									$parseDate['cityid']	=	$value['cityid'];
									$parseDate['cityname']	=	$city_name[$value['cityid']];
								}else{
									$parseDate['province']	=	$value['province'];
									$parseDate['cityname']	=	$city_name[$value['province']];
								}
								setcookies('hyclass',time()-86400,$domainUrl);
							}else if($parseDate['fz_type']=='2'&&$value['hy']){
								$parseDate['hyclass']=$value['hy'];
								$parseDate['cityname']		=	$value['webname'];
								setcookies(
									array(
									'province'=>'',
									'cityid'=>'',
									'three_cityid'=>''
									),time()-86400,$domainUrl
								);
							}
							if($value['webname']){$parseDate['sy_webname']  =	$value['webname'];}
							if($value['webtitle']){$parseDate['sy_webtitle']  =	$value['webtitle'];}
							if($value['weblogo']){$parseDate['sy_logo']  =	$value['weblogo'];}
							if($value['webkeyword']){$parseDate['sy_webkeyword']  =	$value['webkeyword'];}
							if($value['webmeta']){$parseDate['sy_webmeta']  =	$value['webmeta'];}
							if($value['style']){$parseDate['style']  =	$value['style'];}
							$parseDate['sy_weburl']  =	$host;
							
							setcookies($parseDate,time()+86400,$domainUrl);
							$config = array_merge($config,$parseDate);
						}
					}
				}
			}
		}
	}
}

function setcookies($parseDate=array(),$time,$domain){
	$domain = get_domain($domain);
	if(is_array($parseDate)){
		foreach($parseDate as $key=>$value){
			SetCookie($key,$value,$time,"/",$domain);
		}
	}
}

?>