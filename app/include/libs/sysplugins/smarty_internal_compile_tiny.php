<?php
class Smarty_Internal_Compile_Tiny extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'add_time', 'ispage', 'limit', 'keyword','delid','islt');
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

        $OutputStr='global $db,$db_config,$config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');'.$name.'=array();
		include PLUS_PATH."/user.cache.php";
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where = "status=\'1\' ";
		
		if($paramer[keyword]){
			$where.=" AND `username` LIKE \'%".$paramer[keyword]."%\' or `job` LIKE \'%".$paramer[keyword]."%\'";
		}
		if($config[did]){
			$where.=" AND `did`=\'".$config[\'did\']."\'";
		}
		if($paramer[\'add_time\']>0){
			$time=time()-$paramer[\'add_time\']*86400;
			$where.=" and `lastupdate`>".$time;
		}
		if($paramer[\'delid\']){
			$where.=" AND `id`<>\'".$paramer[\'delid\']."\'";
		}
		if($paramer[\'order\']){
			$order = " ORDER BY `".str_replace("\'","",$paramer[order])."`";
		}else{
			$order = " ORDER BY lastupdate ";
		}
		if($paramer[\'sort\']){
			$sort = $paramer[\'sort\'];
		}else{
			$sort = " DESC";
		}
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}else{
			$limit=" LIMIT 20";
		}

		if($paramer[where]){
			$where = $paramer[where];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"resume_tiny",$where,$Purl,\'\',\'0\',$_smarty_tpl);
		}
		$where.=$order.$sort.$limit;
		'.$name.'=$db->select_all("resume_tiny",$where);
		include(CONFIG_PATH."db.data.php");		
		if(is_array('.$name.')){
			foreach('.$name.' as $key=>$value){
				if($value[lastupdate]=\'\'){
					$value[lastupdate] = $value[time];
				}
				$time=$value[\'lastupdate\'];
				$beginToday=mktime(0,0,0,date(\'m\'),date(\'d\'),date(\'Y\'));
				$beginYesterday=mktime(0,0,0,date(\'m\'),date(\'d\')-1,date(\'Y\'));
				$week=strtotime(date("Y-m-d",strtotime("-1 week")));
				if($time>$week && $time<$beginYesterday){
					'.$name.'[$key][\'lastupdate\'] = "一周内";
				}elseif($time>$beginYesterday && $time<$beginToday){
					'.$name.'[$key][\'lastupdate\'] = "昨天";
				}elseif($time>$beginToday){
					'.$name.'[$key][\'lastupdate\'] = "今天";
					'.$name.'[$key][\'redtime\'] =1;
				}else{
					'.$name.'[$key][\'lastupdate\'] = date("Y-m-d",$value[\'lastupdate\']);
					
				}
				'.$name.'[$key][\'sex\'] =$arr_data[\'sex\'][$value[\'sex\']];
				'.$name.'[$key][\'exp_name\'] =$userclass_name[$value[\'exp\']];
			}
		}
		if(is_array('.$name.')){
			if($paramer[keyword]!=""&&!empty('.$name.')){
				addkeywords(\'1\',$paramer[keyword]);
			}
		}';
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'tiny',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Tinyelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('tiny'));
        $this->openTag($compiler, 'tinyelse', array('tinyelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Tinyclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('tiny', 'tinyelse'));

        return "<?php } ?>";
    }
}
