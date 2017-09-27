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
class ask_model extends model{
  
	function GetAttentionList($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('attention',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
	
	function GetHotUser($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
		$rows=$this->DB_select_all('answer',$WhereStr.$FormatOptions['order'],$FormatOptions['field']); 
		if($rows&&is_array($rows)){
			$uids=array();
			foreach($rows as $val){
				$uids[]=$val[uid];
			} 
			
		} 
		return $rows;
    }
	
    function DeleteAttention($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('attention',$WhereStr);
    }
    function UpdateAttention($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('attention',$ValuesStr,$WhereStr);
    }
	function UpdateQclass($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('q_class',$ValuesStr,$WhereStr);
    }
    function AddAttention($Values=array()){
        return $this->insert_into('attention',$Values);
    }
    function UpdateAnswer($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('answer',$ValuesStr,$WhereStr);
    }
	function DeleteQuestion($Where=array()){ 
        $WhereStr=$this->FormatWhere($Where);
		$result=$this->DB_delete_all('question',$WhereStr);
		if($result){
			$rows=$this->DB_select_all('answer',"`qid`='".$Where['id']."' group by uid","count(id) as num,uid");
			foreach($rows as $val){
				$num[$val['uid']]=$val['num'];
				$uid[]=$val['uid'];
			}
			$attention=$this->DB_select_all("attention","FIND_IN_SET('".$Where['id']."',ids) and `type`='1'","`ids`,`id`");
			if(count($attention)){
				foreach($attention as $val){
					$ids=array();
					$arr=@explode(',',$val['ids']);
					foreach($arr as $v){
						if($v!=$Where['id']){
							$ids[]=$v;
						}
					} 
					if($ids[0]){
						$this->DB_update_all('attention',"`ids`='".pylode(',',$ids)."'","`id`='".$val['id']."'");
					}else{
						$this->DB_delete_all('attention',"`id`='".$val['id']."'");
					} 
				}
			}	
			
			$this->DeleteAnswer(array("qid"=>$Where['id']));
			$this->DeleteReview(array("qid"=>$Where['id']));
		} 
        return $result;
    }
	function DeleteReview($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('answer_review',$WhereStr);
    }
    function UpdateQuestion($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values); 
        return $this->DB_update_all('question',$ValuesStr,$WhereStr);
    }
    function SaveQuestion($Values=array(),$Where=array()){
        $ValuesStr=$this->FormatValues($Values);
        if($Where){
            $WhereStr=$this->FormatWhere($Where);
            return $this->DB_update_all('question',$ValuesStr,$WhereStr);
        }else{
            return $this->insert_into('question',$Values);
        }
    }
    function GetQuestionOne($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('question',$WhereStr,$FormatOptions['field']);
    }
   
    function GetQuestionList($Where=array(),$Options=array()){

        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
        return $this->DB_select_all('question',$WhereStr.$FormatOptions['order'],$FormatOptions['field']); 
    }
	
    function GetQclassOnce($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('q_class',$WhereStr,$FormatOptions['field']);
    } 
    function GetReportOne($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('report',$WhereStr,$FormatOptions['field']);
    }
	
    function GetReportList($Where=array(),$Options=array()){
    
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('report',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function GetCommentList($Where=array(),$Options=array()){
		$AID=(int)$Where['aid'];
        if(!is_numeric($AID)){
            return null;
        }
		$review=$this->DB_select_all('answer_review',"`aid`='".$AID."'  order by `add_time` asc");
		if(count($review)){
			$uids=array();
			foreach($review as $val){
				if(in_array($val['uid'],$uids)==false){
					$uids[]=$val['uid'];
				}
			}
			$info=$this->DB_select_all('member',"`uid` in(".@implode(',',$uids).")","`username`,`uid`,`usertype`");
			$user=$this->DB_select_all('resume',"`uid` in(".@implode(',',$uids).")","`photo`,`uid`");
			$com=$this->DB_select_all('company',"`uid` in(".@implode(',',$uids).")","`logo`,`uid`");
			foreach($review as $key=>$val){
				foreach($info as $v){
					if($v['uid']==$val['uid']){
						$review[$key]['nickname']=$v['username'];
					}
				}
				foreach($user as $v){
					if($v['uid']==$val['uid']){
						$v['photo']?$review[$key]['pic']=$v['photo']:$review[$key]['pic']=$this->config['sy_friend_icon'];
					}
				}
				foreach($com as $v){
					if($v['uid']==$val['uid']){
						$v['logo']?$review[$key]['pic']=$v['logo']:$review[$key]['pic']=$this->config['sy_friend_icon'];
					}
				}
			}
		}
        return $review;
    }
    function GetCommentNum($Where=array('aid'=>null)){
		 $AID=(int)$Where['aid'];
        if(!is_numeric($AID)){
            return null;
        }
        return $this->DB_select_num('answer_review','`aid`='.$AID);
    }
	function GetAnswerNum($Where=array()){
		$QID=(int)$Where['qid'];
		if(!is_numeric($QID)){
			return null;
		}
		return $this->DB_select_num("answer","`qid`='".$QID."'");
	}
	
    function GetAnswerList($answer){ 
		if(count($answer)){
			$uids=array();
			foreach($answer as $val){
				if(in_array($val['uid'],$uids)==false){
					$uids[]=$val['uid'];
				}
			}
			$minfo=$this->DB_select_all('member','uid in('.pylode(',',$uids).')','uid,username');
			foreach($answer as $k=>$v){
				foreach($minfo as $val){
					if($v['uid']==$val['uid']){
						$answer[$k]['nickname']=$val['username'];
					}
				}
			}
		}
		return $answer;
    }
    
    function GetAtnOne($Where=array(),$Options=array()){ 
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
		return $this->DB_select_once('atn',$WhereStr,$FormatOptions['field']);
    }
    
    function GetAtnNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
		return $this->DB_select_num('atn',$WhereStr);
    }
   
    function GetAtnList($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('atn',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
	function MyFansList($Where=array(),$Options=array()){ 
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
		$rows=$this->DB_select_all('atn',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
		if($rows&&is_array($rows)){
			$uids=array();
			foreach($rows as $val){
				if(in_array($val['uid'],$uids)==false){$uids[]=$val['uid'];}
			} 
			
		} 
		return $rows; 
    }
	function DeleteAnswer($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('answer',$WhereStr);
    }
    function DeleteAtn($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('atn',$WhereStr);
    }
	

    
    function AddQuestionHits($Where=array()){
		$ID=(int)$Where['id'];
		if(!is_numeric($ID)){
			return null;
		}
        return $this->DB_update_all('question',"`visit`=`visit`+'1'","`id`='".$ID."'");
    }
    function AddAnswerReview($Values=array()){
        return $this->insert_into('answer_review',$Values);
    }
    
    function AddReport($Values=array()){
        return $this->insert_into('report',$Values);
    }

}
?>