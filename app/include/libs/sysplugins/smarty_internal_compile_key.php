<?php
class Smarty_Internal_Compile_Key extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit', 'recom', 'type', 'iswap', 'order', 'len', 'tuijian');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }

        $OutputStr='global $config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');$list=array();
		if($paramer[recom]){
			$tuijian = 1;
		}
		if($paramer[type]){
			$type = $paramer[type];
		}
		if($paramer[limit]){
			$limit=$paramer[limit];
		}else{
			$limit=5;
		}
		include PLUS_PATH."/keyword.cache.php";
		if($paramer[iswap]){
			$wap = "/wap";
		}else{
			$index =1;
		}
		if(is_array($keyword)){
			if($paramer[iswap]){
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[tuijian]!=1){
						continue;
					}
					if($type && $v[type]!=$type){
						continue;
					}

					$i++;
					if($v[type]=="1"){
						$v[url] = Url("wap",array("c"=>"once","keyword"=>$v[\'key_name\']));
						$v[type_name]=\'店铺招聘\';
					}elseif($v[\'type\']=="13"){
						$v[\'url\'] = Url("wap",array("c"=>"tiny","keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'普工简历\';
					}elseif($v[type]=="3"){
						$v[url] = Url("wap",array("c"=>"job","keyword"=>$v[\'key_name\']));
						$v[type_name]=\'职位\';
					}elseif($v[\'type\']=="4"){
						$v[\'url\'] = Url("wap",array("c"=>"company","keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'公司\';
					}elseif($v[\'type\']=="5"){
						$v[\'url\'] = Url("wap",array("c"=>"resume","keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'人才\';
					}
					$v[\'key_title\']=$v[\'key_name\'];
					if($v[\'color\']){
						$v[\'key_name\']="<font color=\"".$v[\'color\']."\">".$v[\'key_name\']."</font>";
					}
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}else{
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[\'tuijian\']!=1){
						continue;
					}
					if($type && $v[\'type\']!=$type){
						continue;
					}
					$i++;
					if($v[\'type\']=="1"){
						$v[\'url\'] = Url("once",array("keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'店铺招聘\';
					}elseif($v[\'type\']=="2"){
						$v[\'url\'] = Url("part",array("keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'兼职\';
					}elseif($v[\'type\']=="13"){
						$v[\'url\'] = Url("tiny",array("keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'普工简历\';
					}elseif($v[\'type\']=="3"){
						$v[\'url\'] = Url("job",array("c"=>"search","keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'职位\';
					}elseif($v[\'type\']=="4"){
						$v[\'url\'] = Url("company",array("keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'公司\';
					}elseif($v[\'type\']=="5"){
						$v[\'url\'] = Url("resume",array("c"=>"search","keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'人才\';
					}else if($v[\'type\']=="12"){
						$v[\'url\'] = Url("ask",array("c"=>"search","keyword"=>$v[\'key_name\']));
						$v[\'type_name\']=\'问答\';
					}
					$v[\'key_title\']=$v[\'key_name\'];
					if($v[\'color\']){
						$v[\'key_name\']="<font color=\"".$v[\'color\']."\">".$v[\'key_name\']."</font>";
					}

					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}
		}';

        return SmartyOutputStr($this,$compiler,$_attr,'key','$list',$OutputStr,'$list');
    }
}
class Smarty_Internal_Compile_Keyelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('key'));
        $this->openTag($compiler, 'keyelse', array('keyelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Keyclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('key', 'keyelse'));

        return "<?php } ?>";
    }
}
