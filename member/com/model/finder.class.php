<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2017 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class finder_controller extends company{
	function index_action(){
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);
		$this->yunset("arr_data",$arr_data);
		$finder=$this->obj->DB_select_all("finder","`uid`='".$this->uid."' order  by `id` desc");
		if($finder&&is_array($finder)){
			include PLUS_PATH."/user.cache.php";
			include PLUS_PATH."/job.cache.php";
			include PLUS_PATH."/industry.cache.php";
			include PLUS_PATH."/city.cache.php";

			$uptime=array('1'=>'今天',"3"=>'最近三天','7'=>'最近七天','30'=>'最近一个月',"90"=>'最近三个月');
			$adtime=array('1'=>'一天内',"3"=>'三天内','7'=>'七天内',"15"=>'十五天内','30'=>'一个月内',"60"=>'两个月内');


			foreach($finder as $key=>$val){
				$arr=$findername=array();
				$para=@explode('##',$val['para']);
				$arr['m']='resume';
				$arr['c']='list';
				foreach($para as $val){
					$parav=@explode('=',$val);
					$arr[$parav[0]]=$parav[1];
				}
				if($arr['jobids']){
					$jobids=@explode(',',$arr['jobids']);
					foreach($jobids as $val){
						$jobname[]=$job_name[$val];
					}
					$findername[]=@implode('、',$jobname);
				} 
				if($arr['keyword']){$findername[]=$arr['keyword'];}
				if($arr['hy']){$findername[]=$industry_name[$arr['hy']];}
				if($arr['job1']){$findername[]=$job_name[$arr['job1']];}
				if($arr['job1_son']){$findername[]=$job_name[$arr['job1_son']];}
				if($arr['job_post']){$findername[]=$job_name[$arr['job_post']];}
				if($arr['adtime']){$findername[]=$adtime[$arr['adtime']];}
				if($arr['edu']){$findername[]=$userclass_name[$arr['edu']];}
				if($arr['word']){$findername[]=$userclass_name[$arr['word']];}
				if($arr['uptime']){$findername[]=$uptime[$arr['uptime']];}
				
				if($arr['minsalary']&&$arr['maxsalary']){
					$findername[]='￥'.$arr['minsalary'].'-'.$arr['maxsalary'];
				}elseif($arr['maxsalary']){
					$findername[]='￥'.$arr['maxsalary'].'以下';
				}elseif ($arr['minsalary']){
					$findername[]='￥'.$arr['minsalary'].'以上';
				}
				if($arr['type']){$findername[]=$userclass_name[$arr['type']];}
				if($arr['provinceid']){$findername[]=$city_name[$arr['provinceid']];}
				if($arr['cityid']){$findername[]=$city_name[$arr['cityid']];}
				if($arr['three_cityid']){$findername[]=$city_name[$arr['three_cityid']];}
				if($arr['exp']){$findername[]=$userclass_name[$arr['exp']];}
				if($arr['sex']){$findername[]=$arr_data['sex'][$arr['sex']];}
				
				$finder[$key]['findername']=@implode('+',array_filter($findername));
				$_GET=$arr;
				$finder[$key]['url']=searchListRewrite($arr,$this->config);
			}
		}
		if($this->config['com_finder']>count($finder)){
			$this->yunset("addnew",'1');
		}

		$this->yunset('config_com_finder_num',$this->config['com_finder']);

		$this->yunset("js_def",5);
		$this->public_action();
		$this->yunset("finder",$finder);
		$this->com_tpl('finder');
	}
	function edit_action(){
		include(CONFIG_PATH."db.data.php");
		unset($arr_data['sex'][3]);		
		$this->yunset("arr_data",$arr_data);
        $result=$this->MODEL('cache')->GetCache(array('hy','job','user','city'));
        $this->yunset($result);

		if($_GET['id']){
			$info=$this->obj->DB_select_once("finder","`uid`='".$this->uid."' and `id`='".(int)$_GET['id']."'");
			
			if($info['para']){
				$para=@explode('##',$info['para']);
				foreach($para as $val){
					$arr=@explode('=',$val);
					$parav[$arr['0']]=$arr['1'];
				}
				if($parav['jobids']){
					$jobids=@explode(',',$parav['jobids']);
					foreach($jobids as $val){
						$jobname[]=$result['job_name'][$val];
					}
					$parav['jobname']=@implode(',',$jobname);
				} 
				$this->yunset("parav",$parav);
			} 
			$this->yunset("info",$info); 
			$this->public_action();

		}
		$uptime=array('1'=>'今天',"3"=>'最近三天','7'=>'最近七天','30'=>'最近一个月',"90"=>'最近三个月');
		$adtime=array('1'=>'一天内',"3"=>'三天内','7'=>'七天内',"15"=>'十五天内','30'=>'一个月内',"60"=>'两个月内');

		$this->yunset("adtime",$adtime);
		$this->yunset("uptime",$uptime);
		$this->public_action();
		$this->yunset("js_def",5);
		$this->com_tpl('finderinfo');
	}
	function save_action()
	{
		if($_POST['submitBtn'])
		{
			$num=$this->obj->DB_select_num('finder',"`uid`='".$this->uid."'");
			if($_POST['id']==""){
				if($num>=$this->config['com_finder'])
				{
					$this->ACT_layer_msg("已达到最大搜索器数量！",8,"index.php?c=finder");
				}
				$msg='添加';
			}else{
				$msg='更新';
			}
			
			$post=$this->post_trim($_POST);
			$id=(int)$post['id'];
			$cycle=(int)$post['cycle'];
			$job_num=(int)$post['job_num'];
			$name=$post['name'];
 			unset($post['id']);
			unset($post['submitBtn']);
			unset($post['name']);
			foreach($post as $key=>$val){
				if(trim($val)){
					$para[]=$key."=".$val;
				}
			}
			$paras=@implode('##',$para);
			if($paras=="")
			{
				$this->ACT_layer_msg("搜索器内容不能为空必须任意选一项!",8,$_SERVER['HTTP_REFERER']);
			}
		
			$result=$this->insertfinder($paras,$id,$name,1);
			$result?$this->ACT_layer_msg("信息".$msg."成功！",9,"index.php?c=finder"):$this->ACT_layer_msg("信息".$msg."失败！",8,"index.php?c=finder");
		}
	}
	function del_action(){
		if($_GET['id']){
			$this->obj->member_log("删除搜索器");
			$res=$this->obj->DB_delete_all("finder","`id`='".(int)$_GET['id']."' and `uid`='".$this->uid."'");
			$res?$this->layer_msg("删除成功！",9,0):$this->layer_msg("删除失败！",8,0);
		}
	}
}
?>