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
class tiny_model extends model{
    function GetTinyresumeNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('resume_tiny',$WhereStr);
    }
    function GetTinyresumeOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('resume_tiny',$WhereStr,$FormatOptions['field']);
    }
    function UpdateTinyresume($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('resume_tiny',$ValuesStr,$WhereStr);
    }
    function AddTinyresume($Values=array()){
        return $this->insert_into('resume_tiny',$Values);
    }
    function DeleteTinyresume($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('resume_tiny',$WhereStr);
    }    
}
?>