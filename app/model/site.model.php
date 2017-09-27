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
class site_model extends model{
	
	function GetSiteDomian($keyword,$id='1'){
       $Site = $this->DB_select_all("domain","`title` LIKE '%".iconv("utf-8","gbk",$_POST['keyword'])."%'");
		if(is_array($Site) && !empty($Site)){
			if($id=='2'){
				$didtype = 'domain';
			}else{
				$didtype = 'did';
			}
			foreach($Site as $value){
				
				$siteHtml .='<div class="yun_admin_select_box_list"> <a href="javascript:;" onClick="select_new(\''.$didtype.'\',\''.$value['id'].'\',\''.$value['title'].'\')">'.$value['title'].'</a> </div>';
			}
			echo $siteHtml;
		}else{
			return 1;
		}
    }
	
    function UpDid($Table=array(),$Did,$Where){		
		foreach($Table as $value){		
			$this->DB_update_all($value,"`did`='".$Did."'",$Where);
		}        
    }	
}
?>