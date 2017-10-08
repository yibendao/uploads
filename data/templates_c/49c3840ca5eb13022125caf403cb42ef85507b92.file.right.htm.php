<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 14:38:21
         compiled from "D:\phpStudy\WWW\uploads\\app\template\ask\right.htm" */ ?>
<?php /*%%SmartyHeaderCode:1218859cf3bdd23f707-68133414%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49c3840ca5eb13022125caf403cb42ef85507b92' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\\\app\\template\\ask\\right.htm',
      1 => 1492070372,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1218859cf3bdd23f707-68133414',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf3bdd2660a5_52043707',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf3bdd2660a5_52043707')) {function content_59cf3bdd2660a5_52043707($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php global $db,$db_config,$config;eval('$paramer=array("item"=>"\'list\'","limit"=>"8","nocache"=>"")
;');$list=array();
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		
		$where=1;
		
		if($_COOKIE['uid']&&$paramer['friend']){
			$atn=$db->select_all("atn","`uid`='".$_COOKIE['uid']."'","`sc_uid`");
			$friend=array();
			foreach($atn as $val){
				$friend[]=$val['sc_uid'];
			}
			$where.=" and `id` in(".@implode(',',$friend).")";
			unset($friend);
		} 
		if($paramer[hot]){
			$time=strtotime("-".(int)$paramer[hot]." day");
			$where.=" and `add_time`>'".$time."'";
		}
		if($paramer[noid]){
			$where.=" and `id`<>'".$paramer[noid]."'";
		}
		if($paramer[keyword]){
			$where.=" and `title` like '%".$paramer['keyword']."%'";
		}
		if($paramer[nonum]){
			$where.=" and `answer_num`='0'";
		}
		if($paramer[yesnum]){
			$where.=" and `answer_num`>0";
		}
		if($paramer[order]){ 
			if($paramer[order]=="addtime"){
				$paramer[order]="add_time";
			}
			if($paramer[order]=="answernum"){
				$paramer[order]="answer_num";
			}
			$order = " ORDER BY `".$paramer[order]."`  desc";
		}else{
			$order = " ORDER BY `add_time` desc";
		}
		if($paramer[cid]){
			$where .=" and `cid`='".$paramer[cid]."'";
		}
		if($paramer[uid]){
			$where .=" and `uid`='".$paramer[uid]."'";
		}
		if($paramer[recom]){
			$where .=" and `is_recom`='1'";
		}
		if($paramer[limit]){
			$limit=" limit ".$paramer[limit];
		}
		
		if($paramer['ispage']){
			$limit = PageNav($paramer,$_GET,"question",$where,$Purl,"","6",$_smarty_tpl);
		}
		$list = $db->select_all("question",$where.$order.$limit);  
		if(count($list)){
			foreach($list as $key=>$val){
				if(intval($paramer[t_len])>0){
					$len = intval($paramer[t_len]);
					$list[$key][title]  = mb_substr($val[title],0,$len,"GBK");
				}
				if($paramer['keyword']){ 
					$list[$key][title] =str_replace($paramer[keyword],"<font color='#FF6600' >".$paramer[keyword]."</font>",$list[$key][title]);
				}
				if($val['pic']&&file_exists(str_replace($config['sy_weburl'],APP_PATH,".".$val['pic']))){
					$list[$key]['pic']=$config["sy_weburl"]."/".$val['pic'];
				}else{
					$list[$key]['pic']=$config["sy_weburl"]."/".$config['sy_friend_icon'];
				}
				
				$list[$key][url] = Url("ask",array("c"=>"content","id"=>$val[id]));
				$list[$key][userurl] = Url("ask",array("c"=>"friend","a"=>"myquestion","uid"=>$val[uid]));
				if(in_array($val[uid],$ListId)==false){$ListId[] =  $val[uid];} 
				$Qclass[]=$val[cid];
			}
			$uids=@implode(",",$ListId);
			  
			foreach($list as $r_k=>$r_v){
				if($r_v['uid']==$_COOKIE['uid']){
					$list[$r_k]['isatn']='2';
				} 
			}	
		} ?>
<div class="right right_rem"> 	
	<div class="recom_expert" style="margin-top:0px;">
     <div class="ask_tit"><span class="ask_tit_icon_s"><i class="ask_tit_icon"></i>最新问题</span></div>
		<ul class="ask_relate_list">
			<?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
?>
			<li>
				<div class="ask_relate_top"><a class="ask_relate_con" href="<?php echo $_smarty_tpl->tpl_vars['list']->value['url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['list']->value['title'];?>
</a></div>
              <span class="ask_relate_twr"> 提问人:</span> <a class="ask_relate_name" href="<?php echo $_smarty_tpl->tpl_vars['list']->value['userurl'];?>
" target="_blank"><?php echo mb_substr($_smarty_tpl->tpl_vars['list']->value['nickname'],0,8,'gbk');?>
</a>
              <div class="ask_tw_time"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['list']->value['add_time'],"%Y-%m-%d");?>
</div>
				
			</li>
			<?php } ?> 
		</ul>
	</div> 
</div>
<div class="clear"></div><?php }} ?>
