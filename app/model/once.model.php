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
class once_model extends model{
    function GetOncejobNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('once_job',$WhereStr);
    }
    function GetOncejobOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('once_job',$WhereStr,$FormatOptions['field']);
    }
    function UpdateOncejob($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('once_job',$ValuesStr,$WhereStr);
    }
    function AddOncejob($Values=array()){
        return $this->insert_into('once_job',$Values);
    }
    function DeleteOncejob($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('once_job',$WhereStr);
    }    
}
?>