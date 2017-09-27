<?php
class Webscan360_db
{
	private $dbconfig = '';
	private $webscan_table = 'webscan360';
	public $tablename = '';
	private $simpledb='';

	public  function __construct(){
		define("WEBSCAN360" , true);
		$db = include(dirname(dirname(__FILE__)).'/webscan360_config.php');
	
		if(empty($db)||!is_array($db)){
		}
		if(empty($db['DB_HOST'])){
		}
		if(empty($db['DB_USER'])){
		}
		
		if(empty($db['DB_NAME'])){
		}
		if(!empty($db) && !empty($db['DB_HOST']) && !empty($db['DB_USER']) && !empty($db['DB_NAME'])&& $db['DB_USER'] !="数据库用户名" && $db['DB_PWD'] !="数据库密码"&& $db['DB_NAME'] !="数据库名称"){

			$smodel = new SimpleDB($db);
			$this->simpledb = $smodel;
			$tablename = $db['DB_PREFIX'].$this->webscan_table;
			$this->tablename = $tablename;
			$this->createWebscan360DB();
		}
	}
	private function createWebscan360DB(){

		if(empty($this->tablename)) return;
		$res_tableexist = $this->simpledb->query("SHOW TABLES LIKE '" .$this->tablename. "'");
		if(empty($res_tableexist)){
			$this->simpledb->query("CREATE TABLE `".$this->tablename."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `var` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `ext1` varchar(100) DEFAULT NULL,
  `ext2` varchar(100) DEFAULT NULL,
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=175 DEFAULT CHARSET=utf8");
		}		
	}
	public  function rec_update($row , $where){
		if(empty($this->tablename)) return;
		if(!empty($row) && !empty($where)){
			
	        $sqlud='';
            foreach ($row as $key=>$value) {
        		$key = $this->simpledb->escape_string($key);
        		$value = $this->simpledb->escape_string($value);                
                $sqlud .= "`$key`"."= '".$value."',";
            }
	        $sqlud=rtrim($sqlud);
	        $sqlud=rtrim($sqlud,',');
	        $where = $this->webscandb_condtion($where);
	        $sql="UPDATE `".$this->tablename."` SET ".$sqlud." WHERE ".$where;
			return $this->simpledb->execute($sql);
		}
	}
	public  function rec_getRow($where){
		if(empty($this->tablename)) return;
		if(!empty($where)){
	        $where = $this->webscandb_condtion($where);
	        $sql = "SELECT * FROM " . $this->tablename . " where " . $where;
	        $ret = $this->simpledb->query($sql);
			return $ret[0];
		}   	
	}
	private function webscandb_condtion($where){
		if(!empty($where)){
			$where_str = '';
			$i = 0;
			foreach ($where as $key=>$value){
				$i++;
				$key = $this->simpledb->escape_string($key);
        		$value = $this->simpledb->escape_string($value);
        		if($i == 1){
        			$where_str .= "`$key`='$value'";
        		}else{
					$where_str .= " and `$key`='$value'";
        		}
			}
			return  $where_str;
		}
	}
	public  function rec_insert($row){
		if(empty($this->tablename)) return;
		if(!empty($row)){
	        $sqlfield='';
	        $sqlvalue='';
	        foreach ($row as $key=>$value) {
        		$key = $this->simpledb->escape_string($key);
        		$value = $this->simpledb->escape_string($value);
                $sqlfield .= "`".$key."`,";
                $sqlvalue .= "'".$value."',";
	        }
	        $sql = "INSERT INTO `".$this->tablename."`(".substr($sqlfield,0,-1).") VALUES (".substr($sqlvalue,0,-1).")";
	        return $this->simpledb->execute($sql);
		}
		
	}	
}
class SimpleDB
{

    static private $_instance	= null;
    public $debug				= false;
    protected $pconnect         = false;
    protected $queryStr			= '';
    protected $lastInsID		= null;
    protected $numRows			= 0;
    protected $numCols			= 0;
    protected $transTimes		= 0;
    protected $error			= '';
    protected $linkID			=   null;
    protected $queryID			= null;
    protected $connected		= false;
    protected $config			= '';
    protected $beginTime;

    public function __construct($config=''){
        if ( !extension_loaded('mysql') ) {
            echo('not support mysql');
        }
        $this->config   =   $this->parseConfig($config);
    }

    public function connect() {
        if(!$this->connected) {
            $config =   $this->config;
            $host = $config['hostname'].($config['hostport']?":{$config['hostport']}":'');
            if($this->pconnect) {
                $this->linkID = mysql_pconnect( $host, $config['username'], $config['password']);
            }else{
                $this->linkID = mysql_connect( $host, $config['username'], $config['password'],true);
            }
            if ( !$this->linkID || (!empty($config['database']) && !mysql_select_db($config['database'], $this->linkID)) ) {
            }
            $dbVersion = mysql_get_server_info($this->linkID);
            if ($dbVersion >= "4.1") {
                mysql_query("SET NAMES 'UTF8'", $this->linkID);
            }
            if($dbVersion >'5.0.1'){
                mysql_query("SET sql_mode=''",$this->linkID);
            }
            $this->connected    =   true;
            unset($this->config);
        }
    }

    public function free() {
        mysql_free_result($this->queryID);
        $this->queryID = 0;
    }

    public function query($str='') {
        $this->connect();
        if ( !$this->linkID ) return false;
        if ( $str != '' ) $this->queryStr = $str;
        if ( $this->queryID ) {    $this->free();    }
        $this->Q(1);
        $this->queryID = mysql_query($this->queryStr, $this->linkID);
        if ( !$this->queryID ) {
                return false;
        } else {
            $this->numRows = mysql_num_rows($this->queryID);
            return $this->getAll();
        }
    }

    public function execute($str='') {
        $this->connect();
        if ( !$this->linkID ) return false;
        if ( $str != '' ) $this->queryStr = $str;
        if ( $this->queryID ) {    $this->free();    }
        $this->W(1);
        $result =   mysql_query($this->queryStr, $this->linkID) ;
        if ( false === $result) {
            return false;
        } else {
            $this->numRows = mysql_affected_rows($this->linkID);
            $this->lastInsID = mysql_insert_id($this->linkID);
            return $this->numRows;
        }
    }

    public function getAll() {
        if ( !$this->queryID ) {
            return false;
        }
        $result = array();
        if($this->numRows >0) {
            while($row = mysql_fetch_assoc($this->queryID)){
                $result[]   =   $row;
            }
            mysql_data_seek($this->queryID,0);
        }
        return $result;
    }

    public function close() {
        if (!empty($this->queryID))
            mysql_free_result($this->queryID);
        if ($this->linkID && !mysql_close($this->linkID)){
        }
        $this->linkID = 0;
    }

    public function error() {
        $this->error = mysql_error($this->linkID);
        if($this->queryStr!=''){
            $this->error .= "\n [ SQL语句 ] : ".$this->queryStr;
        }
        return $this->error;
    }

    public function escape_string($str) {
        return mysql_escape_string($str);
    }

    public function __destruct()
    {
        $this->close();
    }

    public static function getInstance($db_config='')
    {
		if ( self::$_instance==null ){
			self::$_instance = new Db($db_config);
		}
		return self::$_instance;
    }

    private function parseConfig($_db_config='') {
		$db_config = array (
			'dbms'		=>   $_db_config['DB_TYPE'],
			'username'	=>   $_db_config['DB_USER'],
			'password'	=>   $_db_config['DB_PWD'],
			'hostname'	=>   $_db_config['DB_HOST'],
			'hostport'	=>   $_db_config['DB_PORT'],
			'database'	=>   $_db_config['DB_NAME'],
			'dsn'		=>   $_db_config['DB_DSN'],
			'params'	=>   $_db_config['DB_PARAMS'],
		);
        return $db_config;
    }

    protected function debug() {
        if ( $this->debug )    {
            $runtime    =   number_format(microtime(TRUE) - $this->beginTime, 6);
            Log::record(" RunTime:".$runtime."s SQL = ".$this->queryStr,Log::SQL);
        }
    }

    public function Q($times='') {
        static $_times = 0;
        if(empty($times)) {
            return $_times;
        }else{
            $_times++;
            $this->beginTime = microtime(TRUE);
        }
    }

    public function W($times='') {
        static $_times = 0;
        if(empty($times)) {
            return $_times;
        }else{
            $_times++;
            $this->beginTime = microtime(TRUE);
        }
    }

    public function getLastSql() {
        return $this->queryStr;
    }

}