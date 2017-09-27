<?php
function smarty_function_sign($paramer,$template){ 
	global $db,$db_config,$config;
	$date=date("Ymd"); 
	$reg=$db->DB_select_once("member_reg","`uid`='".(int)$_COOKIE['uid']."' and `usertype`='".(int)$_COOKIE['usertype']."' and `date`='".$date."'"); 
	
	$arr=array();
	$allreg=$db->select_all("member_reg","`uid`='".(int)$_COOKIE['uid']."' and `usertype`='".(int)$_COOKIE['usertype']."' order by `id` desc limit 32");	
	
	if($allreg&&is_array($allreg)){
		$alldate=array();
		foreach($allreg as $val){
			$alldate[]=$val['date'];
		}
	}
	$date=date("Ymd"); 
	$year=date('Y');
	$month=date('m');
	if($month>12){
		$month=1;
		$year+=1;
	}
	$currentDate=$year."年".$month."月";//当前得到的日期信息
	$days = date("t",mktime(0,0,0,$month,1,$year));//得到给定的月份应有的天数
	$dayofweek = date("w",mktime(0,0,0,$month,1,$year));//得到给定的月份的 1号 是星期几 
	if($reg['id']){
		$ahtml='<a href="javascript:void(0)"  class="left_box_zp_qd  yqd" >今日已签到</a>';
	}else{
		$ahtml='<a href="javascript:void(0)"  class="left_box_zp_qd">签到赚'.$config['integral_pricename'].'</a>';
	}
	$html='<div class="signdiv">'.$ahtml.'<div class="sign_main" id="sign_layer">
		<div class="sign_succ_calendar_title">
		<div class="calendar_month_span">'.$currentDate.'</div>
		</div>
		<div class="sign" id="sign_cal"><table><tr><th>日</th><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th></tr>';
	
	$html.="<tr>";		
	$nums=$dayofweek+1;
	for ($i=1;$i<=$dayofweek;$i++){//输出1号之前的空白日期
		$html.="<td>&nbsp;</td>";
	}  
	for ($i=1;$i<=$days;$i++){//输出天数信息 
		if($i<10){
			$ndays=$year.$month.str_pad($i,2,'0',STR_PAD_LEFT);
		}else{
			$ndays=$year.$month.$i;
		}
		if(in_array($ndays,$alldate)){
			$class='on';
		}else{$class='';}
		if ($nums%7==0){//换行处理：7个一行
			$html.='<td class="day'.$i.' '.$class.'">'.$i.'</td></tr><tr>';
		}else{
			$html.='<td class="day'.$i.' '.$class.'">'.$i.'</td>';
		}
		$nums++;
	}
	$html.="</tr></table></div></div></div>"; 
	return $html;
}
?>