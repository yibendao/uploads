<?php
class Smarty_Internal_Compile_Qcache extends Smarty_Internal_CompileBase{
	
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'classid','limit','son');
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
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
        global $ModuleName;

		include(PLUS_PATH.\'/ask.cache.php\');
		
		if(!$paramer[classid])
		{
			$askArr = $ask_index;

		}else{
			$askArr = @explode(\',\',$paramer[classid]);
		}
		$i=0;
		foreach($askArr as $key=>$value)
		{
			$i++;
			$askArray[\'key\'] = $i;
			$askArray[\'id\'] = $value;
			$askArray[\'name\'] = $ask_name[$value];
			$askArray[\'pic\'] = $ask_pic[$value]; 
			$askArray[\'intro\'] = $ask_intro[$value];
			'.$name.'[] = $askArray;
			if($paramer[limit] && $i>=$paramer[limit])
			{
				break;
			} 
		}
		if($paramer[son]){
			foreach('.$name.' as $key=>$val){ 
				foreach($ask_type[$val[\'id\']] as $v){
					'.$name.'[$key][son][]=array(\'name\'=>$ask_name[$v],"id"=>$v);
				} 
			}
		}  
		';
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'qcache',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Qcacheelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('qcache'));
        $this->openTag($compiler, 'qcacheelse', array('qcacheelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Qcacheclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('qcache', 'qcacheclose'));

        return "<?php } ?>";
    }
}
