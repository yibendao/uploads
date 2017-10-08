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
class model{
    const MODEL_INSERT          =   1;      
    const MODEL_UPDATE          =   2;
    const MODEL_BOTH            =   3;
    const MUST_VALIDATE         =   1;
    const EXISTS_VALIDATE       =   0;
    const VALUE_VALIDATE        =   2;

    protected $config           =   null;
    protected $db               =   null;
    protected $pk               =   'id';
    protected $autoinc          =   false;
    protected $def      =   null;
    protected $name             =   '';
    protected $coding             =   '';
    protected $dbName           =   '';
    protected $connection       =   '';
    protected $tableName        =   '';
    protected $trueTableName    =   '';
    protected $error            =   '';
    protected $fields           =   array();
    protected $data             =   array();
    protected $options          =   array();
    protected $_validate        =   array(); 
    protected $_auto            =   array();
    protected $_map             =   array();
    protected $_scope           =   array();
    protected $autoCheckFields  =   true;
    protected $patchValidate    =   false;
    protected $methods          =   array('order','alias','having','group','lock','distinct','auto','filter','validate','result','token');
    protected $sitetable=array('ad','ad_order','admin_announcement','zhaopinhui','zhaopinhui_com','zhaopinhui_pic','news_base','news_content','resume_expect','member','company_job','resume','user_entrust','user_entrust_record','down_resume','look_resume','company','company_cert','company_msg','company_news','company_order','company_pay','company_product','once_job','resume_tiny','userid_msg','userid_job','look_job','admin_link','report','company_statis','partjob','hotjob');

	protected $admindir;
	protected $siteadmindir;
	protected $logininfo;

	public function __construct($db,$def,$logininfo){
		global $coding,$config,$adminDir,$siteAdminDir;

		$this->db = $db;
		$this->tp = $tp;
		$this->def = $def;
		$this->md = $coding;
        $this->config = $config;
		$this->uid = $logininfo['uid'];
		$this->username = $logininfo['username'];
		$this->usertype = $logininfo['usertype'];
		$this->admindir = $adminDir;
		$this->siteadmindir = $siteAdminDir;
		
		if(!($this->config['sy_wapdomain'])){
			
			$this->config['sy_wapdomain'] = $this->config['sy_weburl'].'/'.$this->config['sy_wapdir'];
		}else{
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';

			if(strpos($this->config['sy_wapdomain'],$protocol)===false)
			{
				$this->config['sy_wapdomain'] = $protocol.$this->config['sy_wapdomain'];
			}
		}
		if($adminDir||!$siteAdminDir){
			$this->sitetable = array();
		} 
	}

    public function __set($name,$value) {
        $this->data[$name]  =   $value;
    }

    public function __get($name) {
        return isset($this->data[$name])?$this->data[$name]:null;
    }

    public function __isset($name) {
        return isset($this->data[$name]);
    }

    public function __unset($name) {
        unset($this->data[$name]);
    }

    protected function _initialize() {}

    function insert_into($table,$data=array()){
		$value=array();
		$this->db->connect();
        include(PLUS_PATH.'dbstruct.cache.php');
        $TableFullName=$this->def.$table;
        if(is_array($$TableFullName)){
            $fields=array_keys($$TableFullName);
        }
		if(is_array($fields)){
			if(is_array($data)){
				foreach($data as $key=>$v){
					if(in_array($key,$fields)){
						$v = $this->FilterStr($v);
						$value[]="`".$key."`='".$this->db->escape_string($v)."'";
					}
				}
			}
		}
		$value=@implode(",",$value);
		return $this->DB_insert_once($table,$value);
	}
	function update_once($table,$data=array(),$w=''){ 
		$this->db->connect();
		$value=array();
		$where=array();
		include(PLUS_PATH.'dbstruct.cache.php');
        $TableFullName=$this->def.$table;
        if(is_array($$TableFullName)){
            $fields=array_keys($$TableFullName);
        }
		if(is_array($fields)){
			if(is_array($data)){
				foreach($data as $key=>$v){
					if(in_array($key,$fields)){
						$v = $this->FilterStr($v);
						$value[]="`".$key."`='".$this->db->escape_string($v)."'";
					}
				}
			}

			if(is_array($w)){
				foreach($w as $key=>$v){
					if(in_array($key,$fields)){
						$v = $this->FilterStr($v);
						$where[]="`".$key."`='".$this->db->escape_string($v)."'";
					}
				}
				$where=@implode(" and ",$where);
			}else{
				$where = $w;
			}
			$value=@implode(",",$value);
			return $this->DB_update_all($table,$value,$where);
		}
	}
	function FilterStr($str){
		$str = stripslashes($str);
		return $str;
	}
    function Memcache_set($name,$value=""){

		global $config;

		if($config[ismemcache]==2){
			return false;
		}
		$memcachehost=$config[memcachehost];
		$memcacheport=$config[memcacheport];
		$memcachezip=0;
		$memcachetime=$config[memcachetime];
		$name=md5(str_replace(array(" ","`","'",".","=","!"),"",$name));

		if(!extension_loaded('memcache'))return;

		$memcache =new memcache();

		if(!@class_exists($memcache)){return;}
		$memcache->connect($memcachehost,$memcacheport) or die ("Memcache连接失败或您的服务器不支持Memcache,请在后台关闭！");
		$val=$memcache->get($name);
		if(!is_array($val)){
			$val=$value;
			$memcache->set($name,$value,$memcachezip,$memcachetime);
		}
		$memcache->close();
		return $val;
	}
	function DB_select_num($tablename, $where = 1, $select = "*",$tablename2='',$special=''){
		$cachename=$tablename.$where;
		if(!$return=$this->Memcache_set($cachename)){
			if($tablename2){
				if($this->siteadmindir && $special==''){
				   if(in_array($tablename,$this->sitetable) && is_numeric($this->config['did'])){
					  $Where='a.`did`='.$this->config['did']."' and ".$Where;
				   }
				   if(in_array($tablename2,$this->sitetable) && is_numeric($this->config['did'])){
					  $Where='b.`did`='.$this->config['did']."' and ".$Where;
				   }
				}

				$SQL = "SELECT count($select) as num FROM " . $this->def . $tablename . " as a," . $this->def . $tablename2 . " as b  WHERE $where";
			}else{

				if($this->siteadmindir && $special==''){

					$where = $this->site_fetchsql($where,$tablename);
				}
				$SQL = "SELECT count($select) as num FROM " . $this->def . $tablename . " WHERE $where";
			}
			$query = $this->db->query($SQL);
			while($row=$this->db->fetch_array($query)){$return=$row[num];}
			$this->Memcache_set($cachename,$return);
		}
		if($return<1){$return='0';}
		return $return;
	}

	function DB_select_query($tablename, $where = 1, $select = "*",$special='') {
		if($this->siteadmindir){

			$where = $this->site_fetchsql($where,$tablename);
		}
	    $SQL = "SELECT $select FROM " . $this->def . $tablename . " WHERE $where";
		$query=$this->db->query($SQL);
		return $query;
	}

	function DB_select_all($tablename, $where = 1, $select = "*",$special='') {
		
		$cachename=$tablename.$where;
		if(!$row_return=$this->Memcache_set($cachename)){
			$row_return=array();  
			if($this->siteadmindir&&$special==''){

					$where = $this->site_fetchsql($where,$tablename);
			}  
			$SQL = "SELECT $select FROM `" . $this->def . $tablename . "` WHERE ".$where;

			$query=$this->db->query($SQL);
            while($row=$this->db->fetch_array($query)){$row_return[]=$row;}
            $this->Memcache_set($cachename,$row_return);
		}
        return $row_return;
	}

	function DB_select_alls($tablename1,$tablename2, $where = 1, $select = "*") {
		$cachename=$tablename1.$tablename2.$where;
		if(!$row_return=$this->Memcache_set($cachename)){


			if($this->siteadmindir){

				 if(in_array($tablename1,$this->sitetable) && is_numeric($this->config['did'])){


						$Where='a.`did`='.$this->config['did']."' and ".$Where;
				 }
				 if(in_array($tablename2,$this->sitetable) && is_numeric($this->config['did'])){


						$Where='b.`did`='.$this->config['did']."' and ".$Where;
				 }
			}
			$SQL = "SELECT $select FROM " . $this->def . $tablename1. " as a," . $this->def . $tablename2 . " as b WHERE $where";

			$query=$this->db->query($SQL);
            while($row=$this->db->fetch_array($query)){$row_return[]=$row;}
            $this->Memcache_set($cachename,$row_return);
		}

        return $row_return;
	}

	function DB_insert_once($tablename, $value){
		if(in_array($tablename,$this->sitetable) && strpos($value,'`did`')===false){
			$value.=",`did`='".$this->config['did']."'";
		} 
		$SQL = "INSERT INTO `" . $this->def . $tablename . "` SET ".$value;
		$this->db->query("set sql_mode=''");
		$this->db->query($SQL);
		$nid= $this->db->insert_id();
		return $nid;
	}

	function DB_update_all($tablename, $value, $where = 1,$pecial=''){
		if($pecial!=$tablename){

			$where =$this->site_fetchsql($where,$tablename);
		} 
    	$SQL = "UPDATE `" . $this->def . $tablename . "` SET $value WHERE ".$where; 
        $this->db->query("set sql_mode=''");
		$return=$this->db->query($SQL);
		return $return;
	}

	function DB_delete_all($tablename, $where, $limit = 'limit 1',$pecial=''){
		if($pecial!=$tablename){
			if(!in_array($tablename,array('temporary_resume','lssave'))){
				$this->insert_recycle($tablename,$this->site_fetchsql($where,$tablename));
			}
			$SQL = "DELETE FROM `" . $this->def . $tablename . "` WHERE ".$this->site_fetchsql($where,$tablename)." $limit";
		}else{
			if(!in_array($tablename,array('temporary_resume','lssave'))){
				$this->insert_recycle($tablename,$where);
			}
			$SQL = "DELETE FROM `" . $this->def . $tablename . "` WHERE ".$where." $limit";
		}
		
		$this->db->query("set `sql_mode`=''");
		return $this->db->query($SQL);
	}
	function insert_recycle($tablename,$where){
		$value="tablename='".$tablename."',";
		$value.="ctime='".mktime()."',";
		if($_SESSION['auid'] && $_SESSION['ausername']){
			$username=$_SESSION['ausername'];
		}else{
			$username=$_COOKIE['username'];
		}
		$value.="username='".$username."',";
		$query = $this->db->query("SELECT * FROM `" . $this->def . $tablename . "` WHERE $where limit 1");
		$row=$this->db->fetch_assoc();
		$value.="body='".serialize($row)."'";
		if($_GET['isdel']!="all")$this->DB_insert_once("recycle", $value);
	}

	function DB_query_all($sql,$type='one'){
		$query = $this->db->query($sql);
		if($type=='all'){
			 while($row=$this->db->fetch_array($query)){$return[]=$row;}
		}else{
			$return=$this->db->fetch_array($query);
		}
		return $return;
	}

	function DB_select_once($tablename, $where = 1, $select = "*",$special='') {
		$cachename=$tablename.$where;
		if(!$return=$this->Memcache_set($cachename)){

			if($this->siteadmindir&&$special==''){

				$where = $this->site_fetchsql($where,$tablename);
			}
			$SQL = "SELECT $select FROM " . $this->def . $tablename . " WHERE ".$where." limit 1";
			$query = $this->db->query($SQL);
			$return=$this->db->fetch_array($query);
			$this->Memcache_set($cachename,$return);
		}
		return $return;
	}


	function member_log($content,$opera='',$type=''){
		if($_COOKIE['uid']){
			$value="`uid`='".(int)$_COOKIE['uid']."',";
			$value.="`usertype`='".(int)$_COOKIE['usertype']."',";
			$value.="`content`='".$content."',";
			$value.="`opera`='".$opera."',";
			$value.="`type`='".$type."',";
			$value.="`ip`='".fun_ip_get()."',";
			$value.="`ctime`='".time()."'";
			$this->DB_insert_once("member_log",$value);
		}
	}
    function FormatOptions($Options){
        if(!is_array($Options)){return array('field'=>'*','where'=>'');}
        $WhereStr='';
        if($Options['field']){
            $Field=$Options['field'];
            unset($Options['field']);
        }else{
            $Field='*';
        }
		if($Options['special']){
            $special=$Options['special'];
            unset($Options['special']);
        }
		if($Options['groupby']){
            $WhereStr.=' group by '.$Options['groupby'];
        }
        if($Options['orderby']){
            $WhereStr.=' order by '.$Options['orderby'];
        }

		if($Options['desc']){
            $WhereStr.=" ".$Options['desc'];
        }
        if($Options['limit']){
            $WhereStr.=' limit '.$Options['limit'];
        }
        return array('field'=>$Field,'order'=>$WhereStr,"special"=>$special);
    }
	function FormatWhere($Where){
        $WhereStr='1';
        foreach($Where as $k=>$v){
            if(is_numeric($k)){
                if((substr(trim($v),0,3)=='and')||(substr(trim($v),0,2)=='or')){
                    $WhereStr.=' '.$v;
                }elseif($v){
                    $WhereStr.=' and '.$v;
                }
            }else{
				if(strpos($k,'<>') > 0){
					$position = strpos($k,'<>');
					$fieldName = trim(substr($k,0,$position));
					$WhereStr .=' and `'.$fieldName.'` <> \''.$v.'\'';
				}
				elseif(strpos($k,'<') > 0){
					$position = strpos($k,'<');
					$fieldName = trim(substr($k,0,$position));
					$WhereStr .=' and `'.$fieldName.'` < \''.$v.'\'';
				}
				elseif(strpos($k,'>') > 0){
					$position = strpos($k,'>');
					$fieldName = trim(substr($k,0,$position));
					$WhereStr .=' and `'.$fieldName.'` > \''.$v.'\'';
				}
				else{
					$WhereStr .=' and `'.$k.'`=\''.$v.'\'';
				}
            }
        }
        return $WhereStr;
    }
	function FormatValues($Values){
        $ValuesStr='';
        foreach($Values as $k=>$v){
			if(preg_match("/^[a-zA-Z0-9_]+$/",$k)){
				 if(preg_match('/^[0-9]+$/', $k)){
					$FiledList = @explode(',',$v);
					if(is_array($FiledList)){
						foreach($FiledList as $Fv){
							$FvList = @explode('=',$Fv);
							if($FvList[1]){
									if(strpos($FvList[1],'+') > 0){
										$FiledV = @explode('+',$FvList[1]);
										$ValuesStr.=',`'.str_replace("`",'',$FvList[0]).'`=`'.str_replace("`",'',$FiledV[0]).'`+\''.intval(str_replace("'",'',$FiledV[1])).'\'';
									}
									if(strpos($FvList[1],'-') > 0){
										$FiledV = @explode('-',$FvList[1]);
										$ValuesStr.=',`'.str_replace("`",'',$FvList[0]).'`=`'.str_replace("`",'',$FiledV[0]).'`-\''.intval(str_replace("'",'',$FiledV[1])).'\'';
									}

							}

						}
					}
				}else{
					$ValuesStr.=',`'.$k.'`=\''.$v.'\'';
				}
			}

        }
        return substr($ValuesStr,1);
    }
    function RemindDeal($TableName,$Values=array(),$Where=array()){
        $ValuesStr.=$this->FormatValues($Values);
        $WhereStr='';
        $WhereStr.=$this->FormatWhere($Where);
        $this->DB_update_all($TableName,$ValuesStr,$WhereStr);
    }
    function site_fetchsql($Where,$TableName,$SplitChar=' and '){
        if(in_array($TableName,$this->sitetable)){
            if(is_array($Where)&&is_numeric($this->config['did'])){
				$Where['did']=$this->config['did'];
            }else if(is_numeric($this->config['did'])){
				$Where='`did`='.$this->config['did'].$SplitChar.$Where;
            }
        }
        return $Where;
    }

	function get_page($table,$where='',$pageurl='',$limit=20,$field='*',$rowsname='rows'){
		$rows=array();
		$page=$_GET['page']<1?1:$_GET['page'];
		$ststrsql=($page-1)*$limit;
		$num=$this->DB_select_num($table,$where);
		if($num>$limit){
			$pages=ceil($num/$limit);
            $pagenav=Page($page,$num,$limit,$pageurl,$notpl=false,null);
		}
		$rows=$this->DB_select_all($table,$where.' limit '.$ststrsql.','.$limit,$field);
		return array('total'=>$num,'pagenav'=>$pagenav,$rowsname=>$rows);
	}
	
	//20170926
	function get_page_by_sql($selectSql,$countSql,$pageurl='',$limit=20,$rowsname='rows'){
		$rows=array();
		$page=$_GET['page']<1?1:$_GET['page'];
		$ststrsql=($page-1)*$limit;
		$num=$this->DB_query_num_by_sql($countSql);
		if($num>$limit){
			$pages=ceil($num/$limit);
            $pagenav=Page($page,$num,$limit,$pageurl,$notpl=false,null);
		}
		$rows=$this->DB_select_by_sql($selectSql.' limit '.$ststrsql.','.$limit);
		return array('total'=>$num,'pagenav'=>$pagenav,$rowsname=>$rows);
	}
	function DB_query_num_by_sql($sql){
		$query = $this->db->query($sql);
		while($row=$this->db->fetch_array($query)){$return=$row['num'];}
	
		if($return<1){$return='0';}
		return $return;
	}
	function DB_select_by_sql($sql) {
		$cachename=$sql;
		if(!$row_return=$this->Memcache_set($cachename)){

			$query=$this->db->query($sql);
            while($row=$this->db->fetch_array($query)){$row_return[]=$row;}
            $this->Memcache_set($cachename,$row_return);
		}

        return $row_return;
	}
}
?>