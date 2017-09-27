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
class ad_model extends model
{

    function GetAdClass($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('ad_class',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }

    function GetAd($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('ad',$WhereStr.$FormatOptions['order'],$FormatOptions['field'],$FormatOptions['special']);
    }

    function AddAd($Values=array()){
        return $this->insert_into('ad',$Values);
    }

    function GetAdOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('ad',$WhereStr,$FormatOptions['field']);
    }

    function UpdateAd($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('ad',$ValuesStr,$WhereStr);
    }

    function DeleteAd($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('ad',$WhereStr);
    }

    function GetAdOrderOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('ad_order',$WhereStr,$FormatOptions['field']);
    }
    function GetAdOrder($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('ad_order',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }

    function UpdateOrderAd($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('ad_order',$ValuesStr,$WhereStr);
    }
    function DeleteAdOrder($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('ad_order',$WhereStr,"");
    }
}
?>