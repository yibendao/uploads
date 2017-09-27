<?php
class Smarty_Internal_Compile_Article extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 't_len', 'rec', 'limit', 'pic', 'd_len', 'type', 'urlstatic','print','order','ispage','nid','islt','cache','keyword');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        $name = $_attr['item'];
        $name=str_replace('\'','',$name);
        $name=$name?$name:'list';$name='$'.$name;
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }

        $OutputStr='global $db,$db_config,$config;include PLUS_PATH.\'/group.cache.php\';'.$name.'=array();$rs=null;$nids=null;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[\'arr\'];
		$Purl =  $ParamerArr[\'purl\'];
        if($paramer[cache]){
			$Purl="{{page}}.html";
		}
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where=1;
		if($config[\'did\']){
			$where.=" and `did`=\'".$config[\'did\']."\'";
		}
		include PLUS_PATH."/group.cache.php"; 
		if(is_array($paramer)){
			if($paramer[\'nid\']){
				$nid_s = @explode(\',\',$paramer[nid]);				
				foreach($nid_s as $v){
					if($group_type[$v]){
						$paramer[nid] = $paramer[nid].",".@implode(\',\',$group_type[$v]);
					}
				}
			}
			
			if($paramer[\'nid\']!=""){
				$where .=" AND `nid` in ($paramer[nid])";
				$nids = @explode(\',\',$paramer[\'nid\']);$paramer[\'nid\']=$paramer[\'nid\'];
			}else if($paramer[\'rec\']!=""){
				$nids=array();if(is_array($group_rec)){
					foreach($group_rec as $key=>$value){
						if($key<=2){
							$nids[]=$value;
						}
					}
					$paramer[nid]=@implode(\',\',$nids);
				}
			}
			
			if($paramer[\'type\']){
				$type = str_replace("\"","",$paramer[type]);
				$type_arr =	@explode(",",$type);
				if(is_array($type_arr) && !empty($type_arr)){
					foreach($type_arr as $key=>$value){
						$where .=" AND FIND_IN_SET(\'".$value."\',`describe`)";
						if(count($nids)>0){
							$picwhere .=" AND FIND_IN_SET(\'".$value."\',`describe`)";
						}
					}
				}
			}
			if($paramer[\'pic\']!=""){
				$where .=" AND `newsphoto`<>\'\'";
			}
			if($paramer[\'keyword\']!=""){
				$where .=" AND `title` LIKE \'%".$paramer[keyword]."%\'";
			}
			
			if(intval($paramer[\'limit\'])>0){
				$limit = intval($paramer[\'limit\']);
				$limit = " limit ".$limit;
			}
			if($paramer[\'ispage\']){
				if($Purl["m"]=="wap"){
					$limit = PageNav($paramer,$_GET,"news_base",$where,$Purl,"","6",$_smarty_tpl);
				}else{
					$limit = PageNav($paramer,$_GET,"news_base",$where,$Purl,"","5",$_smarty_tpl);
				}
			}
			if($paramer[\'order\']!=""){
				$order = str_replace("\'","",$paramer[\'order\']);
				$where .=" ORDER BY $order";
			}else{
				$where .=" ORDER BY `datetime`";
			}
			if($paramer[\'sort\']){
				$where.=" ".$paramer[sort];
			}else{
				$where.=" DESC";
			}
		}

		if(!intval($paramer[\'ispage\']) && count($nids)>0){
			$nidArr = @explode(\',\',$paramer[nid]);
			$rsnids = \'\';
			if(is_array($group_type)){
				foreach($group_type as $key=>$value){
					if(in_array($key,$nidArr)){						
						if(is_array($value)){
							foreach($value as $v){
								$rsnids[$v] = $key;
								$nidArr[] = $v;
							}
						}
					}
				}							
			}
			$where = " `nid` IN (".@implode(\',\',$nidArr).")";
			if($config[\'did\']){
				$where.=" and `did`=\'".$config[\'did\']."\'";
			}
			if($paramer[\'pic\']){
				if(!$paramer[\'piclimit\']){
					$piclimit = 1;
				}else{
					$piclimit = $paramer[\'piclimit\'];
				}
				$db->query("set @f=0,@n=0");
				$query = $db->query("select * from (select id,title,color,datetime,description,newsphoto,@n:=if(@f=nid,@n:=@n+1,1) as aid,@f:=nid as nid from $db_config[def]news_base  WHERE ".$where." AND `newsphoto` <>\'\'  order by nid asc,datetime desc) a where aid <=".$piclimit);
				while($rs = $db->fetch_array($query)){
					if($rsnids[$rs[\'nid\']]){
						$rs[\'nid\'] = $rsnids[$rs[\'nid\']];
					}
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
					$rs[\'name\'] = $group_name[$rs[\'nid\']];

					if($config[sy_news_rewrite]=="2"){
						$rs["url"]=$config[\'sy_weburl\']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
					}else{
						$rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
					}
					if(mb_substr($rs[newsphoto],0,4)=="http"){
						$rs["picurl"]=$rs[newsphoto];
					}else{
						$rs["picurl"] = $config[\'sy_weburl\']."/".$rs[newsphoto];
					}
					$rs[time]=date("Y-m-d",$rs[datetime]);
					$rs[\'datetime\']=date("m-d",$rs[datetime]);
					if(count('.$name.'[$rs[\'nid\']][\'pic\'])<$piclimit){
					    '.$name.'[$rs[\'nid\']][\'pic\'][] = $rs;
					}
				
				}
			}
			
            $db->query("set @f=0,@n=0");
            $query = $db->query("select * from (select id,title,datetime,color,description,newsphoto,@n:=if(@f=nid,@n:=@n+1,1) as aid,@f:=nid as nid from $db_config[def]news_base  WHERE ".$where." order by nid asc,datetime desc) a where aid <=$paramer[limit]");

            while($rs = $db->fetch_array($query)){
				if($rsnids[$rs[\'nid\']]){
						$rs[\'nid\'] = $rsnids[$rs[\'nid\']];
					}
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
                $rs[\'name\'] = $group_name[$rs[\'nid\']];
                if($config[sy_news_rewrite]=="2"){
                    $rs["url"]=$config[\'sy_weburl\']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
                }else{
                    $rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
                }
				if(mb_substr($rs[newsphoto],0,4)=="http"){
						$rs["picurl"]=$rs[newsphoto];
					}else{
						$rs["picurl"] = $config[\'sy_weburl\']."/".$rs[newsphoto];
					}
                $rs[time]=date("Y-m-d",$rs[datetime]);
                $rs[datetime]=date("m-d",$rs[datetime]);
				if(count('.$name.'[$rs[\'nid\']][\'arclist\'])<$paramer[limit]){
					'.$name.'[$rs[\'nid\']][\'arclist\'][] = $rs;
				}
                
            }
		}else{
			$query = $db->query("SELECT * FROM `$db_config[def]news_base` WHERE ".$where.$limit);
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
                $rs[\'name\'] = $group_name[$rs[\'nid\']];
                if($config[sy_news_rewrite]=="2"){
                    $rs["url"]=$config[\'sy_weburl\']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
                }else{
                    $rs["url"] = Url("article",array("c"=>"show","id"=>$rs[id]),"1");
                }
				if(mb_substr($rs[newsphoto],0,4)=="http"){
						$rs["picurl"]=$rs[newsphoto];
					}else{
						$rs["picurl"] = $config[\'sy_weburl\']."/".$rs[newsphoto];
					}
                $rs[time]=date("Y-m-d",$rs[datetime]);
                $rs[datetime]=date("m-d",$rs[datetime]);
                '.$name.'[] = $rs;
            }
		}';
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'article',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Articleclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('article', 'articleelse'));

        return "<?php } ?>";
    }
}
