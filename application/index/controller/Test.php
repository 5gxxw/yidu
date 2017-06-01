<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/1
 * Time: 9:59
 */

namespace home\index\controller;


use think\Controller;

class Test extends Controller
{
    public function index()
    {
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipaydev.com/gateway.do';
        $aop->appId = '2016080700189337';
        $aop->rsaPrivateKey = 'MIIEpAIBAAKCAQEA4Miwui2OB2j9/kcvFgTw62eFMXQY5wPvHE4eCTMVvbintEeVNcweIWRXBq5FZrBjLBW81s5IOBLUJjWpAiOJHIrD2N6gH8z1HhveafgETZ1zX+D1tQUoQOLFrjecG71sryx7AvGUdZ8SuYNuw6nqlFdQNQooYvlteofK77PRT5GbGJsqZ0pDO+3PCfUGg12rBx1iFr3g7wN54PafutgRpHGhbH4S1ty4rSSXQDZOO4TXcyQfTNrT8yBHkLl9j9cppc7TlW24FhdeY2xM1PTLlcBfJvKH5sME5GQpTs3mBpc7odRQoilTHSwCoft9cm2WfSYry0dXnBZ9SghRzqmolQIDAQABAoIBAA7ZEttpcO1KYSSvvQt+Tg+uqdynZ5Gy79N10YQYDMKYdPNymwePsRnRj/IQBuOOmS5rTSr/O0QA8mSHvN84S7FH9UHZCsiu+C4B90IWsOoTkXBu4qwPaCZJFHe6kqQ+cfRsQr/iB0VxuYHpjaJ9EdK0pcarIhnPkgy69Yu53ASeYOHU/3ScDedGQB0fbPq0n+KwBkrQ9ozY68Pd5PmrGfB1i5GfDfgBP93w33d53tSGSGSP8gOvA2gALMKRrTDOA6YEZ51JL3pK3+9T3O/OyoYniKFY6P6g3fnZXlZbi6gFtmlpci0+fR4WY/aRxx2N+Oshb44lg8st/JvCjAtn380CgYEA+bDPQ/lkorqiD2/qa31qc/pXK7f/CQe0ukuRnSHy5lhXwUY37JTyU9QngRi+gwlieY5nogSd7KB4tJ1TajDrkHpVQJs7k1H+ryMtY0Q2xp6rjLNstzEPExg0KaWomNXsU2wY38njbAw9laefjOG48IHL7P6V/geFMpM/fJgC2i8CgYEA5nbD1zIFaW4RTI9dcvr5Y63dv+4TgSmDG1DvZdp4+S0Gp5sH50YpFfLn1SScBqnRpqPYEmLY9VZYhfS7qOW9CAxOmp/J5pXzD4MzIO+r9pkre+ITP53/Xcv9Xf+6UtVmGy2FS+cx884yIixYLHNPUgCnYJdJ7Kt3V/m3osXxbHsCgYEA10xsC9K5wc9n+iOoYLMt3X9ZNutaz7CDV7fdgT5KsfAvCwq/IhJ0uW/P+HMbouWusd3m4j9U5TqhmiumR4STOmsho6m2vxsOnnmYo2WoTa93gMUd0wBMXUybfeXH8LFVK8Gj2SO+I+aSG78DxnjD/S4OZvZG41ocsjVhos94diUCgYEAkeiXTOMqcflxklsh+u3Sfr1RK3Z7esbhbqXrKz0KYheTowGQG2hcEr1a8aLf9YgGZ85LujhCy/EC0qyDMwdginvgOBz6IrbE0AlskWmsIdAPq7sSHLDXQHcpzh1dxZu9rW9AeTHCem0NaH1SxbGrgmtPjOO7tc9JG7XKAY/4rYkCgYB32dpG7IfMjGAx3cDAHTZgnt2IyQYhdd+4Fy3opIIemde/xTsvwN513mWB/FxctDQh4ytn9IxLZpcskI+VqogsZo/KfKDyJXKIDVrg2DvQ7hHqNYHkZ5sqW95jllmL3JT0Yng7GBFD4BnTbs5RQIWIZNMHhcLTg9KaYlZxg/U0lQ==';
        $aop->alipayrsaPublicKey='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAybJK1n0o5pyfS1CpKlyChtUoCpk8hc30CQWezn7t7vwrapNaycWc/vSNBcwfJwGbcHGQvYi/6RUTTq5oZGP4o4aJNCZ0WEWyznDmiS+kZ9gg1EH4aoarsk+Kwzebim/r6xd3MqNVQ7M5gv5fMRZcapQnphb3/DQ9jhcGKBPfGS4LpHqPLdqb5nFl7HyuLjbgfxkViwT2xE8E6SPTHet7hAkVtWbZNaqsWZ3Imlkzx9PcYogncp+HVYFLk5oI9mnpLXIoVrchn23fE+ekM95BTouiTgzSCPsbStDjcEfSJKY85F8CQCF0nx9yGVItmrBPIbJIUOTNuKgX+7+8TQLTHwIDAQAB';
        $aop->apiVersion = '1.0';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        $aop->signType='RSA2';
        //实例化手机网站支付接口2.0
        $request = new \AlipayTradeWapPayRequest();
        /**
         * 设置参数
         */
        $data = [
            'body' => 'Iphone6 16G',
            'subject' => '大乐透',
            'out_trade_no' => '70501111111S001111119',
            'timeout_express' => '90m',
            'total_amount' => 5999.00,
            'product_code' => 'QUICK_WAP_PAY',
        ];
        $data = json($data);
        $request->setBizContent($data);
        //页面提交执行方法
        $result = $aop->pageExecute ( $request);
        echo $result;
    }
}