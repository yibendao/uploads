<?php

define('WEBSCAN_API_LOG_T', 'http://safe.webscan.360.cn/papi/log');
define('WEBSCAN_UPDATE_FILE_T','http://safe.webscan.360.cn/papi/update');
$webscan_switch=1;
$webscan_post=1;
$webscan_get=1;
$webscan_cookie=1;
$webscan_referre=1;
$webscan_white_directory='admin|\/dede\/|\/install\/';
$webscan_white_url = array('index.php' => 'admin_dir=admin','post.php' => 'job=postnew&step=post','edit_space_info.php'=>'');
?>