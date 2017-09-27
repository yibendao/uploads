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
class index_controller extends common{
	function index_action($set=""){

		global $db_config;
		$this->yunset("db_config",$db_config);
		$_POST=$this->post_trim($_POST); 
		if (!empty ($_POST['username']) && !empty ($_POST['password'])){
		    if(strpos($this->config['code_web'],'后台登录')!==false){
		       
				if($this->config['code_kind']==3){
					if(!gtauthcode($this->config)){
						$this->ACT_layer_msg("请点击按钮进行验证！",8,"index.php");
					}else{
		                $this->admin_get_user_login($_POST['username'], $_POST['password']);
		            }
		        }else{

					if(md5(strtolower($_POST['authcode']))===$_SESSION['authcode']){
						unset($_SESSION['authcode']);
						$this->admin_get_user_login($_POST['username'], $_POST['password']);
					}else{
						unset($_SESSION['authcode']);
						$this->ACT_layer_msg("验证码错误！",8,"index.php");
					}
		        }
		    }else{
				$this->admin_get_user_login($_POST['username'], $_POST['password']);
			}
		}

		$tpname=$this->admin_get_user_shell($_SESSION['auid'],$_SESSION['ashell'])? 'index':'login';
		if($tpname=="login"){

			$this->yuntpl(array('admin/'.$tpname));
			die;
		}

		$nav_user=$this->obj->DB_select_alls("admin_user","admin_user_group","a.`m_id`=b.`id` and a.`uid`='".$_SESSION['auid']."'");
		if($nav_user[0]['domain']!=""){
			$domain_arr=$nav_user[0]['domain'];
			$domain_arr=@explode(",",$domain_arr);
			$this->yunset("domain_arr",$domain_arr);
			if(in_array(0,$domain_arr)){
				$admin_domain=$this->obj->DB_select_all("domain","`type`='1'");
			}else{
				$admin_domain=$this->obj->DB_select_all("domain","`id` in ($domain_arr) and `type`='1'");
				if(!$_SESSION['domain'] && !$_SESSION['def_city'] && !$_SESSION['def_hy']){
					foreach($admin_domain as $v){
						if($v['cityid']>0){
							$cityid[]=$v['cityid'];
						}
						if($v['three_cityid']>0){
							$tcityid[]=$v['three_cityid'];
						}
						if($v['hy']>0){
							$hy[]=$v['hy'];
						}
					}
					$_SESSION['def_city']=@implode(",",$cityid);
					$_SESSION['def_tcity']=@implode(",",$tcityid);
					$_SESSION['def_hy']=@implode(",",$hy);
				}
			}

			$this->yunset("admin_domain",$admin_domain);
		}
		$power=unserialize($nav_user[0]['group_power']);
		$menurows=$this->obj->DB_select_all("admin_navigation","`display`<>1 and `id` in(".@implode(',',$power).") order by `sort` desc");
		$i=0;$j=0;$a=0;$b=0;
		if(is_array($menurows)){
			foreach($menurows as $key=>$v){
				if($v['keyid']==0 && @in_array($v['id'],$power)){
					$navigation[$i]['id']=$v['id'];
					$navigation[$i]['name']=$v['name'];
					$navigation[$i]['classname']=$v['classname'];
					$i++;
				}
				if($v['menu']==2){
					$menu[$j]['id']=$v['id'];
					$menu[$j]['keyid']=$v['keyid'];
					$menu[$j]['name']=$v['name'];
					$menu[$j]['classname']=$v['classname'];
					$menu[$j]['url']=$v['url'];
					$j++;
				}
			}
		}
		if(is_array($navigation)){
			foreach($navigation as $va){
				if(is_array($menurows)){
					foreach($menurows as $key=>$v){
						if($v['keyid']==$va['id']  && @in_array($v['id'],$power)){
							if(!is_array($one_menu[$va['id']]))$a=0;
							$one_menu[$va['id']][$a]['id']=$v['id'];
							$one_menu[$va['id']][$a]['name']=$v['name'];
							$one_menu[$va['id']][$a]['keyid']=$v['keyid'];
							$one_menu[$va['id']][$a]['menu']=$v['menu'];
							$a++;
							foreach($menurows as $key=>$vaa){
								if($vaa['keyid']==$v['id']  && @in_array($vaa['id'],$power)){
									if(!is_array($two_menu[$v['id']]))$b=0;
									$two_menu[$v['id']][$b]['id']=$vaa['id'];
									$two_menu[$v['id']][$b]['keyid']=$vaa['keyid'];
									$two_menu[$v['id']][$b]['name']=$vaa['name'];
									$two_menu[$v['id']][$b]['menu']=$vaa['menu'];
									$two_menu[$v['id']][$b]['url']=$vaa['url'];
									$b++;
								}
							}
						}
					}
				}
			}
		}
		if(is_array($navigation)){
			foreach($navigation as $v){
				$navigation_url_id[]=$v['id'];
			}

			$navigation_url=$this->GET_web_default($navigation_url_id,$power);
		}
		$this->yunset("one_menu",$one_menu);
		$this->yunset("two_menu",$two_menu);
		$this->yunset("navigation",$navigation);
		$this->yunset("navigation_url",$navigation_url);
		$this->yunset("menu",$menu);
		$this->yunset("ausername",$_SESSION['ausername']);
		$this->yunset("group_name",$nav_user[0]['group_name']);
		$this->yunset("nav_user",$nav_user[0]);
		$this->yunset("domainid",$_SESSION['domain']);
		if(!$set){
			$this->yuntpl(array('admin/'.$tpname));
		}
	}
	function logout_action(){
		$this->adminlogout();
		$this->layer_msg("您已成功退出！",9,0,"index.php");
	}
	function index_cache_action(){
        global $phpyun;
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('job','city','com','user','hy'));
        $this->yunset($CacheList);

		if($_SESSION["cityid"]){
			$this->seo("index",$_SESSION['webtitle'],$_SESSION['webkeyword'],$_SESSION['webmeta']);
            $CacheDomainList=$CacheM->GetCache(array('domain'));
            $site_domain=$CacheDomainList['site_domain'];
			if(is_array($site_domain)){
				foreach($site_domain as $d){
					if($d['cityid']==$_SESSION["cityid"]){
						$domain['tpl']=$d['tpl'];
					}
				}
			}
			if($domain['tpl']!=""){
				$tpl=@explode(".",$domain['tpl']);
                $contect = $phpyun->fetch(TPL_PATH.'default/index/'.$tpl[0].'.htm');
			}else{
                $contect = $phpyun->fetch(TPL_PATH.'default/index/index.htm');
			}
		}else{
			$this->seo("index");
            $contect = $phpyun->fetch(TPL_PATH.'default/index/index.htm');
		}
        $fp = fopen(APP_PATH.'news/'.$id.'.html', "w");
        $fw=fwrite($fp, $contect);
        fclose($fp);
		$fw?$this->obj->get_admin_msg("index.php?m=admin_right","生成成功！"):$this->obj->get_admin_msg("index.php?m=admin_right","生成失败！");
	}
	function del_cache_action(){
		$cache=$this->del_dir("../data/templates_c",1);
		$cache=$this->del_dir("../data/cache",1);
		if($cache==true){
			$this->layer_msg("更新成功！",9,0,"index.php");
		}else{
			$this->layer_msg("更新失败,请检查是否有权限！",8,0,"index.php");
		}
	}
	function map_action(){
		$this->index_action(1);
		$this->yuntpl(array('admin/admin_map'));
	}
	function topmenu_action(){
		$id=(int)$_GET['id'];
		if($id=="1000"){
			echo  "管理首页";
		}else{
			echo $this->GET_web_check($id);
		}
	}
	function shortcut_menu_action(){
		$tpname=$this->admin_get_user_shell($_SESSION['auid'],$_SESSION['ashell']);
		if($_POST['chk_value'] && is_array($tpname)){
			$this->obj->DB_update_all("admin_navigation","`menu`='1'","`menu`='2'");
			$this->obj->DB_update_all("admin_navigation","`menu`='2'","`id` in(".@implode(',',$_POST['chk_value']).")");
			echo 1;die;
		}else{
			$this->obj->get_admin_msg($this->config['sy_weburl'],"无权操作！");
		}
	}
	function site_action(){
		if($_POST['id']>0){
			$row=$this->obj->DB_select_once("domain","`id`='".$_POST[id]."'");
			if($row['fz_type']=="1"){
				$_SESSION['admin_city']=$row['cityid'];
				$_SESSION['admin_tcity']=$row['three_cityid'];
				unset($_SESSION['admin_hy']);
			}else{
				$_SESSION['admin_hy']=$row['hy'];
				unset($_SESSION['admin_city']);
				unset($_SESSION['admin_tcity']);
			}
			$_SESSION['domain']=$_POST['id'];
			unset($_SESSION['def_city']);
			unset($_SESSION['def_tcity']);
			unset($_SESSION['def_hy']);
		}else{
			unset($_SESSION['admin_city']);
			unset($_SESSION['admin_tcity']);
			unset($_SESSION['admin_hy']);
			unset($_SESSION['domain']);
		}
	}

}
?>