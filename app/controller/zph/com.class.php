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
class com_controller extends zph_controller{ 
	function index_action(){ 
		$this->Zphpublic_action();
		$id=(int)$_GET['id'];
		$M=$this->MODEL('zph');
		$Job=$this->MODEL('job');
		$UserinfoM=$this->MODEL('userinfo');
		$row=$M->GetZphOnce(array("id"=>$id)); 
		if($row['id']==''){
			$this->ACT_msg(url("zph"),"没有找到该招聘会！");
		}
		$urlarr["c"]=$_GET['c'];
		$urlarr["id"]=$id;
		$urlarr["page"]="{{page}}";
		$pageurl=Url('zph',$urlarr,"1");
		$rows=$this->get_page("zhaopinhui_com","`zid`='".$id."' and status='1'  order by id desc",$pageurl,"13");
		if(is_array($rows)&&$rows){
			$space=$this->obj->DB_select_all("zhaopinhui_space");
			$spacearr=array();
			foreach($space as $val){
				$spacearr[$val['id']]=$val['name'];
			}
			foreach($rows as $v){
				$uid[]=$v['uid'];
			}	 
			$com=$M->GetZphComInfo($UserinfoM,array("uid in(".@implode(",",$uid).")"),array("field"=>"`uid`,name"));		
			foreach($rows as $key=>$v){
				foreach($com as $val){
					if($v['uid']==$val['uid']){
						$rows[$key]['comname']=$val['name'];
						if($val['comtpl'] && $val['comtpl']!="default"){
							$rows[$key]['url']=Url('company',array("id"=>$v[uid]))."#job";
						}else{
							$rows[$key]['url']=Url('company',array("id"=>$v[uid]));
						}
					}
				}   
				$rows[$key]['job']=$Job->GetComjobList(array("`id` in (".$v['jobid'].") and `uid`='".$v['uid']."' and `status`<>'1' and `r_status`<>'2'"),array('field'=>"name,id")); 
			}
		}
		if($row['starttime']<time()){
			$row['isend']=1;
		} 
		$this->yunset("spacearr",$spacearr);
		$this->yunset('rows',$rows);
		$this->yunset("row",$row);
		$data['zph_title']=$row['title'];
		$data['zph_desc']=$this->GET_content_desc($row['body']);
		$this->data=$data;
		$this->seo("zph_com");
		$this->zph_tpl('zphcom'); 
	} 
}
?>