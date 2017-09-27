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
/**
 * 生成签名类
 *
 * @version 3.0.0
 * @author open.qq.com
 * @copyright ? 2011, Tencent Corporation. All rights reserved.
 * @ History:
 *               3.0.0 | nemozhang | 2011-12-10 11:24:01 | initialization
 */



/**
 * 生成签名类
 */
class SnsSigCheck
{
	/**
	 * 生成签名
	 *
	 * @param string 	$method 请求方法 "get" or "post"
	 * @param string 	$url_path
	 * @param array 	$params 表单参数
	 * @param string 	$secret 密钥
	 */
    static public function makeSig($method, $url_path, $params, $secret)
    {
        $mk = self::makeSource($method, $url_path, $params);
        $my_sign = hash_hmac("sha1", $mk, strtr($secret, '-_', '+/'), true);
        $my_sign = base64_encode($my_sign);

        return $my_sign;
    }

	static private function makeSource($method, $url_path, $params)
    {
        $strs = strtoupper($method) . '&' . rawurlencode($url_path) . '&';

        ksort($params);
        $query_string = array();
        foreach ($params as $key => $val )
        {
            array_push($query_string, $key . '=' . $val);
        }
        $query_string = join('&', $query_string);

        return $strs . rawurlencode($query_string);
    }
}


// end of script
