<?php
class Smarty_Internal_Compile_Commsg extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit', 'order', 'id','jobid', 'keyword','ispage');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
		$name = $_attr['item'];
        $name=str_replace('\'','',$name);
        $name=$name?$name:'List';$name='$'.$name;
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }
		
        $OutputStr='global $db,$db_config,$config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');$List=array();
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
		$where = "`status`=\'1\'";
		global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		if($paramer[\'id\']){
			$where.=" and `cuid`=\'".$paramer[\'id\']."\'";
		}
		if($paramer[\'jobid\']){
			$where.=" and `jobid`=\'".$paramer[\'jobid\']."\'";
		}
		
		if($paramer[\'limit\']){
			$limit=" LIMIT ".$paramer[\'limit\'];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_msg",$where,$Purl,\'\',\'0\',$_smarty_tpl);
		}
		if($paramer[order]){
			$where.="  ORDER BY `".$paramer[\'order\']."`";
		}else{
			$where.="  ORDER BY `id`";
		}
		if($paramer[\'sort\']){
			$where.=" ".$paramer[\'sort\'];
		}else{
			$where.=" DESC";
		}

		'.$name.'=$db->select_all("company_msg",$where.$limit);
		
		if(is_array('.$name.')){
			include  PLUS_PATH."/com.cache.php";
			foreach('.$name.' as $key=>$value){
				
				$UIDList[]=$value[\'uid\'];
				$Jobid[] = $value[\'jobid\'];
			
			}
			$userlist=$db->select_all("resume","`uid` IN (".@implode(\',\',$UIDList).")","`uid`,`name`,`photo`");

			$jobList=$db->select_all("company_job","`id` IN (".@implode(\',\',$Jobid).")","`id`,`name`");
			
			if(is_array($userlist)){
				foreach($userlist as $v){
							
					$msgUser[$v[\'uid\']]= $v[\'name\'];
					$msgPhoto[$v[\'uid\']]= $v[\'photo\'];
				}
			}
			
			if(is_array($jobList)){
				foreach($jobList as $vv){
							
					$msgJob[$vv[\'id\']]= $vv[\'name\'];
						
				}
				$_smarty_tpl->tpl_vars[\'msgjob\']=new Smarty_Variable;
				$_smarty_tpl->tpl_vars[\'msgjob\']->value = $jobList;
			}
			
            foreach('.$name.' as $k=>$v){
				if($v[\'isnm\']==\'1\'){
					'.$name.'[$k][\'name\']= \'ÄäÃû\';
					'.$name.'[$k][\'photo\']= $config[\'sy_weburl\']."/".$config[\'sy_member_icon\'];
				}else{
					if($msgPhoto[$v[\'uid\']] &&file_exists(str_replace($config[\'sy_weburl\'],APP_PATH,\'.\'.$msgPhoto[$v[\'uid\']]))){
						'.$name.'[$k][\'photo\']= ".".$msgPhoto[$v[\'uid\']];
					}else{
						'.$name.'[$k][\'photo\']= $config[\'sy_weburl\']."/".$config[\'sy_member_icon\'];
					}
					'.$name.'[$k][\'name\']= $msgUser[$v[\'uid\']];
				}
				'.$name.'[$k][\'comscore\']= sprintf("%.1f", $v[comscore]);
				'.$name.'[$k][\'hrscore\']= sprintf("%.1f", $v[hrscore]);
				'.$name.'[$k][\'desscore\']= sprintf("%.1f", $v[desscore]);
			
				'.$name.'[$k][\'scorepf\']= round( $v[score]/5 * 100,2);
				'.$name.'[$k][\'comscorepf\']= round( $v[comscore]/5 * 100,2);
				'.$name.'[$k][\'hrscorepf\']= round( $v[hrscore]/5 * 100,2);
				'.$name.'[$k][\'desscorepf\']= round( $v[desscore]/5 * 100,2);
				if($v[tag]){
					$tags = explode(\',\',$v[tag]);
					$newtags = array();
					foreach($tags as $tv){
						$newtags[] = $comclass_name[$tv];
					}
					
					'.$name.'[$k][\'tags\']= $newtags;
				}
				'.$name.'[$k][\'jobname\']= $msgJob[$v[\'jobid\']];
            }
		}
		';

        return SmartyOutputStr($this,$compiler,$_attr,'commsg',$name,$OutputStr,$name);
    }
}
class Smarty_Internal_Compile_Commsgelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('commsg'));
        $this->openTag($compiler, 'commsgelse', array('commsgelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Commsgclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('commsg', 'commsgelse'));

        return "<?php } ?>";
    }
}
