<?php
class Smarty_Internal_Compile_Articleclass extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'rec', 'urlstatic', 'len', 'pt_len', 'pd_len', 't_len','arcpic','arclist','r_news','classid','r_list');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        $from = $_attr['from'];
        $item = $_attr['item'];
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }
        $OutputStr='global $db,$db_config,$config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
		include PLUS_PATH."/group.cache.php";

		$group = array();
		if($paramer[\'classid\']){
			$classid = @explode(\',\',$paramer[\'classid\']);
			if(is_array($classid)){
				foreach($classid as $key=>$value){
					$Info[\'id\']   = $value;
					$Info[\'name\'] = $group_name[$value];
					$group[] = $Info;
				}
			}
		}else if($paramer[\'rec\']){
			if(is_array($group_rec)){
				foreach($group_rec as $key=>$value){
					$Info[\'id\']   = $value;
					$Info[\'name\'] = $group_name[$value];
					$group[] = $Info;
				}
			}
		}else if($paramer[\'r_news\']){
			if(is_array($group_recnews)){
				foreach($group_recnews as $key=>$value){
					$Info[\'id\']   = $value;
					$Info[\'name\'] = $group_name[$value];        
					$group[] = $Info;
				}
			}
		}else{
			if(is_array($group_index)){
				foreach($group_index as $key=>$value){
					$Info[\'id\']   = $value;
					$Info[\'name\'] = $group_name[$value];
					$group[] = $Info;
				}
			}
		}
		if(is_array($group)){
			foreach($group as $key=>$value){
              if($paramer[r_list]){
				  if(is_array($group_type)){
					  foreach($group_type as $k=>$v){           
						 if($value[\'id\']==strval($k)){
							foreach($v as $ke=>$va){
							  $rs[\'id\']=$va;
							  $rs[\'name\']=$group_name[$va];
							  if($config[sy_news_rewrite]=="2"){
								$rs[url] = $config[\'sy_weburl\']."/news/".$va."/";
								}else{
								  $rs[url]= Url(\'article\',array(\'c\'=>\'list\',"nid"=>$va),"1");
								}
							  $r_list[] = $rs;
							}
						  }
					  }
				  }
				 
					$group[$key][r_list] = $r_list;
					unset($r_list);
				}
				if(intval($paramer[len])>0){
					$len = intval($paramer[len]);
					$group[$key][name] = mb_substr($value[name],0,$len,"GBK");
				}
				if($group_type[$value[\'id\']]){
					$nids = $value[\'id\'].",".@implode(\',\',$group_type[$value[\'id\']]);
				}else{
					$nids = $value[\'id\'];
				}
				if($config[sy_news_rewrite]=="2"){
					$group[$key][url] = $config[\'sy_weburl\']."/news/".$value[id]."/";
				}else{
					 $group[$key][url] = Url(\'article\',array(\'c\'=>\'list\',"nid"=>$value[id]),"1");


				}
				if($config[did]){
					$newswhere=" and `did`=$config[did]";
				}
				if($paramer[arcpic]){
					$query = $db->query("SELECT * FROM `$db_config[def]news_base` WHERE `nid` IN ($nids) AND `newsphoto`<>\'\' $newswhere  ORDER BY `sort` DESC,`datetime` DESC limit $paramer[arcpic]");
					while($rs = $db->fetch_array($query)){
						if(intval($paramer[pt_len])>0){
							$len = intval($paramer[pt_len]);
							$rs[title] = mb_substr($rs[title],0,$len,"GBK");
						}

						if($rs[color]){

							$rs[title] = "<font color=\'".$rs[color]."\'>".$rs[title]."</font>";

						}
						if(intval($paramer[pd_len])>0){
							$len = intval($paramer[pd_len]);
							$rs[description] = mb_substr($rs[description],0,$len,"GBK");
						}
						foreach($group as $k=>$v){
							if($v[id]==$rs[nid]){
								$rs[name] = $v[name];
							}
						}
						if($config[sy_news_rewrite]=="2"){
							$rs["url"]=$config[\'sy_weburl\']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
						}else{
							$rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
						}
                        $picid[]=$rs[\'id\'];
						$arcpic[] = $rs;
					}
					$group[$key][arcpic] = $arcpic;
					unset($arcpic);
				}
				if($paramer[arclist]){
					$query = $db->query("SELECT * FROM `$db_config[def]news_base` WHERE `nid` IN ($nids) $newswhere  ORDER BY `sort` DESC,`datetime` DESC limit $paramer[arclist]");
					while($rs = $db->fetch_array($query)){
						if(intval($paramer[t_len])>0){
							$len = intval($paramer[t_len]);
							$rs[title] = mb_substr($rs[title],0,$len,"GBK");
						}

						if($rs[color]){

							$rs[title] = "<font color=\'".$rs[color]."\'>".$rs[title]."</font>";

						}
						if(intval($paramer[d_len])>0){
							$len = intval($paramer[d_len]);
							$rs[description] = mb_substr($rs[description],0,$len,"GBK");
						}
						foreach($group as $k=>$v){
							if($v[id]==$rs[nid]){
								$rs[name] = $v[name];
							}
						}
						if($config[sy_news_rewrite]=="2"){
							$rs["url"]=$config[\'sy_weburl\']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
						}else{
							$rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
						}
                        //去掉和图片资讯相同的一条，总条数是文字资讯条数加上图片资讯条数
                        if($paramer[arcpic]){
                            if(!in_array($rs[\'id\'],$picid)){
                               if(count($arclist)<($paramer[arclist]-1)){
            					    $arclist[] = $rs;
            					}
                            } 
                        }else{
                            if(count($arclist)<($paramer[arclist]-1)){
        					    $arclist[] = $rs;
        					}
                        }
					}
					$group[$key][arclist] = $arclist;
					unset($arclist);
				}
			}
		}';
        return SmartyOutputStr($this,$compiler,$_attr,'articleclass','$group',$OutputStr,'$group');
    }
}


class Smarty_Internal_Compile_Articleclasselse extends Smarty_Internal_CompileBase{


    public function compile($args, $compiler, $parameter){


        $_attr = $this->getAttributes($compiler, $args);





        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('articleclass'));


        $this->openTag($compiler, 'articleclasselse', array('articleclasselse', $nocache, $item, $key));





        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";


    }


}


class Smarty_Internal_Compile_Articleclassclose extends Smarty_Internal_CompileBase{


    public function compile($args, $compiler, $parameter){


        $_attr = $this->getAttributes($compiler, $args);


        if ($compiler->nocache) {


            $compiler->tag_nocache = true;


        }




        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('articleclass', 'articleclasselse'));





        return "<?php } ?>";


    }


}


