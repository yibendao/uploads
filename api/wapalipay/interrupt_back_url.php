<?php
error_reporting(0);
//TODO:暂时不知道如何改成PLUS_PATH
require_once(dirname(dirname(dirname(__FILE__)))."/data/plus/config.php");
if(!($config['sy_wapdomain'])){
	$wapdomain=$config['sy_weburl'].'/'.$config['sy_wapdir'];
}else{
	$wapdomain=$config['sy_wapdomain'];
}
$Loaction=$wapdomain."/member/index.php?c=pay";
header("Location: $Loaction\n");exit;
?>