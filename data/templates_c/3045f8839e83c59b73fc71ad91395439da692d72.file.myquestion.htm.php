<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-09-30 14:38:20
         compiled from "D:\phpStudy\WWW\uploads\app\template\ask\myquestion.htm" */ ?>
<?php /*%%SmartyHeaderCode:231859cf3bdcd8eca9-92470139%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3045f8839e83c59b73fc71ad91395439da692d72' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\uploads\\app\\template\\ask\\myquestion.htm',
      1 => 1490265632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '231859cf3bdcd8eca9-92470139',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'uid' => 0,
    'list' => 0,
    'total' => 0,
    'pagenav' => 0,
    'config' => 0,
    'ask_style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59cf3bdcf0e896_08372199',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59cf3bdcf0e896_08372199')) {function content_59cf3bdcf0e896_08372199($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\phpStudy\\WWW\\uploads\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><?php global $db,$db_config,$config;eval('$paramer=array("item"=>"\'list\'","uid"=>"\'auto.uid\'","ispage"=>"1","t_len"=>"20","limit"=>"6","nocache"=>"")
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
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['askstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
  
<div class="answer_con">
	<div class="content con_answer"> 
		<div class="content_hot ">
			<div class="left left_con">
               <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['askstyle']->value)."/nav.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
             <?php if ($_GET['a']=='myquestion') {?>
               <div class="answer_content fl">
                   <div class="answer_content_top fl"><span><?php if ($_smarty_tpl->tpl_vars['uid']->value&&($_GET['uid']==''||$_GET['uid']==$_smarty_tpl->tpl_vars['uid']->value)) {?> 我的提问<?php } elseif ($_GET['uid']) {?>他的提问<?php }?></span></div>
					<div class="wt_content_t">
						<ul>
							<?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
?>
							<li>
								<p><a href="<?php echo $_smarty_tpl->tpl_vars['list']->value['url'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['list']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['list']->value['title'];?>
</a></p>
								<div class="wt_jl">
									<?php if ($_smarty_tpl->tpl_vars['uid']->value==$_smarty_tpl->tpl_vars['list']->value['uid']) {?>
									<span class="friend_delect" style="float:right"><a href="javascript:void(0)" onclick="layer_del('确定要删除该提问？','<?php echo smarty_function_url(array('m'=>'ask','c'=>'friend','a'=>'delask','id'=>$_smarty_tpl->tpl_vars['list']->value['id']),$_smarty_tpl);?>
')">删除</a></span>
									<?php }?><span class="gz_icon"><font><?php echo $_smarty_tpl->tpl_vars['list']->value['atnnum'];?>
</font>人关注</span>
									<span class="hd_icon"><font><?php echo $_smarty_tpl->tpl_vars['list']->value['answer_num'];?>
</font>个回答</span>
									<span class="ll_icon"><font><?php echo $_smarty_tpl->tpl_vars['list']->value['visit'];?>
</font>次浏览</span>
									<span class="time_icon"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['list']->value['add_time'],"%Y-%m-%d %H:%M");?>
</span>
									
								</div>
							</li>
							<?php } ?>   
						</ul>
						<?php if ($_smarty_tpl->tpl_vars['total']->value==0) {?>
                        <div class="noresult">
							
							<span><a href="<?php echo smarty_function_url(array('m'=>'ask','c'=>'addquestion'),$_smarty_tpl);?>
"> 暂时没有提问！ </a></span> 
						</div>
						<?php } else { ?> 
						<div class="pages"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div> 
						<?php }?> 
					</div>
				                    
                </div>
			<?php }?>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['askstyle']->value)."/right.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		</div>
	</div>
</div>  
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ask_style']->value;?>
/js/question.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js" language="javascript"><?php echo '</script'; ?>
>
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
DD_belatedPNG.fix('.png,.attention .watch_gz');
<?php echo '</script'; ?>
>
<![endif]-->
<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['askstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
   
<?php }} ?>
