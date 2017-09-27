<?php

function ReadFileContent($filepath){

	$htmlfp=@fopen($filepath,"r");

	while($data=@fread($htmlfp,1000)){

		$string.=$data;

	}

	@fclose($htmlfp);

	return $string;

}

function WriteString2File($filepath,$string){

	global $filechmod;

	$fp=@fopen($filepath,"w");

	@fputs($fp,$string);

	@fclose($fp);

	if(empty($filechmod)){

		@chmod($filepath,0777);

	}

}

function DoMkdir($path){

	global $public_r;

	if(!file_exists($path)){

		if($public_r[phpmode]){

			$pr[0]=$path;

			FtpMkdir($ftpid,$pr);

			$mk=1;

		}else{

			$mk=@mkdir($path,0777);

		}

		@chmod($path,0777);

		if(empty($mk)){

		}

	}

	return true;

}

function ToChangeUseTime($time){

	global $fun_r;

	$usetime=time()-$time;

	if($usetime<60){

		$tstr=$usetime.iconv('utf-8','gbk','秒');

	}else{

		$usetime=round($usetime/60);

		$tstr=$usetime.iconv('utf-8','gbk','分');

	}

	return $tstr;

}

function BackupDatabaseInit($add){

	global $db,$fun_r,$phpyun_db_ver,$config,$adminDir;

    $res=$db->query("select VERSION()");
    $row=$db->fetch_row($res);

    $phpyun_db_ver=$row[0];

	$dbname=$add['mydbname'];

    $bakpath=$add['backuppath'];

	if(empty($dbname)){

	}

	$tablename=$add['tablename'];

	if(is_array($tablename)){

		$count=count($tablename);

	}else{

		$count=1;

		$tablename=array($tablename);

	}

	if(empty($count)){

	}

	$add['baktype']=(int)$add['baktype'];

	$add['filesize']=(int)$add['filesize'];

	$add['bakline']=(int)$add['bakline'];

	$add['autoauf']=(int)$add['autoauf'];

	if((!$add['filesize']&&!$add['baktype'])||(!$add['bakline']&&$add['baktype'])){

	}

	if(is_array($add['tablename'])){		

		if(empty($add['mypath'])){

			$add['mypath']=$dbname."_".date("YmdHis");

		}

	}else{		

		if(empty($add['mypath'])){

			$add['mypath']=$dbname."_".$add['tablename']."_".date("YmdHis");

		}

	}

    DoMkdir($bakpath."/".$add['mypath']);

	$readme=$add['readme'];

	$rfile=$bakpath."/".$add['mypath']."/readme.txt";

	$readme.="\r\n\r\nBaktime: ".date("Y-m-d H:i:s");

	WriteString2File($rfile,$readme);



	$b_table="";

	$d_table="";

	for($i=0;$i<$count;$i++){

		$b_table.=$tablename[$i].",";

		$d_table.="\$tb[".$tablename[$i]."]=0;\r\n";

    }

	$b_table=substr($b_table,0,strlen($b_table)-1);

	$bakstru=(int)$add['bakstru'];

	$bakstrufour=(int)$add['bakstrufour'];

	$beover=(int)$add['beover'];

	$waitbaktime=(int)$add['waitbaktime'];

	$bakdatatype=(int)$add['bakdatatype'];

	if($add['insertf']=='insert'){

		$insertf='insert';

	}else{

		$insertf='replace';

	}

	if($phpyun_db_ver=='4.0'&&$add['dbchar']=='auto'){

		$add['dbchar']='';

	}

	$string="<?php

	\$b_table=\"".$b_table."\";

	".$d_table."

	\$b_baktype=".$add['baktype'].";

	\$b_filesize=".$add['filesize'].";

	\$b_bakline=".$add['bakline'].";

	\$b_autoauf=".$add['autoauf'].";

	\$b_dbname=\"".$dbname."\";

	\$b_stru=".$bakstru.";

    \$b_version=\"".$phpyun_db_ver."\";

    \$b_time=\"".time()."\";

	\$b_strufour=".$bakstrufour.";

	\$b_dbchar=\"".addslashes($add['dbchar'])."\";

	\$b_beover=".$beover.";

	\$b_insertf=\"".addslashes($insertf)."\";

	\$b_autofield=\",".addslashes($add['autofield']).",\";

	\$b_bakdatatype=".$bakdatatype.";

	?>";

	$cfile=$bakpath."/".$add['mypath']."/config.php";

	WriteString2File($cfile,$string);

	if($add['baktype']){

		$phome='BackupDatabaseRecordNum';

	}else{

		$phome='BackupDatabaseFileSize';

	}

	echo "<script>self.location.href='".$config['sy_weburl']."/".$adminDir."/index.php?m=database&c=$phome&t=0&s=0&p=0&mypath=$add[mypath]&waitbaktime=$waitbaktime';</script>";

	exit();

}

function SetCharset($Charset){
	global $db;

	if($Charset&&$Charset!='auto'){

		$db->query('set character_set_connection='.$Charset.',character_set_results='.$Charset.',character_set_client=binary;');

	}

}

function Encode($string,$charset){

    $InputCoding=strtolower(mb_detect_encoding($string,array('utf-8','gbk')));

    if($charset==$InputCoding){

        return $string;

    }else{

        return yun_iconv($InputCoding,$charset,$string);

    }

}

function BackupDatabaseFileSize($t,$s,$p,$mypath,$alltotal,$thenof,$fnum,$stime=0){	

	global $db,$bakpath,$limittype,$fun_r,$db_config,$config,$adminDir;

    header('Content-Type: text/html; charset=' . $db_config['charset']);

    ob_start();

	if(empty($mypath)){

	}

    $b_dbname=$db_config['dbname'];

	$path=PLUS_PATH.'/bdata/'.$mypath;

	@include($path."/config.php");

	if(empty($b_table)){

	}

	$waitbaktime=(int)$_GET['waitbaktime'];

	if(empty($stime)){

		$stime=time();

	}

$header="<?php

require(dirname(dirname(dirname(dirname(dirname(__FILE__))))).\"/app/include/dbbackup/inc/header.php\");

";

	$footer="

require(dirname(dirname(dirname(dirname(dirname(__FILE__))))).\"/app/include/dbbackup/inc/footer.php\");

?>";

	$btb=explode(",",$b_table);

	$count=count($btb);

	$t=(int)$t;

	$s=(int)$s;

	$p=(int)$p;

	if($t>=$count){

		echo "<script>alert('".iconv("utf-8",'gbk',"备份成功！\\n\\n整个过程耗时：")."".ToChangeUseTime($stime)."');self.location.href='index.php?m=database';</script>";

		die;

    }

	$u=$db->query("use `$b_dbname`");

	SetCharset($b_dbchar);

	if($s==0){

		if($limittype){

			$num=-1;

		}else{

			$status_r=GetTableRows($b_dbname,$btb[$t]);

			$num=$status_r['Rows'];

		}

	}else{

		$num=(int)$alltotal;

	}

	$dumpsql.=GetTableStructSql($btb[$t],$b_strufour);

	$sql=$db->select_only($btb[$t],'1 limit '.$s.','.$num);

	if(empty($fnum)){

		$return_fr=GetTableFields($b_dbname,$btb[$t],$b_autofield);

		$fieldnum=$return_fr['num'];

		$noautof=$return_fr['autof'];

	}else{

		$fieldnum=$fnum;

		$noautof=$thenof;

	}

	$inf='';

	if($b_beover==1){

		$inf='('.GetTableInsertFields($b_dbname,$btb[$t]).')';

	}

	$hexf='';

	if($b_bakdatatype==1){

		$hexf=GetTableStringFields($b_dbname,$btb[$t]);

	}

	$b=0;

	foreach($sql as $k=>$r){

		echo Encode('<script>document.write("正在备份'.$btb[$t].'的第'.($k+1).'条记录<br/>");if(document.documentElement.scrollTop){document.documentElement.scrollTop='.($k*30).';}else{document.body.scrollTop='.($k*30).';}</script>','gbk');  

        ob_flush();

        flush();

		$b=1;

		$s++;

		$dumpsql.="ExcuteSQL(\"insert into `".$btb[$t]."`".$inf." values(";

		$first=1;

		for($i=0;$i<$fieldnum;$i++){

			if(empty($first)){

				$dumpsql.=',';

			}else{

				$first=0;

			}

			$myi=$i+1;

			if(!isset($r[$i])||strstr($noautof,','.$myi.',')){

				$dumpsql.='NULL';

			}else{

				$dumpsql.=GetFieldContent($r[$i],$b_bakdatatype,$myi,$hexf);

			}

		}

		$dumpsql.=");\");\r\n";

		if(strlen($dumpsql)>=$b_filesize*1024){

			$p++;

			$sfile=$path."/".$btb[$t]."_".$p.".php";

			$dumpsql=$header.$dumpsql.$footer;

			WriteString2File($sfile,$dumpsql);

			$db->free($sql);

			echo Encode("<meta http-equiv=\"refresh\" content=\"".$waitbaktime.";url=".$config['sy_weburl']."/".$adminDir."/index.php?m=database&c=BackupDatabaseFileSize&phome=BakExe&s=$s&p=$p&t=$t&mypath=$mypath&alltotal=$num&thenof=$noautof&fieldnum=$fieldnum&stime=$stime&waitbaktime=$waitbaktime&collation=$collation\">".$fun_r['BakOneDataSuccess'],'gbk').EchoBackupProcesser($btb[$t],$count,$t,$num,$s);

			exit();

		}

	}

	if(empty($p)||$b==1){

		$p++;

		$sfile=$path."/".$btb[$t]."_".$p.".php";

		$dumpsql=$header.$dumpsql.$footer;

		WriteString2File($sfile,$dumpsql);

	}

	FetchFileNumber($p,$btb[$t],$path);

	$t++;

	$db->free($sql);

	echo"<meta http-equiv=\"refresh\" content=\"".$waitbaktime.";url=".$config['sy_weburl']."/".$adminDir."/index.php?m=database&c=BackupDatabaseFileSize&phome=BakExe&s=0&p=0&t=$t&mypath=$mypath&stime=$stime&waitbaktime=$waitbaktime\">".$fun_r['OneTableBakSuccOne'].$btb[$t-1].$fun_r['OneTableBakSuccTwo'];

	exit();

}

function BackupDatabaseRecordNum($t,$s,$p,$mypath,$alltotal,$thenof,$fnum,$auf='',$aufval=0,$stime=0){

	global $db,$bakpath,$limittype,$fun_r,$adminDir;

	if(empty($mypath)){

	}

	$path=PLUS_PATH.'/bdata/'.$mypath;

	@include($path."/config.php");

	if(empty($b_table)){

	}

	$waitbaktime=(int)$_GET['waitbaktime'];

	if(empty($stime)){

		$stime=time();

	}

	$header="<?php

require(LIB_PATH.\"dbbackup/inc/header.php\");

";

	$footer="

require(LIB_PATH.\"dbbackup/inc/footer.php\");

?>";

	$btb=explode(",",$b_table);

	$count=count($btb);

	$t=(int)$t;

	$s=(int)$s;

	$p=(int)$p;

	if($t>=$count){

		echo"<script>alert('".$fun_r['BakSuccess']."\\n\\n".$fun_r['TotalUseTime'].ToChangeUseTime($stime)."');self.location.href='".$config['sy_weburl']."/".$adminDir."/index.php?m=database';</script>";

		exit();

    }

	$u=$db->query("use `$b_dbname`");

	if($b_dbchar=='auto'){

		if(!empty($s)){

			$status_r=GetTableRows($b_dbname,$btb[$t]);

			$collation=GetCharset($status_r['Collation']);

			SetCharset($collation);

			$num=$limittype?-1:$status_r['Rows'];

		}else{

			$collation=$_GET['collation'];

			SetCharset($collation);

			$num=(int)$alltotal;

		}

		$dumpsql.=ExcuteSetCharset($collation);

	}else{

		SetCharset($b_dbchar);

		if(!empty($s)){

			if($limittype){

				$num=-1;

			}else{

				$status_r=GetTableRows($b_dbname,$btb[$t]);

				$num=$status_r['Rows'];

			}

		}else{

			$num=(int)$alltotal;

		}

	}

	if($b_stru&&$s){

		$dumpsql.=GetTableStructSql($btb[$t],$b_strufour);

	}

	if(empty($fnum)){

		$return_fr=GetTableFields($b_dbname,$btb[$t],$b_autofield);

		$fieldnum=$return_fr['num'];

		$noautof=$return_fr['autof'];

		$auf=$return_fr['auf'];

	}else{

		$fieldnum=$fnum;

		$noautof=$thenof;

	}

	$aufval=(int)$aufval;

	if($b_autoauf==1&&$auf){

		$sql=$db->query("select * from `".$btb[$t]."` where ".$auf.">".$aufval." order by ".$auf." limit $b_bakline");

	}else{

		$sql=$db->query("select * from `".$btb[$t]."` limit $s,$b_bakline");

	}

	$inf='';

	if($b_beover==1){

		$inf='('.GetTableInsertFields($b_dbname,$btb[$t]).')';

	}

	$hexf='';

	if($b_bakdatatype==1){

		$hexf=GetTableStringFields($b_dbname,$btb[$t]);

	}

	$b=0;

	while($r=$db->fetch($sql)){

		if($auf){

			$lastaufval=$r[$auf];

		}

		$b=1;

		$s++;

		$dumpsql.="ExcuteSQL(\"into `".$btb[$t]."`".$inf." values(";

		$first=1;

		for($i=0;$i<$fieldnum;$i++){

			if(empty($first)){

				$dumpsql.=',';

			}else{

				$first=0;

			}

			$myi=$i+1;

			if(!isset($r[$i])||strstr($noautof,','.$myi.',')){

				$dumpsql.='NULL';

			}else{

				$dumpsql.=GetFieldContent($r[$i],$b_bakdatatype,$myi,$hexf);

			}

		}

		$dumpsql.=");\");\r\n";

	}

	if(empty($b)){


		if(empty($p)){

			$p++;

			$sfile=$path."/".$btb[$t]."_".$p.".php";

			$dumpsql=$header.$dumpsql.$footer;

			WriteString2File($sfile,$dumpsql);

		}

		FetchFileNumber($p,$btb[$t],$path);

		$t++;

		$db->free($sql);




		echo"<meta http-equiv=\"refresh\" content=\"".$waitbaktime.";url=".$config['sy_weburl']."/".$adminDir."/index.php?m=database&c=BackupDatabaseRecordNum&s=0&p=0&t=$t&mypath=$mypath&stime=$stime&waitbaktime=$waitbaktime\">".$fun_r['OneTableBakSuccOne'].$btb[$t-1].$fun_r['OneTableBakSuccTwo'];

		exit();

	}

	$p++;

	$sfile=$path."/".$btb[$t]."_".$p.".php";

	$dumpsql=$header.$dumpsql.$footer;

	WriteString2File($sfile,$dumpsql);

	$db->free($sql);




	echo"<meta http-equiv=\"refresh\" content=\"".$waitbaktime.";url=".$config['sy_weburl']."/".$adminDir."/index.php?m=database&c=BackupDatabaseRecordNum&s=$s&p=$p&t=$t&mypath=$mypath&alltotal=$num&thenof=$noautof&fieldnum=$fieldnum&auf=$auf&aufval=$lastaufval&stime=$stime&waitbaktime=$waitbaktime&collation=$collation\">".$fun_r['BakOneDataSuccess'].EchoBackupProcesser($btb[$t],$count,$t,$num,$s);

	exit();

}

function EchoBackupProcesser($tbname,$tbnum,$tb,$rnum,$r){

	$table=($tb+1).'/'.$tbnum;

	$record=$r;

	if($rnum!=-1){

		$record=$r.'/'.$rnum;

	}


}


function EchoRecoverProcesser($tbname,$tbnum,$tb,$pnum,$p){

	$table=($tb+1).'/'.$tbnum;

	$record=$p.'/'.$pnum;


}


function GetTableRows($dbname,$tbname){

	global $db;


	$tr=$db->DB_query_all("SHOW TABLE STATUS LIKE '".$tbname."';");

	return $tr;

}


function GetCharset($char){

	global $db;

	if(empty($char)){

		return '';

	}

	$r=$db->DB_query_all("SHOW COLLATION LIKE '".$char."';");

	return $r[0]['Charset'];

}


function GetTableFields($dbname,$tbname,$autofield){

	global $db;

	$sql=$db->query("SHOW FIELDS FROM `".$tbname."`");

	$i=0;

	$autof=",";

	$f='';

    while($r=$db->fetch_array($sql)){

		$i++;

		if(strstr($autofield,",".$tbname.".".$r[Field].",")){

			$autof.=$i.",";

	    }

		if($r['Extra']=='auto_increment'){

			$f=$r['Field'];

		}

    }

	$return_r['num']=$i;

	$return_r['autof']=$autof;

	$return_r['auf']=$f;

	return $return_r;

}


function GetTableInsertFields($dbname,$tbname){

	global $db;

	$sql=$db->query("SHOW FIELDS FROM `".$tbname."`");

	$f='';

	$dh='';

	while($r=$db->fetch($sql)){

		$f.=$dh.'`'.$r['Field'].'`';

		$dh=',';

    }

	return $f;

}

function GetTableStringFields($dbname,$tbname){

	global $db;

	$sql=$db->query("SHOW FIELDS FROM `".$tbname."`");

	$i=0;

	$f='';

	$dh='';

	while($r=$db->fetch($sql)){

		$i++;

		if(!(stristr($r[Type],'char')||stristr($r[Type],'text'))){

			continue;

		}

		$f.=$dh.$i;

		$dh=',';

    }

	if($f){

		$f=','.$f.',';

	}

	return $f;

}


function EscapeString($str){
	global $db;

	$str=$db->escape_string($str);

	$str=str_replace('\\\'','\'\'',$str);

	$str=str_replace("\\\\","\\\\\\\\",$str);

	$str=str_replace('$','\$',$str);

	return $str;

}


function GetFieldContent($str,$bakdatatype,$i,$tbstrf){

	if($bakdatatype==1&&!empty($str)&&strstr($tbstrf,','.$i.',')){

		$restr='0x'.bin2hex($str);

	}else{

		$restr='\''.EscapeString($str).'\'';

	}

	return $restr;

}


function FetchFileNumber($p,$table,$path){

	if(empty($p))

	{$p=0;}

	$file=$path."/config.php";

	$text=ReadFileContent($file);

	$rep1="\$tb[".$table."]=0;";

	$rep2="\$tb[".$table."]=".$p.";";

	$text=str_replace($rep1,$rep2,$text);

	WriteString2File($file,$text);

}


function ExcuteSQL($sql){

	global $db;

	$db->query($sql);

}


function CreateTable($sql){

	global $db;

	$db->query(FetchDbcharset($sql));

}


function Convert2Mysql4($query){

	$exp="ENGINE=";

	if(!strstr($query,$exp)){

		return $query;

	}

	$exp1=" ";

	$r=explode($exp,$query);


	$r1=explode($exp1,$r[1]);

	$returnquery=$r[0]."TYPE=".$r1[0];

	return $returnquery;

}

function GetTableStructSql($table,$strufour){

	global $db;

	$dumpsql.="ExcuteSQL(\"DROP TABLE IF EXISTS `".$table."`;\");\r\n";

	$usql=$db->query("SET SQL_QUOTE_SHOW_CREATE=1;");

    $CreatTable = $db->query("SHOW CREATE TABLE $table");

    $r=$db->fetch_array($CreatTable);

	$create=str_replace("\"","\\\"",$r[1]);

	if($strufour){

		$create=Convert2Mysql4($create);

	}

	$dumpsql.="CreateTable(\"".$create."\");\r\n";

	return $dumpsql;

}

function ExcuteSetCharset($char){

	if(empty($char)){

		return '';

	}

	$dumpsql="ExcuteSQL('set names \'".$char."\'');\r\n";

	return $dumpsql;

}

function DeleteDbcharset($sql){

	global $phpyun_db_ver;

	if($phpyun_db_ver=='4.0'&&strstr($sql,' character set ')){

		$preg_str="/ character set (.+?) collate (.+?) /is";

		$sql=preg_replace($preg_str,' ',$sql);

	}

	return $sql;

}

function FetchDbcharset($sql){

	global $phpyun_db_ver,$phpyun_db_char,$b_dbchar;

	if($phpyun_db_ver>='4.1'&&!strstr($sql,'ENGINE=')&&($phpyun_db_char||$b_dbchar)&&$b_dbchar!='auto'){

		$dbcharset=$b_dbchar?$b_dbchar:$phpyun_db_char;

		$sql=GetCreateTableSql($sql,$phpyun_db_ver,$dbcharset);

	}elseif($phpyun_db_ver=='4.0'&&strstr($sql,'ENGINE=')){

		$sql=Convert2Mysql4($sql);

	}

	$sql=DeleteDbcharset($sql);

	return $sql;

}

function GetCreateTableSql($sql,$mysqlver,$dbcharset){

	$type=strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU","\\2",$sql));

	$type=in_array($type,array('MYISAM','HEAP'))?$type:'MYISAM';

	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU","\\1",$sql).

		($mysqlver>='4.1'?" ENGINE=$type DEFAULT CHARSET=$dbcharset":" TYPE=$type");

}


function RecoverData($add,$mypath){

	global $db,$bakpath,$config;

	if(empty($mypath)||empty($add[mydbname])){


	}

    $path=PLUS_PATH.'/bdata/'.$mypath;

	if(!file_exists($path)){


    }

	@include($path."/config.php");

	if(empty($b_table)){


	}

	$waitbaktime=(int)$add['waitbaktime'];

	$btb=explode(",",$b_table);

	$nfile='data/plus/bdata/'.$mypath."/".$btb[0]."_1.php?t=0&p=0&mydbname=$add[mydbname]&mypath=$mypath&waitbaktime=$waitbaktime";

	Header("Location:".$config['sy_weburl']."/$nfile");

	exit();

}

?>