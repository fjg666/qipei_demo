<?php

function curl_post_ssl($url, $vars, $second=30,$aHeader=array()){
	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_TIMEOUT,$second);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
 
	if( count($aHeader) >= 1 ){
		curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
	}
 
	curl_setopt($ch,CURLOPT_POST, 1);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
	$data = curl_exec($ch);
	if($data){
		curl_close($ch);
		return $data;
	}else { 
		$error = curl_errno($ch);
		echo "call faild, errorCode:$error\n"; 
		curl_close($ch);
		return false;
	}
}

$data = curl_post_ssl('https://api.mch.weixin.qq.com/secapi/pay/refund', 'merchantid=1001000');
print_r($data);
