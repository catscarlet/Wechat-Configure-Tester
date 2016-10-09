<?php

$access_token = '';

$openid = '';
$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

$rst = httpsRequest($url);
$result = json_decode($rst, true);

print_r($result);

exit();

function httpsRequest($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    if (!empty($data)) {
        echo "go post data: $data \n";
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    } else {
        echo "go get:\n";
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($curl);
    //echo print_r(curl_getinfo($curl), true)."\n";
    curl_close($curl);

    return $output;
}
