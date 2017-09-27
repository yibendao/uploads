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
class DES_NET{  
    var $key;  
    var $iv; 
       
    function DES_NET( $key, $iv=0 ) {  
        $this->key = $key;  
        if( $iv == 0 ) {  
            $this->iv = $key;
        } else {  
            $this->iv = $iv;
        }  
    }         
    function encrypt($str) {  
        $size = mcrypt_get_block_size ( MCRYPT_DES, MCRYPT_MODE_CBC );  
        $str = $this->pkcs5Pad ( $str, $size );  
        return strtoupper( bin2hex( mcrypt_cbc(MCRYPT_DES, $this->key, $str, MCRYPT_ENCRYPT, $this->iv ) ) );  
    }         
    function decrypt($str) {  
        $strBin = $this->hex2bin( strtolower( $str ) );  
        $str = mcrypt_cbc( MCRYPT_DES, $this->key, $strBin, MCRYPT_DECRYPT, $this->iv );  
        $str = $this->pkcs5Unpad( $str );  
        return $str;  
    }         
    function hex2bin($hexData) {  
        $binData = "";  
        for($i = 0; $i < strlen ( $hexData ); $i += 2) {  
            $binData .= chr ( hexdec ( substr ( $hexData, $i, 2 ) ) );  
        }  
        return $binData;  
    }     
    function pkcs5Pad($text, $blocksize) {  
        $pad = $blocksize - (strlen ( $text ) % $blocksize);  
        return $text . str_repeat ( chr ( $pad ), $pad );  
    }  
    function pkcs5Unpad($text) {
        $pad = ord ( $text {strlen ( $text ) - 1} );  
        if ($pad > strlen ( $text ))  
            return false;  
        if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad)  
            return false;  
        return substr ( $text, 0, - 1 * $pad ); 
    }  
} 
?>