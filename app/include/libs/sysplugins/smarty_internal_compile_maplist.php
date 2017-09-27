<?php
class Smarty_Internal_Compile_Maplist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'ispage', 'notpl', 'isjob', 'keyword', 'hy', 'pr', 'lastupdate', 'job1', 'job1_son', 'job_post', 'provinceid', 'cityid', 'three_cityid', 'limit', 'r', 'x', 'y', 'z');
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

		$time = time();
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where=1;
		$xy=getAround($paramer[x],$paramer[y],$paramer[r]);
		if($config[sy_web_site]=="1"){
			if($config[province]>0 && $config[province]!=""){
				$paramer[provinceid] = $config[province];
			}
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid]=$config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}
		if($xy[0]){
			$where.=" AND `x`>=\'".$xy[0]."\' AND `x`<=\'".$xy[1]."\' AND `y`>=\'".$xy[3]."\' AND `y`<=\'".$xy[2]."\'";
		}
		if($paramer[keyword]){
			$where.=" AND `name` LIKE \'%".$paramer[keyword]."%\'";
		}
		if($paramer[hy]){
			$where .= " AND `hy` = \'".$paramer[hy]."\'";
		}
		if($paramer[pr]){
			$where .= " AND `pr` = \'".$paramer[pr]."\'";
		}
		if($paramer[mun]){
			$where .= " AND `mun` = \'".$paramer[mun]."\'";
		}
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = \'".$paramer[provinceid]."\'";
		}
		if($paramer[cityid]){
			$where .= " AND (`cityid` = \'".$paramer[cityid]."\' or `provinceid` = \'".$paramer[cityid]."\')";
		}
		if($paramer[three_cityid]){
			$where .= " AND `three_cityid` = \'".$paramer[three_cityid]."\'";
		}
		if($paramer[linkman]){
			$where .= " AND `linkman`<>\'\'";
		}
		if($paramer[linktel]){
			$where .= " AND `linktel`<>\'\'";
		}
		if($paramer[linkmail]){
			$where .= " AND `linkmail`<>\'\'";
		}
		if($paramer[logo]){
			$where .= " AND `logo`<>\'\'";
		}
		if($paramer[\'lastupdate\']){
			$lastupdate = $time-$paramer[\'lastupdate\']*3600;
			$where.=" AND `lastupdate`>\'".$lastupdate."\'";
		}
		if($paramer[r_status]){
			$where .= " AND `r_status`=\'".$paramer[\'r_status\']."\'";
		}else{
			$where .= " AND `r_status`<>\'2\'";
		}
		if($paramer[\'cert\']){
			$where .= " AND `yyzz_status`=\'1\'";
		}
		if($paramer[jobtime]){
			$where.=" AND `jobtime`<>\'\'";
		}
		$jobwhere=1;
		if($paramer[job1]){
			$jobwhere.=" AND `job1`=\'$paramer[job1]\'";
		}
		if($paramer[job1_son]){
			$jobwhere.=" AND `job1_son`=\'$paramer[job1_son]\'";
		}
		if($paramer[job_post]){
			$jobwhere.=" AND `job_post`=\'$paramer[job_post]\'";
		}
		$joball=$db->select_all("company_job",$jobwhere,"`uid`");
		if(is_array($joball)){
			foreach($joball as $v){
				$uid[]=$v[uid];
			}
			$uid=@implode(",",$uid);
			$where.=" and `uid` in ($uid)";
		}
		
		if($paramer[limit]){
			$limit.=" limit ".$paramer[limit];
		}
		$where.=$order.$sort;
		if($paramer[where]){
			$where = $paramer[where];
		}
		$cache_array = $db->cacheget();

		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company","`x`<>\'\' and ".$where,$Purl,"","0",$_smarty_tpl);
		}
		if($paramer[order]){
			$order = " ORDER BY `".$paramer[order]."`  ";
		}else{
			$order = " ORDER BY `jobtime` ";
		}
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		}
		$Query = $db->query("SELECT * FROM $db_config[def]company where x<>\'\' and ".$where.$limit);
		while($rs = $db->fetch_array($Query)){
			'.$name.'[] = $db->array_action($rs,$cache_array);
			$ListId[] =  $rs[uid];
		}
        //$comnum = $db->select_num("company","x!=\'\' and ".$where);

		if($paramer[isjob]){
			$JobId = @implode(",",$ListId);
			$JobList=$db->select_all("company_job","`uid` IN ($JobId) and `edate`>\'".mktime()."\' and r_status<>\'2\' and status<>\'1\' and state=1 order by `lastupdate` desc");
            if(is_array($ListId) && is_array($JobList)){
				foreach('.$name.' as $key=>$value){
					'.$name.'[$key][jobnum] = 0;
					foreach($JobList as $k=>$v){
						if($value[uid]==$v[uid]){
							'.$name.'[$key][newsjob] = $v[name];
							'.$name.'[$key][newsjob_status] = $v[status];
							'.$name.'[$key][r_status] = $v[r_status];
							'.$name.'[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$v[id]),"1");
							$jobv = $db->array_action($v,$cache_array);
							$jobv[\'name\'] = '.$name.'[$key][newsjob];
							$jobv[job_url] = Url("job",array("c"=>"comapply","id"=>$v[id]),"1");
							'.$name.'[$key][joblist][] = $jobv;
							'.$name.'[$key][jobnum] = '.$name.'[$key][jobnum]+1;
						}
					}
				}
			}
		}
		if(is_array('.$name.')){
			$num=0;
			foreach('.$name.' as $key=>$value){
				'.$name.'[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				'.$name.'[$key][joball_url] = Url("company",array("c"=>"show","id"=>$value[uid],"tp"=>"post"));
				'.$name.'[$key][\'orderid\']=$num;
				if(!$value[x] && !$value[y]){
					$address=$value[job_city_one].$value[job_city_two].$value[address];
					$xydata=@file_get_contents("http://api.map.baidu.com/geocoder?address=".$address."&output=json&key=37492c0ee6f924cb5e934fa08c6b1676");
					$name=json_decode($xydata);
					'.$name.'[$key][x]=$name->result->location->lng;
					'.$name.'[$key][y]=$name->result->location->lat;
				}
				$num++;
			}
			if($paramer[keyword]!=""&&!empty('.$name.')){
				addkeywords(\'4\',$paramer[keyword]);
			}
		}';
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'maplist',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Maplistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('maplist'));
        $this->openTag($compiler, 'maplistelse', array('maplistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Maplistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('maplist', 'maplistelse'));

        return "<?php } ?>";
    }
}
