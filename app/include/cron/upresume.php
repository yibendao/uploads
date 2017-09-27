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
global $db_config,$db;


$query = $db->query("SELECT r1.id FROM $db_config[def]resume_expect AS r1 JOIN (SELECT ROUND(RAND() * (SELECT MAX(id) FROM $db_config[def]resume_expect)) AS id) AS r2 WHERE r1.id >= r2.id  AND status<>'2' AND `r_status`<>'2' AND `job_classid`<>'' AND `open`='1' AND `defaults`='1' AND exp>0 AND edu>0  ORDER BY r1.id ASC LIMIT 30");

while($rs = $db->fetch_array($query))
{
	
	$LastTime = strtotime('-'.rand(1,59).' minutes', time());

	$db->update_all("resume_expect","`lastupdate`='".$LastTime."'","`id`='".$rs['id']."'");
}


?>