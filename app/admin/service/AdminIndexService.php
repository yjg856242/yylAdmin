<?php
/*
 * @Description  : 控制台
 * @Author       : https://github.com/skyselang
 * @Date         : 2020-05-17
 * @LastEditTime : 2021-03-18
 */

namespace app\admin\service;

class AdminIndexService
{
    /**
     * 首页
     *
     * @return array
     */
    public static function index()
    {
        $data['name']   = 'yylAdmin';
        $data['desc']   = '基于ThinkPHP6和Vue2的极简后台管理系统';
        $data['gitee']  = 'https://gitee.com/skyselang/yylAdmin';
        $data['github'] = 'https://github.com/skyselang/yylAdmin';

        return $data;
    }
}
