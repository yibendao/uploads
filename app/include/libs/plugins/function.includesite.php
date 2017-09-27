<?php
function smarty_function_includesite($paramer,$template){
	global $config,$seo;
	if($config['sy_web_site']=="1"){
        if($config['cityname']){
            $cityname = $config['cityname'];
        }else{
            $cityname = $config['sy_indexcity'];
        }
        $site_url = Url("index",array("c"=>"site"),"1");
        $html = "<div class=\"heder_city_line \"><em  class=\"heder_city_jr \">½øÈë</em><span class=\"header_city_h1\">".$cityname."</span><span class=\"header_city_more\"><a href=\"".$site_url."\">[ÇĞ»»·ÖÕ¾]</a></span></div>";
    }
	return $html;
}
?>