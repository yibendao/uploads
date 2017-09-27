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
/*
 * 把数组生成字符串
 */
function ArrayToString($obj,$withKey=true,$two=false){
	if(empty($obj))	return array();
	$objType=gettype($obj);
	if ($objType=='array') {
		$objstring = "array(";
	    foreach ($obj as $objkey=>$objv) {
			if($withKey)$objstring .="\"$objkey\"=>";
			$vtype =gettype($objv) ;
			if ($vtype=='integer') {
                $objstring .="$objv,";
			}else if ($vtype=='double'){
                $objstring .="$objv,";
			}else if ($vtype=='string'){
                $objv= str_replace('"',"\\\"",$objv);
                $objstring .="\"".$objv."\",";
			}else if ($vtype=='array'){
                $objstring .="".ArrayToString($objv,$withKey,$two).",";
			}else if ($vtype=='object'){
                $objstring .="".ArrayToString($objv,$withKey,$two).",";
			}else {
                $objstring .="\"".$objv."\",";
			}
	    }
		$objstring = substr($objstring,0,-1)."";
		return $objstring.")\n";
	}
}

function fun_ip_get() { 
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
		$ip = getenv("HTTP_CLIENT_IP");
	} else
		if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		} else
			if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
				$ip = getenv("REMOTE_ADDR");
			} else
				if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
					$ip = $_SERVER['REMOTE_ADDR'];
				} else {
					$ip = "unknown";
				}
    $preg="/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
    if(preg_match($preg,$ip)){        
		return ($ip);
    }
}

function get_ip_city($ip){
	$url='http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
	if(function_exists('file_get_contents')){
		$file_contents = file_get_contents($url);
	}else{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
	}
	$file=json_decode($file_contents);
	
	$city['threecity']=iconv("utf-8","gbk",$file->data->county);
	$city['city']=iconv("utf-8","gbk",$file->data->city);
	$city['province']=iconv("utf-8","gbk",$file->data->region);
	return $city;
}

function go_to_city($site_domain){
	
	$ip=fun_ip_get();
	$city=get_ip_city($ip);
	if(!empty($city)){
		foreach($city as $key =>$value){
			$city[$key] = str_replace(array("省","市","县","区"),array(""),$value);
		}
	}

	if($city['threecity']){
		foreach($site_domain as $value){
			$cityname=str_replace(array("省","市","县","区"),array(""),$value['cityname']);
			similar_text($city['threecity'],$cityname,$percent);
			if($percent>=65){
				$gotourl=$value['host'];
				break;
			}
		}
	}
	if(!$gotourl && $city['city']){
		foreach($site_domain as $value){
			$cityname=str_replace(array("省","市","县","区"),array(""),$value['cityname']);
			similar_text($city['city'],$cityname,$percent);
			if($percent>=65){
				$gotourl=$value['host'];
				break;
			}
		}
	}
	if(!$gotourl && $city['province']){
		foreach($site_domain as $value){
			$cityname=str_replace(array("省","市","县","区"),array(""),$value['cityname']);
			similar_text($city['province'],$cityname,$percent);
			if($percent>=65){				
				$gotourl=$value['host'];
				break;
			}
		}
	}
	SetCookie("gotocity",'1',time() + 3600, "/");
	if($gotourl){
		
		header('Location: http://'.$gotourl);	
		exit();
	}
}

function getUploadPic($content,$count=0){
	$content=str_replace('"','',$content);
	$content=str_replace('\'','',$content);
	$content=str_replace('>',' width="">',$content);
	$pattern=preg_match_all('/<img[^>]+src=(.*?)\s[^>]+>/im' ,$content,$match);
	if($match[1]){
		if($count>0){
			$i=0;
			foreach($match[1] as $v){
				if(!empty($v)){
					$pic[]=$v;
					$i++;
					if($i>=$count){
						break;
					}
				}
			}
			return $pic;
		}
		return $match[1];
	}
	return array();
}

function dreferer($default = '') {
    $referer=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
    if(strpos('a'.$referer,Url('user','login'))) {
        $referer = $default;
    }else{
        $referer = substr($referer, -1) == '?' ? substr($referer, 0, -1) : $referer;
    }
    return $referer;
}

function file_mode_info($file_path){
    if (!file_exists($file_path)){
        return false;
    }
    $mark = 0;
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){

        $test_file = $file_path . '/cf_test.txt';

        if (is_dir($file_path)){

            $dir = @opendir($file_path);
            if ($dir === false){
                return $mark;
            }
            if (@readdir($dir) !== false){
                $mark ^= 1;
            }
            @closedir($dir);
        }
    }
    return $mark;
}

function getAround($lat,$lon,$raidus){
    $PI = 3.14159265;
    $latitude = $lat;
    $longitude = $lon;
    $degree = (24901*1609)/360.0;
    $raidusMile = $raidus;
    $dpmLat = 1/$degree;
    $radiusLat = $dpmLat*$raidusMile;
    $minLat = $latitude - $radiusLat;
    $maxLat = $latitude + $radiusLat;
    $mpdLng = $degree*cos($latitude*($PI/180));
    $dpmLng = 1/$mpdLng;
    $radiusLng = $dpmLng*$raidusMile;
    $minLng = $longitude - $radiusLng;
    $maxLng = $longitude + $radiusLng;
    return array($minLat,$maxLat,$minLng,$maxLng);
}

function UserAgent(){    
    $user_agent = ( !isset($_SERVER['HTTP_USER_AGENT'])) ? FALSE : $_SERVER['HTTP_USER_AGENT'];    
	if ((preg_match("/(iphone|ipod|android)/i", strtolower($user_agent))) AND strstr(strtolower($user_agent), 'webkit')){    
    	return true;    
	}else if(trim($user_agent) == '' OR preg_match("/(nokia|sony|ericsson|mot|htc|samsung|sgh|lg|philips|lenovo|ucweb|opera mobi|windows mobile|blackberry)/i", strtolower($user_agent))){   
		return true;   
	}else{
		return true;  
	}    
}

function get_domain($host) {
    $host=strtolower($host);
    if(strpos($host,'/')!==false){
        $parse = @parse_url($host);
        $host = $parse['host'];
    }
    $topleveldomaindb=array('com','edu','gov','int','mil','net','org','biz','info','pro','name','museum','coop','aero','xxx','idv','mobi','cc','me'); $str='';
    foreach($topleveldomaindb as $v){
        $str.=($str ? '|' : '').$v;
    }
    $matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";
    if(preg_match("/".$matchstr."/ies",$host,$matchs)){
        $domain=$matchs['0'];
    } else{
        $domain=$host;
    }
    return $domain;
}
function yun_iconv($in_charset,$out_charset,$str){
    if(is_array($str)){
        foreach($str as $k=>$v){
            
              $str[$k]=iconv($in_charset,$out_charset,$v);
            
        }
        return $str;
    }else{
       
        return iconv($in_charset,$out_charset,$str);
       
    }    
}
function made_web($dir,$array,$config){
    $content="<?php \n";
    $content.="\$$config=".$array.";";
    $content.=" \n";
    $content.="?>";
    $fpindex=@fopen($dir,"w+");
    @fwrite($fpindex,$content);
    @fclose($fpindex);
}
function made_web_array($dir,$array){
	
	
    $content="<?php \n";
    if(is_array($array)){
        foreach($array as $key=>$v){
            if(is_array($v))
            {
                $content.="\$$key=array(";
                $content.=made_string($v);
                $content.=");";
            }else{
                $v = str_replace("'","\\'",$v);
                $v = str_replace("\"","'",$v);
                $v = str_replace("\$","",$v);
                $content.="\$$key=".$v.";";
            }
            $content.=" \n";
        }
    }
    $content.="?>";
    $fpindex=@fopen($dir,"w+");
    $fw=@fwrite($fpindex,$content);
    @fclose($fpindex);
    return $fw;
}
function made_string($array,$string=''){

	if(is_array($array) && !empty($array))
	{
	 $i = 0;
		foreach($array as $key=>$value)
		{
			if($i>0)
			{
				$string.=',';
			}
			if(is_array($value))
			{
				$string.="'".$key."'=>array(".made_string($value).")";
			}else{
				$string.="'".$key."'=>'".str_replace('\$','',iconv("UTF-8","gbk",$value))."'";
			}
			$i++;
		}
	}
   
    return $string;
}
function delfiledir($delfiles){
    $delfiles = stripslashes($delfiles);
    $delfiles = str_replace("../","",$delfiles);
    $delfiles = str_replace("./","",$delfiles);
    $delfiles = "../".$delfiles;
    $p_delfiles = path_tidy($delfiles);
    if($p_delfiles!=$delfiles)
    {
        die;
    }
    if(is_file($delfiles)){
        @unlink($delfiles);
    }else{
        $dh=@opendir($delfiles);
        while($file=@readdir($dh)){
            if($file!="."&&$file!=".."){
                $fullpath=$delfiles."/".$file;
                if(@is_dir($fullpath)){
                    delfiledir($fullpath);
                }else{
                    @unlink($fullpath);
                }
            }
        }
        @closedir($dh);
        if(@rmdir($delfiles)){
            return  true;
        }else{
            return false;
        }
    }
}
function path_tidy($path) {
    $tidy = array();
    $path = strtr($path, '\\', '/');
    foreach(explode('/', $path) as $i => $item) {
        if($item == '' || $item == '.' ) {
            continue;
        }
        if($item == '..' && end($tidy) != '..' && $i > 0) {
            array_pop($tidy);
            continue;
        }
        $tidy[] = $item;
    }
    return ($path[0]=='/'?'/':'').implode('/', $tidy);
}
function unlink_pic($pic){

    $pictype=getimagesize($pic);
    if($pictype[2]=='1' || $pictype[2]=='2' || $pictype[2]=='3'){
        @unlink($pic);
    }
}

function pylode($string,$array){
		
		if(is_array($array)){
			$str = @implode($string,$array);

		}else{
			$str = $array;
		}

		if(!preg_match("/^[0-9a-zA-Z".$string."]+$/",$str)){
			$str = 0;
		}
		return $str;
}

function getToken($config){
		
		$config = '';
		include(PLUS_PATH.'config.php');

		$Token = $config['token'];
		$TokenTime = $config['token_time'];
		$NowTime = time();
		if(($NowTime-$TokenTime)>7000 || !$Token){
			
			$Appid       = $config['wx_appid'];
			$Appsecert   = $config['wx_appsecret'];

			$Url         = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$Appid.'&secret='.$Appsecert;
			
			$CurlReturn  = CurlPost($Url);

			$Token       = json_decode($CurlReturn);
			
			$config['token']      = $Token->access_token;
			$config['token_time'] = time();
			
			made_web(PLUS_PATH."config.php",ArrayToString($config),"config");
			return $config['token'];
		}else{
			return $Token;
		}
	}

	function getWxTicket($config){
		
		$config = '';
		include(PLUS_PATH.'config.php');

		$Ticket = $config['ticket'];
		$TicketTime = $config['ticket_time'];
		$NowTime = time();
		if(($NowTime-$TicketTime)>7000 || !$Ticket){
			
			$Url         = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.getToken().'&type=jsapi';
			
			$CurlReturn  = CurlPost($Url);

			$Ticket       = json_decode($CurlReturn);
			
			$config['ticket']      = $Ticket->ticket;
			$config['ticket_time'] = time();
			
			made_web(PLUS_PATH."config.php",ArrayToString($config),"config");
			return $config['ticket'];
		}else{
			return $Ticket;
		}
	}

	function getWxJsSdk($url='') {
		
		include(PLUS_PATH.'config.php');
		$Ticket = getWxTicket();
		if(empty($url)){
			 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
			$url = $protocol.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
		}
		$timestamp = time();
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$nonceStr = "";
		for ($i = 0; $i < 16; $i++) {
		  $nonceStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}

		$string = "jsapi_ticket=".$Ticket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;

		$signature = sha1($string);

		$signPackage = array(
		  "appId"     => $config['wx_appid'],
		  "nonceStr"  => $nonceStr,
		  "timestamp" => $timestamp,
		  "url"       => $url,
		  "signature" => $signature,
		  "rawString" => $string
		);
		return $signPackage; 
   }

	function CurlPost($url,$data=''){
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
		if($data!=''){
			curl_setopt($ch, CURLOPT_POST, 1);
   			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$Return=curl_exec ($ch);
		if (curl_errno($url)) {
		   echo 'Errno'.curl_error($url);
		}
		curl_close($ch);
		
		return $Return;
	}
	function wapJump($config){
		global $ModuleName;
		
		$mArray = array('qqconnect','sinaconnect','call');
		$cArray = array('clickhits','wjump');
	
		if($config['sy_wap_jump']=='1' && !in_array($ModuleName,$mArray) && !in_array($_GET['c'],$cArray)){
		
			if(isMobileUser($config)){
				
				
				include(PLUS_PATH."jump.cache.php");
				
				if($_GET['c']){

					$_GET['a'] = $_GET['c'];

				}
				if($ModuleName && $ModuleName!='index'){

					$_GET['c'] = $ModuleName;
				
					if($wapA[$ModuleName][$_GET['a']]){

						$_GET['a'] = $wapA[$ModuleName][$_GET['a']];
					}
				}
				
				$Loaction =  Url('wap',$_GET);
			}
		}
		
		return $Loaction;
	}

	function isMobileUser($config=array()){
		
		$uachar = '/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i';
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		if((preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap') && $_SERVER['HTTP_HOST']!=$config['sy_wapdomain']){
			
			return true;
		
		}else{
			return false;
		}
	}

	function gtauthcode($config=array(),$type='pc'){
		
		if($_POST['geetest_challenge'] && $_POST['geetest_validate'] && $_POST['geetest_seccode']){
			
			if(!isset($_SESSION)){
				session_start();
			}
			require_once LIB_PATH . '/class.geetestlib.php';

			if(!$config){
				include(PLUS_PATH.'config.php');
			}
			$GtSdk = new GeetestLib($config['sy_geetestid'], $config['sy_geetestkey']);
			if($type=='mobile'){
				$data = array(
					"user_id" => $user_id,
					"client_type" => "h5",
					"ip_address" => "127.0.0.1"
				);
			}else{
				$data = array(
					"user_id" => $user_id,
					"client_type" => "web",
					"ip_address" => "127.0.0.1"
				);
				
			}
			

			$user_id = $_SESSION['user_id'];
			if ($_SESSION['gtserver'] == 1) {
				
				$result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
				if ($result) {
					return true;
				} else{
					return false;
				}
			}else{
				if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
					return true;
				}else{
					return false;
				}
			}
		
		}else{
			return false;
		}
		
	
	}

?>