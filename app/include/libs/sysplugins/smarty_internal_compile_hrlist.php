<?php
class Smarty_Internal_Compile_Hrlist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit', 'order', 'id', 'keyword','ispage');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }
		
        $OutputStr='global $db,$db_config,$config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');$List=array();
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
		$where = "`is_show`=\'1\'";
		global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		if($paramer[\'id\']){
			$where.=" and `cid`=\'".$paramer[\'id\']."\'";
		}
		if($paramer[\'keyword\']){
			$where.=" AND `name` LIKE \'%".$paramer[\'keyword\']."%\'";
		}
		
		if($paramer[\'limit\']){
			$limit=" LIMIT ".$paramer[\'limit\'];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"toolbox_doc",$where,$Purl,\'\',\'0\',$_smarty_tpl);
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
		$List=$db->select_all("toolbox_doc",$where.$limit);';

        return SmartyOutputStr($this,$compiler,$_attr,'hrlist','$List',$OutputStr,'$List');
    }
}
class Smarty_Internal_Compile_Hrlistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('hrlist'));
        $this->openTag($compiler, 'hrlistelse', array('hrlistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Hrlistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('hrlist', 'hrlistelse'));

        return "<?php } ?>";
    }
}
