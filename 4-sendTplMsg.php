<?php

$access_token = '';

$openid = '';

$tplId = '';

$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;

$data = '{
    "touser":"'.$openid.'",
    "template_id":"'.$tplId.'",
    "topcolor": "#8d8d8d",
    "url":"http://conntest.catscarlet.com/",
    "data":{
        "first": {
        "value":"邮件标题！",
        "color":"#173177"
        },
    "subject":{
        "value":"测试消息",
        "color":"#6c1777"
        },
    "sender": {
        "value":"一条模板消息",
        "color":"#3059c7"
        },
    "remark":{
        "value":"这是remark！",
        "color":"#771759"
        }
    }
}
';

$rst = httpsRequest($url, $data);
$result = json_decode($rst, true);
echo 'Result:'."\n";
print_r($result);

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
