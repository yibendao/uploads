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
class smtp{
	var $smtp_port;
	var $time_out;
	var $host_name;
	var $log_file;
	var $relay_host;
	var $debug;
	var $auth;
	var $user;
	var $pass;
	var $sock;
	var $response;
	function smtp($relay_host="",$smtp_port =25,$auth=false,$user,$pass,$fromname){
		$this->debug = FALSE;
		$this->smtp_port = $smtp_port;
		$this->relay_host = $relay_host;
		$this->time_out = 30;
		$this->auth = $auth;
		$this->user = $user;
		$this->pass = $pass;
		$this->host_name = "localhost";
		$this->log_file =dirname(dirname(dirname(__FILE__)))."/data/plus/emailerror.txt";
		$this->sock = FALSE;
		$this->response='';
		$this->fromname=$fromname;
		$this->from=$user;
	}
	function sendmail($to,$subject="",$body="",$mailtype="HTML",$cc="",$bcc="",$additional_headers=""){
		
		
		$mail_from = $this->get_address($this->strip_comment($this->from));
		$body = preg_replace("/(^|(\r\n))(\\.)/", "\\1.\\3", $body);
		$header .= "MIME-Version:1.0\r\n";
		if($mailtype=="HTML"){
			$header .= "Content-Type:text/html\r\n";
		}
		$header .= "To: ".$to."\r\n";
		if ($cc != "") {
			$header .= "Cc: ".$cc."\r\n";
		}
		if($this->fromname==""){
			$fromname = $this->from;
		}else{
			$fromname = $this->fromname;
		}
		$header .= "From: $fromname<".$this->from.">\r\n";
		$header .= "Subject: ".$subject."\r\n";
		$header .= $additional_headers;
		$header .= "Date: ".date("r")."\r\n";
		$header .= "X-Mailer:By Redhat (PHP/".phpversion().")\r\n";
		list($msec, $sec) = @explode(" ", microtime());
		$header .= "Message-ID: <".date("YmdHis", $sec).".".($msec*1000000).".".$mail_from.">\r\n";
		$TO = @explode(",", $this->strip_comment($to));
		if ($cc != "") {
			$TO = array_merge($TO, @explode(",", $this->strip_comment($cc)));
		}
		if ($bcc != "") {
			$TO = array_merge($TO, @explode(",", $this->strip_comment($bcc)));
		}
		$sent = TRUE;
		
		foreach ($TO as $rcpt_to) {
			$rcpt_to = $this->get_address($rcpt_to);
			if (!$this->smtp_sockopen($rcpt_to)) {
				$sent = FALSE;
				continue;
			}
			if ($this->smtp_send($this->host_name,$mail_from,$rcpt_to,$header,$body)) {
			}else{
				$sent = FALSE;
			}
			fclose($this->sock);
			}
			 "<br>";
			 $header;
			 
			return $sent;
			 
			
	}
	function smtp_send($helo, $from, $to, $header, $body = ""){
		if (!$this->smtp_putcmd("HELO", $helo)) {
			return $this->smtp_error("sending HELO command");
		}
		if($this->auth){
			if (!$this->smtp_putcmd("AUTH LOGIN", base64_encode($this->user))) {
				return $this->smtp_error("sending HELO command");
			}

			if (!$this->smtp_putcmd("", base64_encode($this->pass))) {
				return $this->smtp_error("sending HELO command");
			}
		}
		
		if (!$this->smtp_putcmd("MAIL", "FROM:<".$this->from.">")) {
			return $this->smtp_error("sending MAIL FROM command");
		}

		if (!$this->smtp_putcmd("RCPT", "TO:<".$to.">")) {
			return $this->smtp_error("sending RCPT TO command");
		}
		if (!$this->smtp_putcmd("DATA")) {
			return $this->smtp_error("sending DATA command");
		}
		if (!$this->smtp_message($header, $body)) {
			return $this->smtp_error("sending message");
		}

		if (!$this->smtp_eom()) {
			return $this->smtp_error("sending <CR><LF>.<CR><LF> [EOM]");
		}
		if (!$this->smtp_putcmd("QUIT")) {
			return $this->smtp_error("sending QUIT command");
		}
		return TRUE;
	}
	function smtp_sockopen($address){
		if ($this->relay_host == "") {
			return $this->smtp_sockopen_mx($address);
		} else {
			return $this->smtp_sockopen_relay();
		}
	}
	function smtp_sockopen_relay(){
		$this->sock = @fsockopen($this->relay_host, $this->smtp_port, $errno, $errstr, $this->time_out);
		if (!($this->sock && $this->smtp_ok())) {
			$this->log_write("Error: ".$errstr." (".$errno.")\n");
			return FALSE;
		}
		return TRUE;
	}
	function smtp_sockopen_mx($address){
		$domain = preg_replace("/^.+@([^@]+)$/", "\\1", $address);
		if (!@getmxrr($domain, $MXHOSTS)) {
			return FALSE;
		}
		foreach ($MXHOSTS as $host) {
			$this->sock = @fsockopen($host, $this->smtp_port, $errno, $errstr, $this->time_out);
			if (!($this->sock && $this->smtp_ok())) {
				$this->log_write("Error: ".$errstr." (".$errno.")\n");
				
				continue;
			}
			return TRUE;
		}
		return FALSE;
	}
	function smtp_message($header, $body){
		fputs($this->sock, $header."\r\n".$body);
		$this->smtp_debug("> ".str_replace("\r\n", "\n"."> ", $header."\n> ".$body."\n> "));
		return TRUE;
	}
	function smtp_eom(){
		fputs($this->sock, "\r\n.\r\n");
		$this->smtp_debug(". [EOM]\n");
		return $this->smtp_ok();
	}
	function smtp_ok(){
		$response = str_replace("\r\n", "", fgets($this->sock, 512));
		$this->smtp_debug($response."\n");
		if (!preg_match("/^[23]/", $response)) {
			
			fputs($this->sock, "QUIT\r\n");
			fgets($this->sock, 512);
			$this->log_write("Error: Remote host returned \"".$response."\"\n");
			
			return FALSE;
		}
		return TRUE;
	}
	function smtp_putcmd($cmd, $arg = ""){
		if ($arg != "") {
			if($cmd=="") $cmd = $arg;
			else $cmd = $cmd." ".$arg;
		}
		fputs($this->sock, $cmd."\r\n");
		$this->smtp_debug("> ".$cmd."\n");
		return $this->smtp_ok();
	}
	function smtp_error($string){
		return FALSE;
	}
	function log_write($message){
		$this->smtp_debug($message);
		if ($this->log_file == "") {
			return TRUE;
		}
		$message = date("Y-m-d H:i:s ").$message;
		if (!@file_exists($this->log_file) || !($fp = @fopen($this->log_file, "a"))) {
			$this->smtp_debug("Warning: Cannot open log file \"".$this->log_file."\"\n");
			return FALSE;
		}
		flock($fp, LOCK_EX);
		fputs($fp, $message);
		fclose($fp);
		return TRUE;
	}
	function strip_comment($address){
		$comment = "/\\([^()]*\\)/";
		while (preg_match($comment, $address)) {
			$address = preg_replace($comment, "", $address);
		}
		return $address;
	}
	function get_address($address){
		$address = preg_replace("/([ \t\r\n])+/", "", $address);
		$address = preg_replace("/^.*<(.+)>.*$/", "\\1", $address);
		return $address;
	}
	function smtp_debug($message){
		if ($this->debug) {
		 $message."<br>";
		}
	}
	function get_attach_type($image_tag) {
		$filedata = array();
		$img_file_con=@fopen($image_tag,"r");
		unset($image_data);
		while ($tem_buffer=AddSlashes(fread($img_file_con,filesize($image_tag))))
		$image_data.=$tem_buffer;
		fclose($img_file_con);
		$filedata['context'] = $image_data;
		$filedata['filename']= basename($image_tag);
		$extension=substr($image_tag,strrpos($image_tag,"."),strlen($image_tag)-strrpos($image_tag,"."));
		switch($extension){
			case ".gif":
			$filedata['type'] = "image/gif";
			break;
			case ".gz":
			$filedata['type'] = "application/x-gzip";
			break;
			case ".htm":
			$filedata['type'] = "text/html";
			break;
			case ".html":
			$filedata['type'] = "text/html";
			break;
			case ".jpg":
			$filedata['type'] = "image/jpeg";
			break;
			case ".tar":
			$filedata['type'] = "application/x-tar";
			break;
			case ".txt":
			$filedata['type'] = "text/plain";
			break;
			case ".zip":
			$filedata['type'] = "application/zip";
			break;
			default:
			$filedata['type'] = "application/octet-stream";
			break;
		}
		return $filedata;
	}
}
?>