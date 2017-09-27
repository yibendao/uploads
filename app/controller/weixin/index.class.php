<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2017 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class index_controller extends common{ 

	function index_action(){
		
		$M=$this->MODEL('weixin');
		if($_GET["echostr"])
		{
			$M->valid($_GET['echostr'],$_GET['signature'],$_GET['timestamp'],$_GET['nonce']);

		}else{
			if(!$M->checkSignature($_GET['signature'],$_GET['timestamp'],$_GET['nonce'])){echo "非法来源地址！";exit();};

			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			if (!empty($postStr))
			{
			  $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);  
			  $fromUsername = $postObj->FromUserName;
			  $toUsername = $postObj->ToUserName;
			  $keyword = trim($postObj->Content);
			  $times = time();
			  $MsgType = $postObj->MsgType;
			 
			  $topTpl = "<xml>
				   <ToUserName><![CDATA[%s]]></ToUserName>
				   <FromUserName><![CDATA[%s]]></FromUserName>
				   <CreateTime>%s</CreateTime>
				   <MsgType><![CDATA[%s]]></MsgType>
				   ";
			   
			  $bottomStr = "<FuncFlag>0</FuncFlag></xml>";
			  
			  if($MsgType=='event')
			  {
				$MsgEvent = $postObj->Event;
				if ($MsgEvent=='subscribe')
				{	
					if($postObj->EventKey){
						$wxloginid = str_replace('qrscene_','',$postObj->EventKey);
						$loginType = $M->isWxlogin($fromUsername,$wxloginid);
						if(!$loginType){
							$loginStr = "\n\n请先<a href='".Url('wap',array('c'=>'login','wxid'=>$fromUsername,'wxloginid'=>$wxloginid,'bind'=>'1'))."'>绑定或注册".iconv('gbk','utf-8',$this->config['sy_webname'])."帐号！</a>";

						}else{
							$centerStr = "<Content><![CDATA[扫码登录成功！]]></Content>";
						}
						
						
					}
					if($this->config['wx_welcom'])
					{
						$centerStr = "<Content><![CDATA[".iconv('gbk','utf-8',$this->config['wx_welcom']).$loginStr."]]></Content>";
					}else{
						$centerStr = "<Content><![CDATA[欢迎您关注".iconv('gbk','utf-8',$this->config['sy_webname'])."！\n 1：您可以直接回复关键字如【销售】、【销售 XX公司】查找您想要的职位\n绑定您的账户体验更多精彩功能\n感谢您的关注！".$loginStr."]]></Content>";
					}

					
					$this->MsgType = 'text';

				}elseif ($MsgEvent=='SCAN')
				{	
					
					$wxloginid = $postObj->EventKey;
				
					$loginType = $M->isWxlogin($fromUsername,$wxloginid);
					if(!$loginType){

						$loginStr = $centerStr = "<Content><![CDATA[\n 请先<a href='".Url('wap',array('c'=>'login','wxid'=>$fromUsername,'wxloginid'=>$wxloginid,'bind'=>'1'))."'>绑定或注册".iconv('gbk','utf-8',$this->config['sy_webname'])."帐号！</a>]]></Content>";
					
					}else{
							$centerStr = "<Content><![CDATA[扫码登录成功！]]></Content>";
					}
					
					$this->MsgType = 'text';

				}elseif ($MsgEvent=='CLICK')
				{
					$EventKey = $postObj->EventKey;
					if($EventKey=='我的帐号'){
						$Return = $M->bindUser($fromUsername);
						
					}elseif($EventKey=='我的消息')
					{
						$Return = $M->myMsg($fromUsername);
					}elseif($EventKey=='面试邀请')
					{
						$Return = $M->Audition($fromUsername);

					}elseif($EventKey=='简历浏览')
					{
						$Return = $M->lookResume($fromUsername);

					}elseif($EventKey=='刷新简历')
					{
						$Return = $M->refResume($fromUsername);

					}elseif($EventKey=='推荐职位')
					{
						$Return = $M->recJob($fromUsername);

					}elseif($EventKey=='刷新职位')
					{
						$Return = $M->refJob($fromUsername);

					}elseif($EventKey=='职位浏览')
					{
						$Return = $M->lookJob($fromUsername);

					}elseif($EventKey=='简历投递')
					{
						$Return = $M->ApplyJob($fromUsername);

					}elseif($EventKey=='兼职报名')
					{
						$Return = $M->PartApply($fromUsername);

					}elseif($EventKey=='职位搜索'){
						
						if($this->config['wx_search'])
						{
							$Return['centerStr'] = "<Content><![CDATA[".iconv('gbk','utf-8',$this->config['wx_search'])."]]></Content>";
						}else{
							$Return['centerStr'] = "<Content><![CDATA[直接回复城市、职位、公司名称等关键字搜索您需要的职位信息。\n 如：【经理】、【xx公司】]]></Content>";
						}
						$Return['MsgType'] = 'text';

					}elseif($EventKey=='周边职位'){
						
						$Return['centerStr'] = "<Content><![CDATA[/可怜 亲，把您的位置先发我一下。\n\n方法：点屏幕左下角输入框旁的“+”，选择“位置”，点“发送”。]]></Content>";
						$Return['MsgType'] = 'text';
					}
					$centerStr		= $Return['centerStr'];
					$this->MsgType  = $Return['MsgType'];
				}
			  }elseif($MsgType=='location'){
					 $latitude = $postObj->Location_X;
					 $longitude = $postObj->Location_Y;
					 $url = "http://api.map.baidu.com/geocoder/v2/?ak=42966293429086ba859198a2a69bedad&callback=renderReverse&location=". $latitude.",".$longitude."&output=json";
					 $mapinfo = file_get_contents($url);
					 $mapinfo = str_replace(array('renderReverse&&renderReverse(',')'),'',$mapinfo);
				     $map_info = json_decode($mapinfo,true);
					
					 if($map_info['result']['addressComponent']['district'])
					 {
						$Return = $M->searchJob($map_info['result']['addressComponent']['district'],1);
						$centerStr		= $Return['centerStr'];
						$this->MsgType  = $Return['MsgType'];
					 }
			  
			  }elseif($MsgType=='text'){
				      if($keyword){
					    $Returnone = $M->searchKeyword($keyword);
						$centerStr		= $Returnone['centerStr'];
						$this->MsgType  = $Returnone['MsgType'];						
				      }
					  if($Returnone['centerStr']==""){					
						$Returntwo = $M->searchJob($keyword);
						$centerStr		= $Returntwo['centerStr'];
						$this->MsgType  = $Returntwo['MsgType'];	
					  }
			  }
			 
			  $topStr = sprintf($topTpl, $fromUsername, $toUsername, $times, $this->MsgType);
			  echo $topStr.$centerStr.$bottomStr;
			}
		}
	}

}
?>