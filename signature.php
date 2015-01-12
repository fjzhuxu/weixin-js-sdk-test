<?php
function signature()
{
    // you must define TOKEN by yourself
    // if (!defined("TOKEN")) {
    //     throw new Exception('TOKEN is not defined!');
    // }
    
    $noncestr = $_GET["noncestr"];
    $timestamp = $_GET["timestamp"];
    $jsapi_ticket = $_GET["jsapi_ticket"];
    $url = 'http://test.m.vip.com/weixin_js_sdk/index.html';
    		
	$tmpStr = 'jsapi_ticket=' .$jsapi_ticket. '&noncestr=' .$noncestr. '&timestamp=' .$timestamp. '&url=' .$url;
	$tmpStr = sha1( $tmpStr );

	echo $tmpStr;
	
	// if( $tmpStr == $signature ){
	// 	return true;
	// }else{
	// 	return false;
	// }
}

signature();


?>

