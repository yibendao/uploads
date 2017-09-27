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
class index_model extends model{

    function GetAdOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('ad',$WhereStr,$FormatOptions['field']);
    }

    function GetAdclickNum($Where){
        return $this->DB_select_num('adclick',$Where);
    }

    function InsertAdclick($Values=array()){
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_insert_once('adclick',$ValuesStr);
    }

	function AddAdHits($id){
		$this->DB_update_all("ad","`hits`=`hits`+1","`id`='".$id."'");
	}
    function GetDescOne($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_once('description',$WhereStr);
    }
}
?>