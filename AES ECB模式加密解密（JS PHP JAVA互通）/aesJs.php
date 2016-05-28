<!DOCTYPE html>
<html>
<head>
    <title>aes demo</title>
    <meta charset="utf-8"/>
    <style>
        *{margin:0;padding:0}
        .demo-wrap{width: 400px;height: 50px;margin: 50px auto auto auto}
    </style>
       <script type="text/javascript" src="CryptoJS/rollups/aes.js" charset="utf-8"></script>
       <script type="text/javascript" src="CryptoJS/components/mode-ecb-min.js" charset="utf-8"></script>
<!--    <script src="./components/pad-zeropadding.js"></script>-->
</head>
<body>
<div class="demo-wrap">
    <input type="text" id="data-ipt"/>
    <button onclick="getAES();">AES加密</button>
    <button onclick="getDAes();">AES解密</button>
</div>
    <script>
        function getAesString(data,key){//加密
            var key  = CryptoJS.enc.Utf8.parse(key); 
            var encrypted = CryptoJS.AES.encrypt(data,key,
                    {
                        mode:CryptoJS.mode.ECB,
                        padding:CryptoJS.pad.Pkcs7
                    });
            return encrypted.toString();
        }
        function getDAesString(encrypted,key){//解密
            var key  = CryptoJS.enc.Utf8.parse(key); 
            var decrypted = CryptoJS.AES.decrypt(encrypted,key,
                    {
                        mode:CryptoJS.mode.ECB,
                        padding:CryptoJS.pad.Pkcs7
                    });
            return decrypted.toString(CryptoJS.enc.Utf8);
        }
        function getAES(){ //加密
            var data = document.getElementById("data-ipt").value;//明文
            var key  = 'f0d8f6c4810e9034';  //密钥
            var encrypted = getAesString(data,key); //密文
            console.log(encrypted);
        }

        function getDAes(){//解密
            var encrypted = 'ae/xvcGLJZmEg+ylP0AmHA=='; //密文
            var key  = 'f0d8f6c4810e9034';
            var decryptedStr = getDAesString(encrypted,key);
            console.log(decryptedStr);
        }
        </script>

</body>
</html>