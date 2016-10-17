# Wechat Configure Tester

## Introduction
这是一个微信配置检测工具。在有 appID 和 appsecret 的条件下，可以：

- 获取 access_token
- 获取 用户列表
- 获取 指定用户详细信息
- 获取 模板列表
- 并可 发送模板消息

可用于检测部分微信配置是否正确，并测试模板消息发送。

在Linux命令行下运行完美，需要php环境支持。

## The reason why I make it.
（急着用，请跳过本段）

把能配置微信公众平台的产品卖出去了，却发现服务不能正常工作，比如发不出去模板消息。

用户把锅往售前身上一甩，售前又来了个二传甩到你身上。

结果发现产品底层无法连接，Debug不能，错误信息看不到，界面不记录错误日志，问题原因无法定位。

除了能看到已配置的 appID、appsecret 和 模板ID 之外，啥都看不到，两眼一抹黑。

- 是 网络 有问题？
- 是 appID、appsecret 填错了？
- 是 模板ID 写错了？


- 要 电话支持 吗？
- 要 使用QQ远程 吗？
- 要 去现场支持 吗？
- 要 装个Teamviewer 吗？
- 要 [来个SSH-Tunnel](http://blog.catscarlet.com/201609082503.html) 吗？（去你的吧）

去他妈的！

## Usage

目前有 5 个文件，每个文件对应独立功能。

### 运行方法：

使用 php-cli 方式运行：

`php 4-sendTplMsg.php`

结果示例：
```
go post data: {
    "touser":"ofpXxwCr37CVYnKCbd1Evk_0xzec",
    "template_id":"ytWMRMu29EtUm7T640sj5TVFaxZ9Cf5Rgs8R6Leo2i8",
    "topcolor": "#8d8d8d",
    "url":"http://conntest.catscarlet.com/",
    "data":{
        "first": {
        "value":"邮件标题！",
        "color":"#173177"
        },
    "subject":{
        "value":"测试消息",
        "color":"#173177"
        },
    "sender": {
        "value":"一条模板消息",
        "color":"#173177"
        },
    "remark":{
        "value":"这是remark！",
        "color":"#173177"
        }
    }
}

Result:
Array
(
    [errcode] => 0
    [errmsg] => ok
    [msgid] => 410372815
)
```

**Result** 即为微信服务器返回的结果，可根据此结果判断是否有错误，比如 access_token 过期、模板ID错误等。

#### 0-getToken.php
获取 access_token。

需要手动修改文件中的 $appid 和 $appsecret。请求成功后会获得 access_token。

（注：此操作会更新access_token，如用户设备仍在运行，可能会互相影响，请注意）

#### 1-getUserList.php
获取用户列表。

- 需要手动修改文件中的 $access_token，修改成 0-getToken.php 获取到的 access_token。

小技巧：有时候用户设备上用户数量太大，而每个微信账号在不同的微信服务号中也不同，会找不到自己的 openid，这时可以先取消自己的微信号订阅，运行一次1-getUserList.php，再关注，再运行一次1-getUserList.php，就可以找到两次的差异，这个差异就是自己的微信openid了。

#### 2-getUserInfo.php
获取用户信息

- 需要手动修改文件中的 $access_token，修改成 0-getToken.php 获取到的 access_token。
- 需要手动修改文件中的 $openid，修改成 1-getUserList.php 获取到的 openid。

只是为了确认找到的是自己的微信号而用。

#### 3-getTplList.php
获取模板列表

- 需要手动修改文件中的 $access_token，修改成 0-getToken.php 获取到的 access_token。

可以获得此微信服务号的所有模板信息。

#### 4-sendTplMsg.php
发送模板消息

- 需要手动修改文件中的 $access_token，修改成 0-getToken.php 获取到的 access_token。
- 需要手动修改文件中的 $openid，修改成 1-getUserList.php 获取到的 openid。
- 需要手动修改文件中的 $tplId，修改成 3-getTplList.php 获取到的 template_id。

- 需要手动修改文件中的 $data ，**需要根据模板格式手工调节，请注意**。

## TODO

一共就4个文件，用于简单测试微信配置。也不包括scope和Token的验证。只适用于作为微信客户端的验证，不能做服务端的验证。所以也没什么优化余地了，顶多就是优化下代码结构而已。

不打算做本地access_token等数据的保存功能，因为这是个临时测试工具，可能会有几个账号互相切换使用的情况，保存了反而更不便于修改。

欢迎 Pull Request。
