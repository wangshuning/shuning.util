<?php

$xmlData = '<xml>
	<appid>wx3858b4d26cfcb1de</appid>
	<attach>党费</attach>
	<body>党费</body>
	<mch_id>1333510001</mch_id>
	<nonce_str>f86453047fdf45f29f4df0294fc06f20</nonce_str>
	<notify_url>/interface/payment/payConfirmWechat.do</notify_url>
	<out_trade_no>3081</out_trade_no>
	<spbill_create_ip>0:0:0:0:0:0:0:1</spbill_create_ip>
	<total_fee>1</total_fee>
	<trade_type>APP</trade_type>
	<sign>8C8CD3CED639B2EABD020F1E41A5D3D3</sign>
</xml>';

$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';  //接收xml数据的文件
$header[] = "Content-type: text/xml";        //定义content-type为xml,注意是数组
$ch = curl_init ($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
$response = curl_exec($ch);
var_dump($response);
if(curl_errno($ch)){
    print curl_error($ch);
}
curl_close($ch);