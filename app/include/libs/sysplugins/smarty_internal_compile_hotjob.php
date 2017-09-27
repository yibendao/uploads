<?php
class Smarty_Internal_Compile_Hotjob extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit');
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

        $uptime=$_attr['uptime'];
        $order=$_attr['order'];
        $sort=$_attr['sort'];
        $limit=$_attr['limit'];
        $where=$_attr['where'];
        $ispage=$_attr['ispage'];

        $OutputStr='global $db,$db_config,$config;
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		if($config[sy_web_site]=="1"){
			$jobwhere="";
			if($config[province]>0 && $config[province]!=""){
				$jobwhere.=" and `provinceid`=\'$config[province]\'";
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$jobwhere.=" and `cityid`=\'$config[cityid]\'";
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$jobwhere.=" and `three_cityid`=\'$config[three_cityid]\'";
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$jobwhere.=" and `hy`=\'".$config[hyclass]."\'";
			} 
			if($jobwhere){
				$comlist=$db->select_all("company","1 ".$jobwhere,"`uid`");
				if(is_array($comlist)){
					foreach($comlist as $v){
						$cuid[]=$v[uid];
					}
				}
				$hotwhere=" and `uid` in (".@implode(",",$cuid).")";
			} 
		}
		$time = time();
		$where = "`time_start`<$time AND `time_end`>$time".$hotwhere;';
		if($uptime){
			$OutputStr.='$uptime = $time-'.$uptime.'*3600;
			$where.=" AND `lastupdate`>\'".$uptime."\'";';
		}
		$OutputStr.='$order = " ORDER BY `'.($order?$order:'sort').'` ";';
		$OutputStr.='$sort = \''.($sort?$sort:'ASC').'\';';
		if($limit){
			$OutputStr.='$limit=" LIMIT '.$limit.'";';
		}
		
		if($where){
			$OutputStr.='$where = \''.$where.'\';';
		}
		if($ispage){
			$OutputStr.='$limit = PageNav($paramer,$_GET,"hotjob",$where,$Purl,\'0\',$_smarty_tpl);';
		}
		$OutputStr.='$where.=$order.$sort;';
		$OutputStr.='
        $Query = $db->query("SELECT * FROM $db_config[def]hotjob where ".$where.$limit);
		while($rs = $db->fetch_array($Query)){
			'.$name.'[] = $rs;
			$ListId[] =  $rs[uid];
		}

		$JobId = @implode(",",$ListId);
		$JobList=$db->select_all("company_job","`uid` IN ($JobId) and `edate`>\'".mktime()."\' and state=1 and r_status<>\'2\' and status<>\'1\' $jobwhere");
		$statis=$db->select_all("company_statis","`uid` IN ($JobId)","`uid`,`comtpl`");
		if(is_array($ListId)){
			$cache_array = $db->cacheget();
			foreach('.$name.' as $key=>$value){
				$i=0;
				if(is_array($JobList)){
					'.$name.'[$key]["job"].="<div class=\"area_left\"> ";
					foreach($JobList as $k=>$v){
						if($value[uid]==$v[uid] && $i<5){
							$job_url = Url("job",array("c"=>"comapply","id"=>"$v[id]"),"1");
							$v[name] = mb_substr($v[name],0,10,"GBK");
							'.$name.'[$key]["job"].="<a href=\'".$job_url."\'>".$v[name]."</a>";
							$i++;
						}
					}
					foreach($statis as $v){
						if($value[\'uid\']==$v[\'uid\']){
							if($v[\'comtpl\'] && $v[\'comtpl\']!="default"){
								$jobs_url = Url("company",array("c"=>"show","id"=>$value[uid]))."#job";
							}else{
								$jobs_url = Url("company",array("c"=>"show","id"=>$value[uid]));
							}
						}
					}
					$com_url = Url("company",array("c"=>"show","id"=>$value[uid]));
					$beizhu=mb_substr($value[\'beizhu\'],0,50,"GBK")."...";
					'.$name.'[$key]["job"].="</div><div class=\"area_right\"><a href=\'".$com_url."\'>".$value["username"]."</a>".$beizhu."</div>";
					'.$name.'[$key]["url"]=$com_url;
				}
			}
		}';
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'hotjob',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Hotjobelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('hotjob'));
        $this->openTag($compiler, 'hotjobelse', array('hotjobelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Hotjobclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('hotjob', 'hotjobelse'));

        return "<?php } ?>";
    }
}
