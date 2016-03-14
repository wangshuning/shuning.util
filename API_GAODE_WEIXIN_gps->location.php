<?php

include '../lib/wechatConfig.php';
include '../lib/wechatFunc.php';
include '../lib/wechat.class.php';
include '../data/communityArrs.php';//业务覆盖的社区列表

header("Content-type:text/html;charset=utf-8");
$projectName = wechatConfig::getProjectName();
$code = $_GET['code'];
$opt = wechatConfig::getOption();
$appid = $opt['appid'];
$secret = $opt['appsecret'];
$tokenstr = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret
    .'&code='.$code.'&grant_type=authorization_code');
$infoArray = json_decode($tokenstr,true);
$openid = $infoArray['openid'];




/*
*   微信。。。。。。
*/
$we = new Wechat($opt);
$auth = $we->checkAuth();
$js_ticket = $we->getJsTicket();
if (!$js_ticket) {
    echo "获取js_ticket失败！<br>";
    echo '错误码：'.$we->errCode;
    echo ' 错误原因：'.ErrCode::getErrText($weObj->errCode);
    exit;
}
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$js_sign = $we->getJsSign($url);

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta charset="utf-8">
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="./js/weixin.common.js"></script>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=34fe0d6c8fb92fcf5770414d1b107f60&plugin=AMap.Geocoder"></script>
    <!-- <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script> -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="moviePage.css" rel="stylesheet" type="text/css">
    <title>生态农庄服务</title>
    <style>
        .h44text{font-size: 16px;}
    </style>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
    <script>
        /*******************************************************************************************************
        ********************************************************************************************************
        ********************************               微信js-api配置信息            *****************************
        ********************************    注意要使用微信特定jsapi功能，需要引入插件    ****************************
        ********************************************************************************************************
        ********************************************************************************************************
        */
        wx.config({
            debug: false,
            appId: '<?php echo $js_sign['appid']; ?>', // 必填，公众号的唯一标识
            timestamp: <?php echo $js_sign['timestamp']; ?>, // 必填，生成签名的时间戳，切记时间戳是整数型，别加引号
            nonceStr: '<?php echo $js_sign['noncestr']; ?>', // 必填，生成签名的随机串
            signature: '<?php echo $js_sign['signature']; ?>', // 必填，签名，见附录1
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'hideMenuItems',
                'showMenuItems',
                'hideAllNonBaseMenuItem',
                'showAllNonBaseMenuItem',
                'translateVoice',
                'startRecord',
                'stopRecord',
                'onRecordEnd',
                'playVoice',
                'pauseVoice',
                'stopVoice',
                'uploadVoice',
                'downloadVoice',
                'chooseImage',
                'previewImage',
                'uploadImage',
                'downloadImage',
                'getNetworkType',
                'openLocation',
                'getLocation',
                'hideOptionMenu',
                'showOptionMenu',
                'closeWindow',
                'scanQRCode',
                'chooseWXPay',
                'openProductSpecificView',
                'addCard',
                'chooseCard',
                'openCard'
            ]
        });


/*******************************************************************************************************
********************************************************************************************************
********************************               点击获取当前经纬度            *****************************
********************************    1. 检查版本 2.获取经纬度  3.经纬度转地址    ****************************
********************************************************************************************************
********************************************************************************************************
*/
function testclick(){
    wx.checkJsApi({
        jsApiList: [
            'getLocation'
        ],
        success: function (res) {
            if (res.checkResult.getLocation == false) {
                alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
                return;
            }
        }
    });
    wx.getLocation({
        type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
        success: function (res) {
            var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
            var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
            var speed = res.speed; // 速度，以米/每秒计
            var accuracy = res.accuracy; // 位置精度
            //调用逆向地理编码
            regeocoder(longitude,latitude);
        },
        cancel: function(res){
            alert('quxiao');
        }
    });
}


// $(function(){
//     var map = new AMap.Map("container", {
//         resizeEnable: true,
//         zoom: 18
//     }),lnglatXY = []; //已知点坐标
// })


/*******************************************************************************************************
********************************************************************************************************
********************************               参考高德API                  *****************************
********************************            地理编码 -> 逆向地理编码          ****************************
********************************************************************************************************
********************************************************************************************************
*/
    function regeocoder(lat,lng) {  //逆地理编码
        lnglatXY = [lat,lng];
        var geocoder = new AMap.Geocoder({
            radius: 1000,
            extensions: "all"
        });      
        geocoder.getAddress(lnglatXY, function(status, result) {
            console.log(result);
            if (status === 'complete' && result.info === 'OK') {
                geocoder_CallBack(result);
            }
        });        
        // var marker = new AMap.Marker({  //加点
        //     map: map,
        //     position: lnglatXY
        // });
        // map.setFitView();
    }
    function geocoder_CallBack(data) {
        var address = data.regeocode.formattedAddress; //返回地址描述
        alert(address);
    }

    </script>
    <style type="text/css">
    .info{width: 84%;margin: 5% auto 70px;}
    .div_label{float:left;width:22%;color: rgba(136, 136, 136, 1);line-height: 15px;font-size: 15px;}
    .div_form{float:left;width:78%;border-radius: 0px;height: 30.5px;padding: 6px 9px;}
    .div_button{position: fixed;bottom: 0px;border-radius: 0px;background:url('img/btn.png');}
	.styled-select select {background: transparent;width: 110%;padding: 5px;border: 0px;height: 34px;-webkit-appearance: none; /*for chrome*/}
	.styled-select {border: 1px solid #ccc;width: 78%;height: 34px;overflow: hidden;position: relative;}
	.bimg{position: absolute;right: 9.5px;top:12px;height: 8px;width: 13px;background: url('img/xiala.png') ;}
    </style>

</head>
<body>
<div class="wrapper wrapper-content animated fadeInRight" style="width:100%;">           
    <div class="row" style="width:100%;margin-right:0px;margin-left:0px;">    
        <div style="width:100%;">
            <div class="ibox float-e-margins" style="width:100%;">
                <div class="ibox-content" style="width:100%;">
                    <div id="container"></div>
                    <button class="btn btn-primary div_button" type="button" onclick="testclick()" style="width:100%;height:50px;">确认订购</button>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>