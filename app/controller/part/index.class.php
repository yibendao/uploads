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
class index_controller extends part_controller{
	function index_action(){
		$cache=$this->MODEL('cache')->GetCache(array('city','part'));
		$this->yunset($cache);
		if($_GET['city']){
		    $city=explode("_",$_GET['city']);
		    $_GET['provinceid']=$city[0];
		    $_GET['cityid']=$city[1];
		    $_GET['three_cityid']=$city[2];
		}
		if($this->config['province']){
			$_GET['provinceid'] = $this->config['province'];
		}
		if($this->config['cityid']){
		    $_GET['cityid'] = $this->config['cityid'];
		}
		if($this->config['three_cityid']){
		    $_GET['three_cityid'] = $this->config['three_cityid'];
		}
		if($_GET['part_type']){
			$search[]=$cache['partclass_name'][$_GET['part_type']];
		}
		if($_GET['cycle']){
			$search[]=$cache['partclass_name'][$_GET['cycle']];
		}
		if($_GET['provinceid']){
			$search[]=$cache['city_name'][$_GET['provinceid']];
		}
		if($_GET['cityid']){
		    $search[]=$cache['city_name'][$_GET['cityid']];
		}
		if($_GET['three_cityid']){
		    $search[]=$cache['city_name'][$_GET['three_cityid']];
		}
		if($_GET['keyword']){
			$search[]=$_GET['keyword'];
		}
		if(!empty($search)){
			$data['seacrh_class']=@implode("-",$search);
			$this->data=$data;
		}
        
        include PLUS_PATH."keyword.cache.php";
        if(is_array($keyword)){
          foreach($keyword as $k=>$v){
            if($v['type']=='2'&&$v['tuijian']=='1'){
              $partkeyword[]=$v;
            }
          }
        }
        $this->yunset("partkeyword",$partkeyword);
        
		$this->seo("part_index");
		$this->yun_tpl(array('index'));
	}
	function show_action(){
		include(CONFIG_PATH."db.data.php");		
		$this->yunset("arr_data",$arr_data);
		if($_GET['id']){
			$id=(int)$_GET['id'];
			$M=$this->MODEL("part");
			$job=$M->GetPartJobOne(array('id'=>$id));
			$job['sex']=$arr_data['sex'][$job['sex']];
			if($job['uid']!=$this->uid && ($job['id']==''||$job['state']==0||$job['state']==3)){  
				$this->ACT_msg($this->config['sy_weburl'],"该兼职暂无法展示！"); 
			} 
			$morning=array('0101','0201','0301','0401','0501','0601','0701');
			$noon=array('0102','0202','0302','0402','0502','0602','0702');
			$afternoon=array('0103','0203','0303','0403','0503','0603','0703');
			$this->yunset(array('morning'=>$morning,'noon'=>$noon,'afternoon'=>$afternoon));
			$job['worktime']=explode(',', $job['worktime']);
			$M->AddPartJobHits($id);
			if($this->usertype==1){
				$apply=$M->GetPartApplyOne(array("uid"=>$this->uid,"jobid"=>$id));
				$this->yunset("apply",$apply);
				$collect=$M->GetPartCollectOne(array("uid"=>$this->uid,"jobid"=>$id));
				$this->yunset("collect",$collect);
			}
			if(empty($apply)){
				$job['linktel']=substr_replace($job['linktel'],'*****',3,5);
			}
			$this->yunset("job",$job);
			$this->yunset($this->MODEL('cache')->GetCache(array('city','part')));
		}
		$data['part_name']=$job['name'];
		$this->data=$data;
		$this->seo("part_show");
		$this->yun_tpl(array('show'));
	}
}
?>