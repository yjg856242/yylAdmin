<?php
/*
 * @Description  : index配置
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-11-24
 * @LastEditTime : 2021-03-10
 */

return [
    // 是否记录日志
    'is_log' => true,
    // 接口白名单
    'whitelist' => [
        'index/',
        'index/Register/register',
        'index/Login/verify',
        'index/Login/login',
        'index/Login/weixin',
    ],
    // token 
    'token' => [
        // 密钥
        'key' => '2V81aWjC9k8f',
        // 签发者
        'iss' => 'yylAdminIndex',
        // 有效时间(小时)
        'exp' => 7200,
    ],
    // token key
    'token_key' => 'UserToken',
    // 请求频率限制（次数/时间）
    'throttle' => [
        'number' => 3,   //次数,0不限制
        'expire' => 1,   //时间,单位秒
    ],
    // 验证码配置
    'verify' => [
        // 是否开启验证码
        'switch' => true,
        // 是否画混淆曲线
        'curve' => false,
        // 是否添加杂点
        'noise' => true,
        // 使用背景图片
        'bgimg' => false,
        // 验证码类型：1数字，2字母，3数字字母，4算术，5中文
        'type' => 1,
        // 验证码位数
        'length' => 4,
        // 验证码有效时间
        'expire' => 180,
    ]
];
