# weixin-js-sdk-test
weixin-js-sdk-test

背景
微信公众平台今日面向开发者开放微信内网页开发工具包（微信JS-SDK）。
通过微信JS-SDK提供的11类接口集，开发者不仅能够在网页上使用微信本身的拍照、选图、语音、位置等基本能力，还可以直接使用微信分享、扫一扫、卡券、支付等微信特有的能力，为微信用户提供更优质的网页体验。
 
目标
搭建微信H5开发环境，尝试使用JS-SDK开放的功能
 
步骤
此教程只包含简单的搭建环境步骤，如有诸如名词释义等问题，请参考官方文档
http://mp.weixin.qq.com/wiki/17/2d4265491f12608cd170a95559800f2d.html
总体流程
登录公众平台 > 获取access_token > 获取jsapi_ticket > 获取签名 > demo页面
登录公众平台
为了更直观的的使用，可通过https://mp.weixin.qq.com/登录微信公众平台，此处无私的贡献15块钱购买的公众号：
【账号】renbei190@163.com
【密码】gl8888
【AppSecret】3da0315247ff4a5bc610013ada2e5313 

其中AppSecret在下文会用到
获取access token
access_token是公众号的全局唯一票据，公众号调用各接口时都需使用access_token。开发者需要进行妥善保存。
获取方式，http GET：
https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
所有字段都可以在上文提供的公众号平台里获得，替换后为：
https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxed5d7df528ec38f9&secret=3da0315247ff4a5bc610013ada2e5313
可以直接在浏览器访问，返回结构为：
{"access_token":"Drnis_5mxIQ9hnYBkSrwyZcBj45JwrCFByN6d189kRtnpxqeEzlDERa0LsPoSMoFaHreuMt1ZaB5ZQVwr6SSF_yoIu0UQt3iehFpKUibKQI","expires_in":7199}
access_token有效时间2小时，每天调用次数也有限制，需要全局缓存，接下来就可以用其调用其他接口
 
详细参考：http://mp.weixin.qq.com/wiki/11/0e4b294685f817b95cbed85ba5e82b8f.html
 
获取jsapi_ticket
生成签名之前必须先了解一下，jsapi_ticket是公众号用于调用微信JS接口的临时票据。正常情况下，jsapi_ticket的有效期为7200秒，通过access_token来获取。由于获取jsapi_ticket的api调用次数非常有限，频繁刷新jsapi_ticket会导致api调用受限，影响自身业务，开发者必须在自己的服务全局缓存jsapi_ticket 。
获取方式，http GET：
https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi
返回结构为：
{
"errcode":0,
"errmsg":"ok",
"ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKd8-41ZO3MhKoyN5OfkWITDGgnr2fwJ0m9E8NYzWKVZvdVtaUgWvsdshFKA",
"expires_in":7200
}
获得jsapi_ticket之后，就可以生成JS-SDK权限验证的签名了。

获取签名
调用JS-SDK接口前，必须在前端进行配置，需要用到权限验证的签名
签名算法参考：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html#.E9.99.84.E5.BD.951-JS-SDK.E4.BD.BF.E7.94.A8.E6.9D.83.E9.99.90.E7.AD.BE.E5.90.8D.E7.AE.97.E6.B3.95
可以直接使用
https://github.com/lexuslin/weixin-js-sdk-test/blob/master/signature.php
copy到本地获取签名，获取方式，http GET：
http://.../signature.php?noncestr=laksej&url=http://test.m.vip.com/weixin_js_sdk/index.html&timestamp=1420949506&jsapi_ticket=sM4AOVdWfPE4DxkXGEs8VP6Sxt6k6fTm2F0RN2h7Z2qadK7VRtLKyzZfgYLpxTZPR7Z_duqnpIbOQwMnmtCYdg
其中，noncestr、timestamp、可以随意填写，url为最终调用JS-SDK的终端页面地址，jsapi_ticket上文已获取
返回签名如下：
50a4735ad8184c96506564e833f4677e052b31f7

接下来就可以做demo了
demo页面
代码可参考
https://github.com/lexuslin/weixin-js-sdk-test/blob/master/index.html

主要代码解释：
需要引入：
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

配置：
 
wx.config({
  debug: true,
  appId: 'wxed5d7df528ec38f9',
  timestamp: 1420949506,
  nonceStr: 'laksej',
  signature: '85e420dc4fe8455ded9d2319ebbbc2a2cb33c500',
  jsApiList: []
})
jsApiList表示页面需要引用的接口，类型为array
注意：签名signature是由timestamp、随机字符串nonceStr生成，所以要保持与生成的时候一致

业务代码：
把所有业务代码包含在，wx.ready(function(){})里就可以了

各接口的调用方式，可以参考官方文档，或者官方demo，这里不再一一阐述

总结
微信这次公开的api，大大的便利了H5开发者，玩法更多。
虽然暂时不是浏览器标准，但目测是未来的方向，基于微信的用户基数，为微信做专门的页面未尝不可
此方向会列入wap xMob的后续规划
 
 



