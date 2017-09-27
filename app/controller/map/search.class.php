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
class search_controller extends map_controller{
	function index_action(){

        $CompanyM=$this->MODEL('company');
        $JobM=$this->MODEL('job');
        $page=(int)$_POST['page'];
        $pagesize=10;
		$jobwhere="`edate`>'".time()."' and `state`='1' ";
		$where="`name`<>'' and `r_status`<>'2'";
        if($_POST['keyword']){
            $nwhere=' and `name` like \'%'.iconv("utf-8","gbk",trim($_POST['keyword'])).'%\'';
			$keyword=trim($_POST['keyword']);
        }
		if($_POST['min_lng'] && $_POST['max_lng']){
			$lng=" and `x`>='".$_POST['min_lng']."' AND `x`<='".$_POST['max_lng']."' AND `y`>='".$_POST['min_lat']."' AND `y`<='".$_POST['max_lat']."'";
			$where.=$lng;
		}
		if(trim($_POST['type'])=="job"){
			$jobwhere.=$nwhere;
			$Company=$JobM->GetComjobList(array($jobwhere),array("field"=>"uid","order"=>" group by `uid`"));
			foreach($Company as $v){
				$uid[]=$v['uid'];
			}
			$CompanyNum=$CompanyM->GetComNum(array($where.' and `uid` in ('.@implode(',',$uid).')'));
		}else if(trim($_POST['type'])=="company"){
			$CompanyNum=$CompanyM->GetComNum(array($where.$nwhere));
		}else{
			
			$Company=$JobM->GetComjobList(array($jobwhere),array("field"=>"uid","order"=>" group by `uid`"));
			foreach($Company as $v){
				$uid[]=$v['uid'];
			}
			$CompanyNum=$CompanyM->GetComNum(array($where.' and `uid` in ('.implode(',',$uid).')'));
		}
        if($page==0){
            $pagelimit=10;
        }else if($page<=($CompanyNum/$pagesize)){
            $pagelimit=$pagesize*$page.','.$pagesize;
        }else{
            $pagelimit=($CompanyNum/$pagesize)*$page.','.$pagesize;
        }
		if(trim($_POST['type'])=="company"){
			$CompanyList=$CompanyM->GetComList(array($where.$nwhere),array('limit'=>$pagelimit));
		}else{
			$CompanyList=$CompanyM->GetComList(array($where.' and `uid` in ('.implode(',',$uid).')'),array('limit'=>$pagelimit));
		}
		$UIDList=array();
        foreach($CompanyList as $k=>$v){
			if(in_array($v['uid'],$UIDList)==false){
				$UIDList[]=$v['uid'];
			}           
        } 
        $JobList=$JobM->GetComjobList(array("`uid` in (".implode(',',$UIDList).") and ".$jobwhere));
        foreach($CompanyList as $k1=>$v1){
            foreach($JobList as $k2=>$v2){
                if($v1['uid']==$v2['uid']){
                    $CompanyList[$k1]['joblist'][]=$v2;
                }
            }
        }
        $json_list=array();
        foreach($CompanyList as $k1=>$v1){
            $json_list[$k1]['name']=mb_substr(yun_iconv('gbk','utf-8',$v1['name']),0,10,'utf-8');
            $json_list[$k1]['x']=yun_iconv('gbk','utf-8',$v1['x']);
            $json_list[$k1]['y']=yun_iconv('gbk','utf-8',$v1['y']);
            $json_list[$k1]['address']=yun_iconv('gbk','utf-8',$v1['address']);
            $json_list[$k1]['com_url']=Url('company',array('c'=>'show','id'=>$v1['uid']));
            foreach($CompanyList[$k1]['joblist'] as $k2=>$v2){
                $json_list[$k1]['joblist'][]=array('name'=>mb_substr(yun_iconv('gbk','utf-8',$v2['name']),0,10,'utf-8'),'job_url'=>Url('job',array('c'=>'comapply','id'=>$v2['id'])));
            }
        }
        echo json_encode(array('list'=>$json_list,'count'=>$CompanyNum,'k'=>$keyword));die;
	}
}
?>