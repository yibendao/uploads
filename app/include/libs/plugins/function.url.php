<?php
function smarty_function_url($paramer,$template){
	global $config,$seo;
	if(!$paramer['index'] && $paramer['m']=='member'){
		$index='member';
		unset($paramer['m']);
	}else{
		$index=$paramer['index'];
	}
    
     unset($paramer['index']);
     $url  =  get_url($paramer,$config,$seo,$paramer['m'],$index,$template);
	return $url;
}
?>