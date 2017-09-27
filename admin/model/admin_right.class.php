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
class admin_right_controller extends common
{
	function index_action(){
		global $db_config;
		include(APP_PATH.'version.php');
		$this->yunset("version",$version);

		$this->yunset("db_config",$db_config);
		$base=base64_encode($db_config["coding"]."|phpyun|".$this->config["sy_webname"]."|phpyun|".$this->config["sy_weburl"]."|phpyun|".$this->config["sy_webemail"]."|phpyun|".$version);
		$this->yunset("base",$base);
		$nav_user=$this->obj->DB_select_alls("admin_user","admin_user_group","a.`m_id`=b.`id` and a.`uid`='".$_SESSION['auid']."'");
		$soft=$_SERVER['SERVER_SOFTWARE'];
		$kongjian=round(@disk_free_space(".")/(1024*1024),2);
		$banben=$this->db->mysql_server(1);
		$yonghu=@get_current_user();
		$server=$_SERVER['SERVER_NAME'];
		$today=strtotime(date("Y-m-d 00:00:00"));
		$comcert=$this->obj->DB_select_num("company_cert","`type`='3' and `status`='0'");
		$company_job=$this->obj->DB_select_num("company_job","`state`='0'",'id');
		$statusmember=$this->obj->DB_select_all("member","`status`=0 and `usertype`=2","`uid`");
		if(!empty($statusmember)){
			foreach($statusmember as $value){
				$stuids[] = $value['uid'];
			}
			$company = $this->obj->DB_select_num("company","`uid` IN (".@implode(',',$stuids).")");
		}else{
			$company = 0;
		}
		$once_job=$this->obj->DB_select_num("once_job","`status`='0' and `edate`>'".time()."'");
		$admin_link=$this->obj->DB_select_num("admin_link","`link_state`='0' ");
		$company_order=$this->obj->DB_select_num("company_order","`order_state`='3'");
		$comproduct=$this->obj->DB_select_num("company_product","`status`='0' ");
		$comnews=$this->obj->DB_select_num("company_news","`status`='0' ");
		
		if(is_dir("../admin"))$dirname[]="admin";
		if(is_dir("../install"))$dirname[]="install";
		$this->yunset("dirname",@implode(',',$dirname));
		$mruser=$nav_user[0]['username']=="admin" && $nav_user[0]['password']==md5('admin')?1:0;

		
		$this->yunset("comproduct",$comproduct);
		$this->yunset("comnews",$comnews);
		$this->yunset("mruser",$mruser);
		$this->yunset("comcert",$comcert);
		$this->yunset("company_job",$company_job);
		$this->yunset("company",$company);
		$this->yunset("once_job",$once_job);
		$this->yunset("admin_link",$admin_link);
		$this->yunset("company_order",$company_order);
		$this->yunset("soft",$soft);
		$this->yunset("kongjian",$kongjian);
		$this->yunset("banben",$banben);
		$this->yunset("yonghu",$yonghu);
		$this->yunset("server",$server);
		$this->yunset("nav_user",$nav_user[0]);

		$power=unserialize($nav_user[0]['group_power']);
		$menurows=$this->obj->DB_select_all("admin_navigation","`id` in (".@implode(",",$power).")","`url`");
		if(is_array($menurows)){
			foreach($menurows as $v){
				$url[]=$v['url'];
			}
		}
		$this->yunset("url",$url);
		$this->yuntpl(array('admin/admin_right'));
	}
	function getweb_action(){
		$this->tj("member",array('reg_date','login_date'),array('个人注册','个人登录'),"usertype=1 and ");
	}
	function comtj_action(){
		$this->tj("member",array('reg_date','login_date'),array('企业注册','企业登录'),"usertype=2 and");
	}
	function resumetj_action(){
		$this->tj("resume_expect",array('ctime','lastupdate'),array('简历新增','简历刷新'));
	}
	function newstj_action(){
		$this->tj("news_base",array('datetime'),array('新闻新增'));
	}
	function adtj_action(){
		$this->tj("adclick",array('addtime'),array('广告点击统计'));
	}
	function jobtj_action(){
		$this->tj("company_job",array('sdate','lastupdate'),array('职位新增','职位刷新'));
	}
	function wzptj_action(){
		$this->tj("once_job",array('ctime','sxtime'),array('店铺招聘新增','店铺招聘刷新'));
	}
	function wjltj_action(){
		$this->tj("resume_tiny",array('time','lastupdate'),array('普工简历新增','普工简历刷新'));
	}
	function payordertj_action(){
		$this->tj("company_order",array('order_time'),array('充值统计'));
	}
   
	function tj($tablename,$field=array(),$name=array(),$where=''){
	    $TimeDate = $this->day();
	    $sdate = $TimeDate['sdate'];
	    $edate = $TimeDate['edate'];
	    $days = $TimeDate['days'];
	    if ($field[0]){
	        $RegWhere = $where." $field[0] >= ".strtotime($sdate)." AND $field[0] <= ".strtotime($edate.' 23:59:59');
	        $RegStats = $this->obj->DB_select_all($tablename," $RegWhere GROUP BY td ORDER BY td DESC","FROM_UNIXTIME(`$field[0]`,'%Y%m%d') as td,count(*) as cnt");
	        if(is_array($RegStats)){
	            $AllNum = 0;
	            foreach($RegStats as $key=>$value){
	                $AllNum +=$value['cnt'];
	                $Date[$value['td']] = $value;
	            }
	            if($days>0){
	                for($i=0;$i<=$days;$i++){
	                    $onday = date("Ymd", strtotime(' -'. $i . 'day'));
	                    $td    = date('m-d', strtotime(' -'. $i . 'day'));
	                    $date    = date('Y-m-d', strtotime(' -'. $i . 'day'));
	                    if(!empty($Date[$onday])){
	                        $Date[$onday]['td'] = $td;
	                        $Date[$onday]['date'] = $date;
	                        $List[$onday] = $Date[$onday];
	                    }else{
	                        $List[$onday] = array('td'=>$td,'cnt'=>0,'date'=>$date);
	                    }
	                }
	            }
	        }
	        ksort($List);
	    }
	    if ($field[1]){
	        $loginWhere = $where." $field[1] >= ".strtotime($sdate)." AND $field[1] <= ".strtotime($edate.' 23:59:59');
	        $loginStats = $this->obj->DB_select_all($tablename," $loginWhere GROUP BY td ORDER BY td DESC","FROM_UNIXTIME(`$field[1]`,'%Y%m%d') as td,count(*) as cnt");
	        if(is_array($loginStats)){
	            $twoNum = 0;
	            foreach($loginStats as $key=>$val){
	                $twoNum +=$val['cnt'];
	                $twodate[$val['td']] = $val;
	            }
	            if($days>0){
	                for($j=0;$j<=$days;$j++){
	                    $onday = date("Ymd", strtotime(' -'. $j . 'day'));
	                    $td    = date('m-d', strtotime(' -'. $j . 'day'));
	                    $date    = date('Y-m-d', strtotime(' -'. $j . 'day'));
	                    if(!empty($twodate[$onday])){
	                        $twodate[$onday]['td'] = $td;
	                        $twodate[$onday]['date'] = $date;
	                        $twolist[$onday] = $twodate[$onday];
	                    }else{
	                        $twolist[$onday] = array('td'=>$td,'cnt'=>0,'date'=>$date);
	                    }
	                }
	            }
	        }
	        ksort($twolist);
	    }
	    $this->yunset('twolist',$twolist);
	    $this->yunset('list',$List);
	    $this->yunset('name',$name);
	    $this->yunset('type',"tj");
	    $this->yuntpl(array('admin/admin_right_web'));
	}
	function downresumedt_action(){
		$this->dt("down_resume","downtime","下载简历动态","1 order by downtime desc");
	}
	function lookjobdt_action(){
		$this->dt("look_job","datetime","职位浏览动态","1 order by datetime desc");
	}
	function lookresumedt_action(){
		$this->dt("look_resume","datetime","简历浏览动态","1 order by datetime desc");
	}
	function useridjobdt_action(){
		$this->dt("userid_job","datetime","职位申请动态","1 order by datetime desc");
	}
	function favjobdt_action(){
		$this->dt("fav_job","datetime","职位收藏动态","1 order by datetime desc");
	}		
	function payorderdt_action(){
		$this->dt("company_order","order_time","充值动态","1 order by order_time desc");
	}	
	function dt($tablename,$field,$name,$where=1){
		$List = $this->obj->DB_select_all($tablename,$where." limit 20");
		if(is_array($List)){
			foreach($List as $v){									
				$uid[]=$v['uid'];	
				$comid[]=$v['comid'];
				$com_id[]=$v['com_id'];		
				$jobid[]=$v['jobid'];	
			}			
			$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$comid).")");	
			$member2=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")");
			$member3=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$com_id).")");
			$resume=$this->obj->DB_select_all("resume","`uid` in (".@implode(",",$uid).")");	
			$job=$this->obj->DB_select_all("company_job","`id` in (".@implode(",",$jobid).")");	
			foreach($List as $k=>$v){
				foreach($resume as $val){
					if($v['uid']==$val['uid']){
						$List[$k]['username']=$val['name'];
					}
				}
				foreach($job as $val){
					if($v['jobid']==$val['id']){
						$List[$k]['jobname']=$val['name'];
					}
				}
				foreach($member as $val){					
					if($v['comid']==$val['uid']){
						$List[$k]['comusername']=$val['username'];												
					}					
				}
				foreach($member2 as $val){					
					if($v['uid']==$val['uid']){
						$List[$k]['username']=$val['username'];						
					}					
				}
				foreach($member3 as $val){					
					if($v['com_id']==$val['uid']){
						$List[$k]['comusername']=$val['username'];												
					}					
				}	
							
				$time=time()-$v['downtime'];
				if($time>86400 && $time<604800){
					$List[$k]['time'] = ceil($time/86400)."天前";
				}elseif($time>3600 && $time<86400){
					$List[$k]['time'] = ceil($time/3600)."小时前";
				}elseif($time>60 && $time<3600){
					$List[$k]['time'] = ceil($time/60)."分钟前";
				}elseif($time<60){
					$List[$k]['time'] = "刚刚";
				}else{
					$List[$k]['time'] = date("Y-m-d",$v['downtime']);
				}
				
				$times=time()-$v['datetime'];
				if($times>86400 && $times<604800){
					$List[$k]['times'] = ceil($times/86400)."天前";
				}elseif($times>3600 && $times<86400){
					$List[$k]['times'] = ceil($times/3600)."小时前";
				}elseif($times>60 && $times<3600){
					$List[$k]['times'] = ceil($times/60)."分钟前";
				}elseif($times<60){
					$List[$k]['times'] = "刚刚";
				}else{
					$List[$k]['times'] = date("Y-m-d",$v['datetime']);
				}
				
				$timess=time()-$v['order_time'];
				if($timess>86400 && $timess<604800){
					$List[$k]['timess'] = ceil($timess/86400)."天前";
				}elseif($timess>3600 && $timess<86400){
					$List[$k]['timess'] = ceil($timess/3600)."小时前";
				}elseif($timess>60 && $timess<3600){
					$List[$k]['timess'] = ceil($timess/60)."分钟前";
				}elseif($timess<60){
					$List[$k]['timess'] = "刚刚";
				}else{
					$List[$k]['timess'] = date("Y-m-d",$v['order_time']);
				}			
			}
		}		
		$this->yunset('list',$List);
		$this->yunset('name',$name);
		$this->yunset('type',"dt");
		$this->yuntpl(array('admin/admin_right_web'));
	}
	
	function userrz_action(){
		$this->rz("member_log","ctime","个人会员日志","usertype=1 order by ctime desc");
	}
	function comrz_action(){
		$this->rz("member_log","ctime","企业会员日志","usertype=2 order by ctime desc");
	}
	
	
	function rz($tablename,$field,$name,$where=1){
		$List = $this->obj->DB_select_all($tablename,$where." limit 20");		
		if(is_array($List)){
			foreach($List as $v){			
				$uid[]=$v['uid'];		
			}			
			$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","username,uid");			
			foreach($List as $k=>$v){
				foreach($member as $val){
					if($v['uid']==$val['uid']){
						$List[$k]['username']=$val['username'];
					}					
				}
				$time=time()-$v['ctime'];
				if($time>86400 && $time<604800){
					$List[$k]['time'] = ceil($time/86400)."天前";
				}elseif($time>3600 && $time<86400){
					$List[$k]['time'] = ceil($time/3600)."小时前";
				}elseif($time>60 && $time<3600){
					$List[$k]['time'] = ceil($time/60)."分钟前";
				}elseif($time<60){
					$List[$k]['time'] = "刚刚";
				}else{
					$List[$k]['time'] = date("Y-m-d",$v['ctime']);
				}
			}
		}				
		$this->yunset('list',$List);		
		$this->yunset('name',$name);
		$this->yunset('type',"rz");
		$this->yuntpl(array('admin/admin_right_web'));
	}
	function downresumedthy_action(){
	    $this->hy("down_resume","downtime",'company');
	}
	function lookjobdthy_action(){
	    $this->hy("look_job","datetime",'member');
	}
	function lookresumedthy_action(){
	    $this->hy("look_resume","datetime",'company');
	}
	function useridjobdthy_action(){
	    $this->hy("userid_job","datetime",'member');
	}
	function favjobdthy_action(){
	    $this->hy("fav_job","datetime",'member');
	}
	function payorderdthy_action(){
	    $this->hy("company_order","order_time");
	}
	function userrzhy_action(){
	    $this->hy("member_log","ctime",'member'," and usertype=1");
	}
	function comrzhy_action(){
	    $this->hy("member_log","ctime",'company'," and usertype=2");
	}
	
	function hy($tablename,$field,$tablename2,$swhere=''){
	    $date = date('Y-m-d');
	    $where=" $field >= ".strtotime($date.' 00:00:01')." AND $field <= ".strtotime($date.' 23:59:59').$swhere;
	    $List = $this->obj->DB_select_all($tablename,$where);
	    $html="<div><div>今日操作总数：".count($List)."</div>  ";
	    if ($tablename=='down_resume'||$tablename=='look_resume'||$tablename=='company_order'){
	        if ($tablename=='down_resume'){
	            foreach ($List as $v){
	                $uid[]=$v['comid'];
	            }
	        }elseif ($tablename=='look_resume'){
	            foreach ($List as $v){
	                $uid[]=$v['com_id'];
	            }
	        }else{
	            foreach ($List as $v){
	                $uid[]=$v['uid'];
	            }
	        }
	        $huoyue=$this->getMostElements($uid);
	    	$member=$this->obj->DB_select_once('member',"`uid`=".$huoyue[0]."","`uid`,`username`,`usertype`");
	        if ($member['usertype']==2){
	            $com=$this->obj->DB_select_once('company',"`uid`=".$member['uid']."","`name`");
	            if ($com){
	                $html.="<span>活跃会员：".substr($com['name'],0,20)."</span>";
	            }
	        }elseif ($member['usertype']==1){
	            $html.="<span>活跃会员：".substr($member['username'],0,20)."</span>";
	        }
	    }elseif ($tablename=='userid_job'||$tablename=='look_job'||$tablename=='fav_job'){
	        foreach ($List as $v){
	            $uid[]=$v['uid'];
	        }
	        $huoyue=$this->getMostElements($uid);
	        $com=$this->obj->DB_select_once($tablename2,"`uid`=".$huoyue[0]."","`username`");
	        if ($com){
	            $html.="<span>活跃会员：".substr($com['username'],0,20)."</span>";
	        }
	    }elseif ($tablename=='member_log'){
	        foreach ($List as $v){
	            $uid[]=$v['uid'];
	        }
	        $huoyue=$this->getMostElements($uid);
	        if ($tablename2=='member'){
	            $com=$this->obj->DB_select_once($tablename2,"`uid`=".$huoyue[0]."","`username`");
	            if ($com){
	                $html.="<span>活跃会员：".substr($com['username'],0,20)."</span>";
	            }
	        }else{
	            $com=$this->obj->DB_select_once($tablename2,"`uid`=".$huoyue[0]."","`name`");
	            if ($com){
	                $html.="<span>活跃会员：".substr($com['name'],0,20)."</span>";
	            } 
	        }
	    }
	    $html.="</div>";
	    echo $html;
	}
	
	function getMostElements($arr) {
	    $arr = array_count_values($arr);
	    asort($arr);
	
	    $findNum =  end($arr);
	    foreach ($arr as $k => $v) {
	        if ($v != $findNum) {
	            unset($arr[$k]);
	        }
	    }
	    return array_keys($arr);
	}
	
	function day(){
		if((int)$_GET['days']>0){
			$days = (int)$_GET['days'];
			$sdate = date('Y-m-d',(time()-$days*86400));
			$edate = date('Y-m-d');
		}elseif($_GET['sdate']){
			$sdate = $_GET['sdate'];
			$days = ceil(abs(time() - strtotime($sdate))/86400);
			if($_GET['edate']){
				$edate = $_GET['edate'];
				$days = ceil(abs(strtotime($edate) - strtotime($sdate))/86400);			
			}
		}else{
			$days = 30;
			$sdate = date('Y-m-d',(time()-$days*86400));
			$edate = date('Y-m-d');
		}
		return array('sdate'=>$sdate,'days'=>$days,'edate'=>$edate);
	}
}
?>