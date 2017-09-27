<?php
function get_seo_url($paramer,$config,$seo,$type=''){
	global $adminDir;
	$rewrite_url = '';
	if($paramer['url']){
		$urNewArr = @explode(',',$paramer['url']);
		foreach($urNewArr as $key=>$value){
			if($value){
				$valueNewArr = @explode(':',$value);
				$paramer[$valueNewArr[0]] = $valueNewArr[1];
			}
		}
		unset($paramer['url']);
	}

	if(!$paramer['m']){
		$paramer['m'] = 'index';
	}
	if($config['sy_'.$type.'domain'] && $type!='index'){
	    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
		$defaultUrl = $protocol.$config['sy_'.$type.'domain'];
	}elseif(trim($config['sy_'.$type.'dir'])){
		$defaultUrl = $config['sy_weburl']."/".$config['sy_'.$type.'dir']."/";
	}else{
		$defaultUrl = $config['sy_weburl']."/";
	}

	if(trim($config['sy_'.$type.'dir'])){
        $typeDir=$type;
	}
	
	$url="index.php?";

	foreach($seo as $k=>$v){
		$v = reset($v);
		$urlFileds=array();
		if($v['rewrite_url'] && $v['php_url']){
			$vUrl = @explode('?',$v['php_url']);
			$urlArray = array();
			if($vUrl[1]){
				$urlArray = @explode("&",$vUrl[1]);
				foreach($urlArray as $key=>$value){
					$valueArray = @explode('=',$value);
					if($valueArray[0]){
						$urlFileds[$valueArray[0]] = $valueArray[1];
					}
				}
			}

			if($type!=''){

				if($config['sy_'.$type.'dir']){
					$defaultUrl  = str_replace('/'.$config['sy_'.$type.'dir'].'/','/',$defaultUrl);
					$urlDir = array_filter(@explode('/',$vUrl[0]));
					if(reset($urlDir) == $typeDir){
						if($paramer['c']==$urlFileds['c'] && $paramer['a']==$urlFileds['a']){
							$rewrite_url=$defaultUrl.(substr($v['rewrite_url'],0,1)=='/'?substr($v['rewrite_url'],1):$v['rewrite_url']);
							break;
						}
					}
				}

			}else{
				if(!$urlFileds['m']){
					$urlFileds['m'] = 'index';
				}
				if((!$paramer['c'] && $paramer['m']==$urlFileds['m'] && !$urlFileds['c']) || ($paramer['c'] && $paramer['m']==$urlFileds['m'] && $paramer['c']==$urlFileds['c'])){
					$rewrite_url=$type.$v['rewrite_url'];
					break;
				}
			}
		}
	}
	if($rewrite_url){
		foreach($paramer as $key=>$value){
			$rewrite_url = str_replace("{".$key."}",$value,$rewrite_url);
		}
        $model=(($config['sy_'.$m.'_web']==1)&&(trim($config['sy_'.$m.'dir']))?$config['sy_'.$m.'dir']:$paramer['m']);
		$rewrite_url = str_replace('{page}',"1", $rewrite_url);
		$rewrite_url = preg_replace('/{(.*?)}/',"", $rewrite_url);
        $rewrite_url=str_replace('m='.$paramer['m'],'m='.$model, $rewrite_url);
        $rewrite_url=str_replace('m_'.$paramer['m'],'m_'.$model, $rewrite_url);
        $rewrite_url=str_replace('/'.$paramer['m'].'/','/'.$model.'/', $rewrite_url);

		return $rewrite_url;
	}
	return null;
}
function formatparamer($paramer,$_smarty_tpl){
    foreach($paramer as $key=>$value){
        $NewUrl=$value;
        if(strstr($NewUrl,'`')){
            $NewValue='';
            $ValueList=explode('`',$NewUrl);
            foreach($ValueList as $k=>$v){
                if(trim($v)!=''){
                    if($k%2==1){
                        if(strstr($v,'$')){
                            $ValueList1=explode('$',$v);
                            $ValueList2=explode('.',$ValueList1[1]);
                            $CurrentValue=null;
                            foreach($ValueList2 as $kk=>$vv){
                                if(trim($vv)!=''){
                                    if($kk==0){
                                        $CurrentValue=$_smarty_tpl->tpl_vars[$vv]->value;
                                    }else{
                                        $CurrentValue=$CurrentValue[$vv];
                                    }
                                }
                            }
                            $NewValue.=$CurrentValue;
                        }
                    }else{
                        $NewValue.=$v;
                    }
                }
            }
            $paramer[$key]=$NewValue;
        }
    }
    return $paramer;
}
function get_url($paramer,$config,$seo,$type='',$index='',$_smarty_tpl=''){
	global $ModuleName,$adminDir;

    if($_smarty_tpl){
		$paramer=formatparamer($paramer,$_smarty_tpl);
	}

    if($type){
        if($config['sy_'.$type.'domain'] && $type!='index'){
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
            if(strpos($config['sy_'.$type.'domain'],$protocol)===false){
				$defaultUrl = "http://".$config['sy_'.$type.'domain'];
			}else{
				$defaultUrl = $config['sy_'.$type.'domain'];
			}
            $defaultUrlRewrite = $defaultUrl;
            unset($paramer['m']);
        }else{
			if(($ModuleName!=$adminDir && $ModuleName!='siteadmin') || !$ModuleName){
				$typeDir = $config['sy_'.$type.'dir'];
			}

            $defaultUrl = $config['sy_weburl'];
            $defaultUrlRewrite = $config['sy_weburl'];
        }
    }else{
        $defaultUrl = $config['sy_weburl'];
        $defaultUrlRewrite = $config['sy_weburl'];
    }

	if($typeDir){
		$defaultUrl .= "/".$typeDir;
        $defaultUrlRewrite .= "/".$typeDir;
		unset($paramer['m']);
	}else{
		if(empty($paramer['m']) && (!$config['sy_'.$type.'domain'] || $type=='index')){
			$m='index';
		}else{
			$m=$paramer['m'];
		}
	}
	if(is_array($paramer)){
		foreach($paramer as $k=>$v){
			if($k!="m" && $k!="con"){
				$paramers[]=$k.":".$v;
			}
		}
	}

    if($index=='admin'){
        global $ModuleName;
        $url=$ModuleName.'/'.$url;
    }

    if($config['sy_seo_rewrite'] && $index!='admin' && $index!='member' && $paramer['m']!='ajax' && $paramer['m']!='member'){
		
		$seourl=get_seo_url($paramer,$config,$seo,$type);

        if($seourl){
            return $seourl;
        }

        if($m!='index' && !empty($m)){
            $urlarr['m']=str_replace('_','',str_replace('-','',$m));
        }
        if($paramers){
            $p='';
            foreach($paramers as $v){
                if(!empty($v)){
                    $url_info = @explode(":",$v);
					$urlarr[$url_info[0]]=str_replace('_','',str_replace('-','',$url_info[1]));
                }
            }
        }

        if($urlarr){
            foreach($urlarr as $k=>$v){
                $a[]=$k.'_'.$v;
            }
            $urltemp=@implode('-',$a);
            $url.=$urltemp.'.html';
            $url=$defaultUrlRewrite."/".$url;
        }else{
            $url=$defaultUrlRewrite."/";
        }
    }else{
        if($index=='member'){
            $url=$url.'member/';
        }

        if($index!='admin' && ($config['sy_'.$m.'_web']==1)&&(trim($config['sy_'.$m.'dir']))&&(!trim($config['sy_'.$m.'domain']))){
            $url=$config['sy_'.$m.'dir'].'/'.$url;unset($m);unset($paramer['m']);
        }

        if($m=='index'){
            $url.='index.php';
        }elseif($m=='member'){
            $url.='member/index.php?';
        }else{
			if($m){
				$url.='index.php?'.($m?'&m='.$m:'');
			}
        }

        if($paramers){
            $p='';
            foreach($paramers as $v){
                if(!empty($v)){
					$url_info = @explode(":",$v);
					$p.='&'.$url_info[0].'='.$url_info[1];
                }
            }
            if(strpos($url,'?')){
                $url.=$p;
            }else if($m=='index'){
                $url.='?'.substr($p,1);
            }else{
            	$url.='index.php?'.substr($p,1);
            }
        }
        $url=$defaultUrl.'/'.$url;
    }

	$url=FormatUrl($url);
    return $url;
}
function FormatUrl($url){
   
    $url=str_replace('?&','?',$url);
    return $url;
}
function addkeywords($type,$keyword){
    global $db,$db_config,$config;
    $info = $db->DB_select_once("hot_key","`key_name`='$keyword' AND `type`='$type'");
    if(is_array($info)){
        $db->update_all("hot_key","`num`=`num`+1","`key_name`='$keyword' AND `type`='$type'");
    }else{
        $db->insert_once("hot_key","`key_name`='$keyword',`num`='1',`type`='$type',`check`='0'");
    }
}
function PageNav($paramer,$get,$table,$where,$Purls,$table2="",$islt='0',$_smarty_tpl){

    global $db,$db_config,$config;
	
	$url=array();
    if($paramer['islt']){
        $islt=$paramer['islt'];
    }
    $page=$get[page]<1?1:$get[page];
    if($get['c']){
        $urlarr["c"]=$get['c'];
        $Purl['c'] = $get['c'];
    }
    if($get['a']){
        $urlarr["a"]=$get['a'];
        $Purl["a"]	=$get['a'];
    }
    $urlarr["page"]="{{page}}";
    $Purl["page"]="{{page}}";
	if(!empty($Purls)){
		$Purl = array_merge($Purl,$Purls);
	}
    if(is_array($Purl)){
        foreach($Purl as $key=>$value){
            if($value!=""){
                $urlarr[$key] = $value;
            }
        }
    }
    if($islt=="1"){
        $lturl=array();
        if(is_array($urlarr)){
            foreach($urlarr as $k=>$v){
                $url[$k]=$v;
            }
        }
        $pageurl = Url('lietou',$url);
    }else if($islt=="2"){
        foreach($urlarr as $k=>$v){
            $url[$k]=$v;
        }
        $pageurl = Url('ask',$url);
    }else if($islt=="3"){
        foreach($get as $k=>$v){
            $url[]=$k."=".$v;
        }
        $memberurl=@implode("&",$url);

        $pageurl = $config['sy_weburl']."/member/index.php?".$memberurl."&page={{page}} ";
    }elseif($islt=='4'){
		
        foreach($Purl as $k=>$v){
            if(!trim($v)){
                unset($Purl[$k]);
            }
        }
        $pageurl = Url('wap',$Purl);	
		
    }elseif($islt=='5'){

        if($config['sy_news_rewrite']=='2'||$Purl['cache']){
            $pageurl = $config['sy_weburl']."/news/".$get['nid']."/{{page}}.html";
        }else{
            $urlarr['page'] = '*page*';
            $pageurl = Url('article',$urlarr,"1");
            $pageurl = str_replace('*page*',"{{page}}", $pageurl);
        }
    }else{

        foreach($Purl as $k=>$v){
            if(!trim($v)){
                unset($Purl[$k]);
            }
        }

		if(in_array($Purl['m'],array('job','resume','company')) && $Purl['c']!='msg'){
			$pageurl = searchListRewrite($Purl,$config);
		}else{
			
			$pageurl = Url($Purl['m'],$Purl);	
		}
       
    }
	
	
    if($table2){
        $list = $db->select_alls($table,$table2,$where,"count(b.id) as count");
        $count = $list[0][count];
    }else{

		if($config['sy_indexpage']>0){
			if($table=='company'){
				$field = 'uid';
			}else{
				$field = 'id';
			}
			$isMax = $db->select_all($table,$where." LIMIT ".$config['sy_indexpage'].",1",$field);
			
		}
		if(!empty($isMax)){
			$count = $config['sy_indexpage'];
		}else{
			$count = $db->select_num($table,$where);
		}
    }
    $pagesize = PageLimit($page,$count,$paramer[limit],$pageurl,$paramer['notpl'],$_smarty_tpl);
	
	if($config['sy_indexpage']>0){

		if($config['sy_indexpage']<$paramer[limit]){
			$paramer[limit] = $config['sy_indexpage'];
		}
		$nowPageSize = ($config['sy_indexpage']-$pagesize)>0?($config['sy_indexpage']-$pagesize):0;
		if($paramer[limit]>$nowPageSize){
			
			$paramer[limit] = $nowPageSize;
		}	
	}
    return $limit = " limit $pagesize,$paramer[limit]";
}
function PageLimit($pagenum,$num,$limit,$pageurl,$notpl=false,$_smarty_tpl,$pagenavname='pagenav'){
    global $db,$db_config,$config;
	
    include_once(LIB_PATH."page.class.php");
	$pages=ceil($num/$limit);
	$pagenum=$pagenum<1?1:$pagenum;
	$pagenum=$pagenum<$pages?$pagenum:$pages;
    $ststrsql=($pagenum-1)*$limit; 
    $page = new page($pagenum,$limit,$num,$pageurl,2,true,$notpl);
    $pagenav=$page->numPage(1);
    if($_smarty_tpl){
        $_smarty_tpl->tpl_vars['limit'] = new Smarty_Variable;
        $_smarty_tpl->tpl_vars['pages'] = new Smarty_Variable;
        $_smarty_tpl->tpl_vars['total'] = new Smarty_Variable;
        $_smarty_tpl->tpl_vars[$pagenavname] = new Smarty_Variable;
        $_smarty_tpl->tpl_vars['limit']->value=$limit;
        $_smarty_tpl->tpl_vars['pages']->value=$pages;
        $_smarty_tpl->tpl_vars['total']->value=$num;
		$_smarty_tpl->tpl_vars['pagenum']->value=$pagenum;
        $_smarty_tpl->assignByRef('total',$num);
        if($pages>1){
      	   $_smarty_tpl->tpl_vars[$pagenavname]->value=$pagenav;
        }
    }
    return $ststrsql;
}
function Page($pagenum,$num,$limit,$pageurl,$notpl=false,$_smarty_tpl,$pagenavname='pagenav',$isadmin=false){
    global $db,$db_config,$config;
    include_once(LIB_PATH."page.class.php");
	
    $pagenum=$pagenum<1?1:$pagenum;
    $ststrsql=($pagenum-1)*$limit;
    $pages=ceil($num/$limit);
    $page = new page($pagenum,$limit,$num,$pageurl,2,true,$notpl);
    $pagenav=$page->numPage(1);
    if($_smarty_tpl){
        $_smarty_tpl->tpl_vars['limit'] = new Smarty_Variable;
        $_smarty_tpl->tpl_vars['pages'] = new Smarty_Variable;
        $_smarty_tpl->tpl_vars['total'] = new Smarty_Variable;
        $_smarty_tpl->tpl_vars[$pagenavname] = new Smarty_Variable;
        $_smarty_tpl->tpl_vars['limit']->value=$limit;
        $_smarty_tpl->tpl_vars['pages']->value=$pages;
        $_smarty_tpl->tpl_vars['total']->value=$num;
        $_smarty_tpl->assignByRef('total',$num);
        $_smarty_tpl->tpl_vars[$pagenavname]->value=$pagenav;
    }
    return $pagenav;
}
function Url($m='index',$paramer=array(),$index=""){

    global $db,$db_config,$config,$seo;
    $paramer['m'] = $m;

    $url  =  get_url($paramer,$config,$seo,$m,$index);
    return $url;
}
function FormatPicUrl($paramer){
    global $config;
    $UploadPath=$paramer['path'];
    if(strstr($UploadPath,'http://')){
        if(!file_exists(str_replace($config['sy_weburl'],APP_PATH,$UploadPath))){
            $UploadPath='/'.$config['sy_lt_icon'];
        }else{
            return $UploadPath;
        }
        return $config['sy_weburl'].$UploadPath;
    }
    switch($paramer['type']){
        case 'ltlogo':
            $UploadPath=trim($UploadPath)?$UploadPath:$config['sy_lt_icon'];
            break;
        case 'comlogo':
            $UploadPath=trim($UploadPath)?$UploadPath:$config['sy_unit_icon'];
            break;
    }
    $PathSplitList=explode('/',$UploadPath);
    switch(trim($PathSplitList[0])){
        case '.':$UploadPath=str_replace('./','/',$UploadPath);break;
        case '..':$UploadPath=str_replace('../','/',$UploadPath);break;
        case '':$UploadPath=$UploadPath;break;
        default:$UploadPath='/'.$UploadPath;break;
    }
    if($paramer['type']){
        if(!file_exists(APP_PATH.$UploadPath)){
            switch($paramer['type']){
                case 'ltlogo':
                    $UploadPath='/'.$config['sy_lt_icon'];
                    break;
                case 'comlogo':
                    $UploadPath='/'.$config['sy_unit_icon'];
                    break;
            }
        }
    }
    if(!file_exists(APP_PATH.$UploadPath)&&(substr($UploadPath,0,7)=='/upload')){
        $UploadPath='/data'.$UploadPath;
    }
    return $config['sy_weburl'].$UploadPath;
}
function GetSmarty($arr,$get,$_smarty_tpl=''){
    $arr = str_replace("\"","",$arr);
    $arr = str_replace("'","",$arr);
    if(is_array($arr)){

        foreach($arr as $key=>$value){
            $val = mb_substr($value,0,5);
            if(preg_match ("/auto./i", $value)){
                $nval = str_replace("auto.","",$value);
                $purl[$key] = $get[$nval];
                $arr[$key] = $get[$nval];
                if($get[$nval]!=""){
                	if($key=="keyword"){
						$arr[$key]=trim($get[$key]);
                	}
                    $url.="&".$key."=".$get[$key];
                }
            }
            if(preg_match ("/@./i", $value)){

                $nval = str_replace("@","",$value);
                $nval = str_replace("\"","",$nval);
                $nval = @explode(".",$nval);

                if(is_array($nval)){
                    $smarty_val = $_smarty_tpl->tpl_vars;
                    foreach($nval as $k=>$v){

						if($smarty_val[$v]->value){
							$smarty_val = $smarty_val[$v]->value;
						}else{
							$smarty_val = $smarty_val[$v];
						}
                    }
                    $arr[$key] = $smarty_val;
                }
            }
            if(substr($value,0,5)=='Array'){
                eval('$arr[$key]='.str_replace('Array','$_smarty_tpl->tpl_vars',$value).';');
            }
        }
    }
    return array("purl"=>$purl,"arr"=>$arr);
}
function SmartyOutputStr($smarty,$compiler,$_attr,$tagname,$from,$OutputStr){
    $item = $_attr['item'];
    if (isset($_attr['key'])){
        $key = $_attr['key'];
    } else {
        $key = null;
    }

    $smarty->openTag($compiler, $tagname, array($tagname, $compiler->nocache, $item, $key));
    $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;
    if (isset($_attr['name'])) {
        $name = $_attr['item'];
        $has_name = true;
        $SmartyVarName = '$smarty.foreach.' . trim($name, '\'"') . '.';
    } else {
        $name = null;
        $has_name = false;
    }
    $ItemVarName = '$' . trim($item, '\'"') . '@';
    if ($has_name) {
        $usesSmartyFirst = strpos($compiler->lex->data, $SmartyVarName . 'first') !== false;
        $usesSmartyLast = strpos($compiler->lex->data, $SmartyVarName . 'last') !== false;
        $usesSmartyIndex = strpos($compiler->lex->data, $SmartyVarName . 'index') !== false;
        $usesSmartyIteration = strpos($compiler->lex->data, $SmartyVarName . 'iteration') !== false;
        $usesSmartyShow = strpos($compiler->lex->data, $SmartyVarName . 'show') !== false;
        $usesSmartyTotal = strpos($compiler->lex->data, $SmartyVarName . 'total') !== false;
    } else {
        $usesSmartyFirst = false;
        $usesSmartyLast = false;
        $usesSmartyTotal = false;
        $usesSmartyShow = false;
    }
    $usesPropFirst = $usesSmartyFirst || strpos($compiler->lex->data, $ItemVarName . 'first') !== false;
    $usesPropLast = $usesSmartyLast || strpos($compiler->lex->data, $ItemVarName . 'last') !== false;
    $usesPropIndex = $usesPropFirst || strpos($compiler->lex->data, $ItemVarName . 'index') !== false;
    $usesPropIteration = $usesPropLast || strpos($compiler->lex->data, $ItemVarName . 'iteration') !== false;
    $usesPropShow = strpos($compiler->lex->data, $ItemVarName . 'show') !== false;
    $usesPropTotal = $usesSmartyTotal || $usesSmartyShow || $usesPropShow || $usesPropLast || strpos($compiler->lex->data, $ItemVarName . 'total') !== false;

    $output = "<?php ";
    $output .= " \$_smarty_tpl->tpl_vars[$item] = new Smarty_Variable; \$_smarty_tpl->tpl_vars[$item]->_loop = false;\n";
    if ($key != null) {
        $output .= " \$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable;\n";
    }
    $output .= $OutputStr.$from." = $from; if (!is_array(".$from.") && !is_object(".$from.")) { settype(".$from.", 'array');}\n";
    if ($usesPropTotal) {
        $output .= " \$_smarty_tpl->tpl_vars[$item]->total= \$_smarty_tpl->_count(".$from.");\n";
    }
    if ($usesPropIteration) {
        $output .= " \$_smarty_tpl->tpl_vars[$item]->iteration=0;\n";
    }
    if ($usesPropIndex) {
        $output .= " \$_smarty_tpl->tpl_vars[$item]->index=-1;\n";
    }
    if ($usesPropShow) {
        $output .= " \$_smarty_tpl->tpl_vars[$item]->show = (\$_smarty_tpl->tpl_vars[$item]->total > 0);\n";
    }
    if ($has_name) {
        if ($usesSmartyTotal) {
            $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['foreach'][$name]['total'] = \$_smarty_tpl->tpl_vars[$item]->total;\n";
        }
        if ($usesSmartyIteration) {
            $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['foreach'][$name]['iteration']=0;\n";
        }
        if ($usesSmartyIndex) {
            $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['foreach'][$name]['index']=-1;\n";
        }
        if ($usesSmartyShow) {
            $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['foreach'][$name]['show']=(\$_smarty_tpl->tpl_vars[$item]->total > 0);\n";
        }
    }
    $output .= "foreach (".$from." as \$_smarty_tpl->tpl_vars[$item]->key => \$_smarty_tpl->tpl_vars[$item]->value) {\n\$_smarty_tpl->tpl_vars[$item]->_loop = true;\n";
    if ($key != null) {
        $output .= " \$_smarty_tpl->tpl_vars[$key]->value = \$_smarty_tpl->tpl_vars[$item]->key;\n";
    }
    if ($usesPropIteration) {
        $output .= " \$_smarty_tpl->tpl_vars[$item]->iteration++;\n";
    }
    if ($usesPropIndex) {
        $output .= " \$_smarty_tpl->tpl_vars[$item]->index++;\n";
    }
    if ($usesPropFirst) {
        $output .= " \$_smarty_tpl->tpl_vars[$item]->first = \$_smarty_tpl->tpl_vars[$item]->index === 0;\n";
    }
    if ($usesPropLast) {
        $output .= " \$_smarty_tpl->tpl_vars[$item]->last = \$_smarty_tpl->tpl_vars[$item]->iteration === \$_smarty_tpl->tpl_vars[$item]->total;\n";
    }
    if ($has_name) {
        if ($usesSmartyFirst) {
            $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['foreach'][$name]['first'] = \$_smarty_tpl->tpl_vars[$item]->first;\n";
        }
        if ($usesSmartyIteration) {
            $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['foreach'][$name]['iteration']++;\n";
        }
        if ($usesSmartyIndex) {
            $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['foreach'][$name]['index']++;\n";
        }
        if ($usesSmartyLast) {
            $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['foreach'][$name]['last'] = \$_smarty_tpl->tpl_vars[$item]->last;\n";
        }
    }
    $output .= "?>";

    return $output;
}
function FetchMCA2NavUrl($Url){
    if(!strpos($Url,'?')){
        return str_replace('index.php','',$Url.'?m=index&c=index&a=index');
    }else{
        $UrlSplit1=explode('&',substr($Url,strpos($Url,'?')+1));
        $ParamsMCA=array('m'=>'index','c'=>'index','a'=>'index');
        foreach($UrlSplit1 as $k1=>$v1){
            $UrlSplit2=explode('=',$v1);
            $ParamsUrl[$UrlSplit2[0]]=$UrlSplit2[1];
        }
        $ParamsUrl=array_merge($ParamsMCA,$ParamsUrl);
        $ParamsUrlNew=array('m'=>$ParamsUrl['m'],'c'=>$ParamsUrl['c'],'a'=>$ParamsUrl['a']);
        foreach($ParamsUrl as $k1=>$v1){
            if(!in_array($k1,array('m','c','a'))){
                 $ParamsUrlNew[$k1]=$v1;
            }
        }
        $UrlNew=substr($Url,0,strpos($Url,'?')+1);
        foreach($ParamsUrlNew as $k1=>$v1){
            $UrlNew.=$k1.'='.$v1.'&';
        }
        return substr($UrlNew,0,strlen($UrlNew)-1);
    }
}
function navcalss($menu,$classname){
    global $ModuleName,$config;
	$CurrentAllPath='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$get = $_GET;
	 if($menu['name']=="Ê×Ò³"){
        if($CurrentAllPath==$config['sy_weburl']."/" || $CurrentAllPath==$config['sy_weburl'] ||$CurrentAllPath==$config['sy_weburl']."/lietou/"){
            return $classname;
        }
	 }else{
		$PathArr = @explode('?',$menu['url']);
		if(count($PathArr)>1){
			$endpath = end($PathArr);
			$PathFile = @explode("&",$endpath);
			foreach($PathFile as $key=>$value){
				$Vfiles = @explode("=",$value);
				if(is_array($Vfiles) && !empty($Vfiles)){
					$VfilesArr[$Vfiles[0]] = $Vfiles[1];
				}
			}
			if($VfilesArr['a'] || $get['a']){
				if($get['a'] == $VfilesArr['a'] && $get['c'] == $VfilesArr['c'] && $get['m'] == $VfilesArr['m']){
					return $classname;
				}
			}elseif($VfilesArr['c'] || $get['c']){
				if($get['c'] == $VfilesArr['c'] && $get['m'] == $VfilesArr['m']){
					return $classname;
				}
			}elseif($VfilesArr['m'] || $get['m']){
				if($get['m'] == $VfilesArr['m']){
					return $classname;
				}
			}
		}else{
		    $path=str_replace($config['sy_weburl'], '', $CurrentAllPath);
			if(strpos($path,$menu['url'])!==false){
				return $classname;
			}
		}
	 }
}

function searchListRewrite($paramer,$config){
		
		$get = $_GET;
		if(is_array($paramer)){
			
			foreach($paramer as $key=>$value){
				if(!in_array($key,array('type','utype','v'))){
					$get[$key] = $value;
				}
			}
		}
		if($paramer['type']=="job1"){
			$job=$paramer['v'];
		}elseif($paramer['type']=="job1_son" && $paramer['v']!=0){
			$job=$get['job1']."_".$paramer['v'];
		}elseif($paramer['type']=="job_post" && $paramer['v']!=0){
			$job=$get['job1']."_".$get['job1_son']."_".$paramer['v'];
		}else{
			if($get['job1']&&!$get['job1_son']&&!$get['job_post']){
				$job=$get['job1'];
			}elseif($get['job1_son']&&!$get['job_post']){
				$job=$get['job1']."_".$get['job1_son'];
			}elseif($get['job_post']){
				$job=$get['job1']."_".$get['job1_son']."_".$get['job_post'];
			}else{
				$job=0;	
			}	
		}
		if($paramer['untype']=="job1"){
		    $job=0;
		}elseif($paramer['untype']=="job1_son"){
		    $job=$get['job1'];
		}elseif($paramer['untype']=="job_post"){
		    $job=$get['job1']."_".$get['job1_son'];
		}
		
		if($paramer['t']=="index"){
			if($paramer['type']=='job1'){
				$job=$paramer['job1'];
			}elseif($paramer['type']=="job1_son"){
				$job=$paramer['job1']."_".$paramer['job1_son'];
			}elseif($paramer['type']=='job_post'){
				$job=$paramer['job1']."_".$paramer['job1_son']."_".$paramer['job_post'];
			}
		}
		
		
		if($paramer['type']=="provinceid"){
			$city=$paramer['v'];
		}elseif($paramer['type']=="cityid" && $paramer['v']!=0){
			if($paramer['searchpid']){
				$city=$paramer['searchpid']."_".$paramer['v'];
			}else{
				$city=$get['provinceid']."_".$paramer['v'];
				
			}
			
		}elseif($paramer['type']=="three_cityid" && $paramer['v']!=0){
			$city=$get['provinceid']."_".$get['cityid']."_".$paramer['v'];
		}else{
			
			if($get['provinceid']&&!$get['cityid']&&!$get['three_cityid']){
				$city=$get['provinceid'];
			}elseif($get['cityid']&&!$get['three_cityid']){
				$city=$get['provinceid']."_".$get['cityid'];
			}elseif($get['three_cityid']){
				$city=$get['provinceid']."_".$get['cityid']."_".$get['three_cityid'];
			}else{
				$city=0;	
			}	
		}
		
		if($paramer['untype']=="provinceid"){
		    $city=0;
		}elseif($paramer['untype']=="cityid"){
		    $city=$get['provinceid'];
		}elseif($paramer['untype']=="three_cityid"){
		    $city=$get['provinceid']."_".$get['cityid'];
		}
		
		if($paramer['type']=="city"){
			$city=$paramer['v'];
		}
		if ($get['minsalary']||$get['minsalary']){
		    $min=$get['minsalary']?$get['minsalary']:0;
		    $max=$get['maxsalary'];
		    $salary=$min.'_'.$max;
		    $salary=$paramer['untype']=="salary"?0:$salary;
		}else{
		    $salary=$get['salary']?$get['salary']:0;
		    $salary=$paramer['untype']=="salary"?0:$salary;
		}
		$salary=$paramer['type']=="salary"?$paramer['v']:$salary;
		
		$hebing=array();
		$hy=$get['hy']?$get['hy']:0;
		$hy=$paramer['untype']=="hy"?0:$hy;
		$hy=$hebing[]=$paramer['type']=="hy"?$paramer['v']:$hy;
		
		$edu=$get['edu']?$get['edu']:0;
		$edu=$paramer['untype']=="edu"?0:$edu;
		$hebing[]=$paramer['type']=="edu"?$paramer['v']:$edu;
		
		$exp=$get['exp']?$get['exp']:0;
		$exp=$paramer['untype']=="exp"?0:$exp;
		$hebing[]=$paramer['type']=="exp"?$paramer['v']:$exp;
		
		$sex=$get['sex']?$get['sex']:0;
		$sex=$paramer['untype']=="sex"?0:$sex;
		$hebing[]=$paramer['type']=="sex"?$paramer['v']:$sex;
		
		$report=$get['report']?$get['report']:0;
		$report=$paramer['untype']=="report"?0:$report;
		$hebing[]=$paramer['type']=="report"?$paramer['v']:$report;
		
		$uptime=$get['uptime']?$get['uptime']:0;
		$uptime=$paramer['untype']=="uptime"?0:$uptime;
		$hebing[]=$paramer['type']=="uptime"?$paramer['v']:$uptime;
		
		
		if($paramer['m']=="resume"){

			$idcard=$get['idcard']?$get['idcard']:0;
			$idcard=$paramer['untype']=="idcard"?0:$idcard;
			$hebing[]=$paramer['type']=="idcard"?$paramer['v']:$idcard;
			
			$work=$get['work']?$get['work']:0;
			$work=$paramer['untype']=="work"?0:$work;
			$hebing[]=$paramer['type']=="work"?$paramer['v']:$work;
			
			$tag=$get['tag']?$get['tag']:0;
			$tag=$paramer['untype']=="tag"?0:$tag;
			$hebing[]=$paramer['type']=="tag"?$paramer['v']:$tag;

		}elseif($paramer['m']=="company"){

			$mun=$get['mun']?$get['mun']:0;
			$mun=$paramer['untype']=="mun"?0:$mun;
			$mun=$paramer['type']=="mun"?$paramer['v']:$mun;
			
			$pr=$get['pr']?$get['pr']:0;
			$pr=$paramer['untype']=="pr"?0:$pr;
			$pr=$paramer['type']=="pr"?$paramer['v']:$pr;
			
			$rec=$get['rec']?$get['rec']:0;
			$rec=$paramer['untype']=="rec"?0:$rec;
			$rec=$paramer['type']=="rec"?$paramer['v']:$rec;
			
			$city=$get['cityid']?$get['cityid']:0;
			$city=$paramer['untype']=="cityid"?0:$city;
			$city=$paramer['type']=="cityid"?$paramer['v']:$city;
			
		}elseif($paramer['m']=="part"){
			$part_type=$get['part_type']?$get['part_type']:0;
			$part_type=$paramer['untype']=="part_type"?0:$part_type;
			$part_type=$paramer['type']=="part_type"?$paramer['v']:$part_type;
			
			$cycle=$get['cycle']?$get['cycle']:0;
			$cycle=$paramer['untype']=="cycle"?0:$cycle;
			$cycle=$paramer['type']=="cycle"?$paramer['v']:$cycle;
			
		}elseif($paramer['m']=="train"){
			$nid=$get['nid']?$get['nid']:0;
			$nid=$paramer['untype']=="nid"?0:$nid;
			$nid=$paramer['type']=="nid"?$paramer['v']:$nid;
			$tnid=$get['tnid']?$get['tnid']:0;
			if($get['tnid']&&$paramer['untype']=="nid"||$paramer['untype']=="tnid"){
				$tnid=0;
			}
			$tnid=$paramer['type']=="tnid"?$paramer['v']:$tnid;
			$type=$get['type']?$get['type']:0;
			$type=$paramer['untype']=="type"?0:$type;
			$type=$paramer['type']=="type"?$paramer['v']:$type;
			$sid=$get['sid']?$get['sid']:0;
			$sid=$paramer['untype']=="sid"?0:$sid;
			$sid=$paramer['type']=="sid"?$paramer['v']:$sid;
			
			$mun=$get['mun']?$get['mun']:0;
			$mun=$paramer['untype']=="mun"?0:$mun;
			$mun=$paramer['type']=="mun"?$paramer['v']:$mun;
				
			$pr=$get['pr']?$get['pr']:0;
			$pr=$paramer['untype']=="pr"?0:$pr;
			$pr=$paramer['type']=="pr"?$paramer['v']:$pr;
			
		}else{
			$cert=$get['cert']?$get['cert']:0;
			$cert=$paramer['untype']=="cert"?0:$cert;
			$cert=$paramer['type']=="cert"?$paramer['v']:$cert;
			if($cert==0){
			    $certd='';
			    $cert='-0';
			}else{
			    $certd="&cert=".$cert;
			    $cert="-".$cert;
			}
		}
		
		$keyword=$get['keyword']?$get['keyword']:0;
		$keyword=$paramer['untype']=="keyword"?0:$keyword;
		$keyword=$paramer['type']=="keyword"?$paramer['v']:$keyword;
		$keyword=urlencode($keyword);
		
		$hebing=implode("_",$hebing);
		
		$tp=$get['tp']?$get['tp']:0;
		$tp=$paramer['type']=="tp"?$paramer['v']:$tp;
		
		$order=$get['order']?$get['order']:0;
		$order=$paramer['type']=="order"?$paramer['v']:$order;

		$page = $get['page']?$get['page']:1;
		$page =$paramer['page']?$paramer['page']:$page;
		

		if($config['sy_seo_rewrite']==1){
		    if ($keyword){
		        $url="list/".$job."-".$city."-".$salary."-".$hebing."-".$tp.$cert."-".$order."-".$page.".html?".$keyword;
		    }else{
		        $url="list/".$job."-".$city."-".$salary."-".$hebing."-".$tp.$cert."-".$order."-".$page.".html";
		    }
		}else{
			if($job)
			    $url[]='job='.$job;
			if($city)
			    $url[]='city='.$city;
			if($salary)
			    $url[]='salary='.$salary;
			if($order)
			    $url[]='order='.$order;
			if($keyword)
			    $url[]='keyword='.$keyword;

		    if($config['sy_default_comclass']=='1'&&!$paramer['m']){
		        $sdc="c=search&";
		    }elseif ($config['sy_default_userclass']=='1'&&$paramer['m']=='resume'){
		        $sdc="c=search&";
		    }
		    if(!empty($url)){
				$url="index.php?".$sdc.implode('&',$url)."&all=".$hebing."&tp=".$tp.$certd;
			}else{
				$url="index.php?".$sdc."all=".$hebing."&tp=".$tp.$certd;
			}
			if($page){
			    $url .='&page='.$page;
			}
		}
		if($paramer['m']=="company"){
			if($config['sy_seo_rewrite']==1){
				$url="list/".$city."-".$mun."-".$hy."-".$pr."-".$rec."-".$keyword."-".$page.".html";
			}else{
				if($city)
				 $urln[]='city='.$city;
				 
				if($mun)
				 $urln[]='mun='.$mun;
				 
				 if($hy)
				 $urln[]='hy='.$hy;
				 
				 if($pr)
				 $urln[]='pr='.$pr;
				 
				 if($rec)
				 $urln[]='rec='.$rec;
				 
				 if($keyword)
				 $urln[]='keyword='.$keyword;

				 if($page){
					$urln[]='page='.$page;
				 }
				 if(!empty($urln)){
					$url="index.php?".implode('&',$urln);
				 }
				
			}
		}
		if($paramer['m']=="part"){
		    if($config['sy_seo_rewrite']==1){
		        if ($keyword){
		            $url="list/".$city."-".$part_type."-".$cycle."-".$order."-".$page.".html?".$keyword;
		        }else{
		            $url="list/".$city."-".$part_type."-".$cycle."-".$order."-".$page.".html";
		        }
		    }else{
		        if($city)
		            $urln[]='city='.$city;
		        	
		        if($part_type)
		            $urln[]='part_type='.$part_type;
		        	
		        if($cycle)
		            $urln[]='cycle='.$cycle;
		        	
		        if($order)
		            $urln[]='order='.$order;
		        	
		        if($keyword)
		            $urln[]='keyword='.$keyword;
		
		        if($page){
		            $urln[]='page='.$page;
		        }
		        if(!empty($urln)){
		            $url="index.php?".implode('&',$urln);
		        }
		
		    }
		}
		if($paramer['m']=="train"){
			if($city)
				$urln[]='city='.$city;
			if($hy)
				$urln[]='hy='.$hy;
			if($mun)
				$urln[]='mun='.$mun;
				
			if($pr)
				$urln[]='pr='.$pr;
			if($nid)
				$urln[]='nid='.$nid;
			if($tnid)
				$urln[]='tnid='.$tnid;
			if($sid)
				$urln[]='sid='.$sid;
				
			if($type)
				$urln[]='type='.$type;
			if($order)
				$urln[]='order='.$order;
				
			if($keyword)
				$urln[]='keyword='.$keyword;
			
			if($page){
				$urln[]='page='.$page;
			}
			if(!empty($urln)){
				$url="index.php?c=".$paramer['c']."&".implode('&',$urln);
			}
		}
		$m=$paramer['m']?$paramer['m']:"job";
		unset($paramer);
		return $config['sy_weburl'].'/'.$m.'/'.$url;
	
	}
?>