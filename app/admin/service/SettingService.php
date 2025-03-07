<?php
/*
 * @Description  : 设置
 * @Author       : https://github.com/skyselang
 * @Date         : 2021-03-09
 * @LastEditTime : 2021-03-10
 */

namespace app\admin\service;

use think\facade\Db;
use app\common\cache\SettingCache;

class SettingService
{
    // 默认设置id
    private static $setting_id = 1;

    /**
     * 验证码设置
     *
     * @param array  $param  验证码参数
     * @param string $method 请求方式
     *
     * @return array
     */
    public static function verify($param = [], $method = 'get')
    {
        if ($method == 'get') {
            $setting = self::setting();
            $verify  = $setting['verify'];
        } else {
            $setting_id = self::$setting_id;

            $verify['switch'] = $param['switch'];
            $verify['curve']  = $param['curve'];
            $verify['noise']  = $param['noise'];
            $verify['bgimg']  = $param['bgimg'];
            $verify['type']   = $param['type'];
            $verify['length'] = $param['length'];
            $verify['expire'] = $param['expire'];

            $update['verify']      = serialize($verify);
            $update['update_time'] = date('Y-m-d H:i:s');

            $setting = Db::name('setting')
                ->where('setting_id', $setting_id)
                ->update($update);

            if (empty($setting)) {
                exception();
            } else {
                SettingCache::del($setting_id);
            }
        }

        $VerifyService = new VerifyService();

        $verify = array_merge($verify, $VerifyService->verify());

        return $verify;
    }

    /**
     * Token设置
     *
     * @param array  $param  token参数
     * @param string $method 请求方式
     *
     * @return array
     */
    public static function token($param = [], $method = 'get')
    {
        if ($method == 'get') {
            $setting = self::setting();
            $token   = $setting['token'];
        } else {
            $setting_id = self::$setting_id;

            $token['iss'] = $param['iss'];
            $token['exp'] = $param['exp'];

            $update['token']       = serialize($token);
            $update['update_time'] = date('Y-m-d H:i:s');

            $setting = Db::name('setting')
                ->where('setting_id', $setting_id)
                ->update($update);

            if (empty($setting)) {
                exception();
            } else {
                SettingCache::del($setting_id);
            }
        }

        return $token;
    }

    /**
     * 默认设置
     *
     * @return array
     */
    public static function setting()
    {
        $setting_id = self::$setting_id;

        $setting = SettingCache::get($setting_id);

        if (empty($setting)) {
            $setting = Db::name('setting')
                ->where('setting_id', $setting_id)
                ->find();

            if (empty($setting)) {
                $setting['setting_id']  = $setting_id;
                $setting['verify']      = serialize([]);
                $setting['token']       = serialize([]);
                $setting['create_time'] = date('Y-m-d H:i:s');
                Db::name('setting')
                    ->insert($setting);
            }

            // 验证码
            $verify = unserialize($setting['verify']);
            if (empty($verify)) {
                $verify['switch'] = false;  //开关
                $verify['curve']  = false;  //曲线
                $verify['noise']  = false;  //杂点 
                $verify['bgimg']  = false;  //背景图
                $verify['type']   = 1;      //类型：1数字，2字母，3数字字母，4算术，5中文
                $verify['length'] = 4;      //位数3-6位
                $verify['expire'] = 180;    //有效时间（秒）
            }

            // Token
            $token = unserialize($setting['token']);
            if (empty($token)) {
                $token['iss'] = 'yylAdmin';  //签发者
                $token['exp'] = 7200;        //有效时间（小时）
            }

            $setting['verify']      = serialize($verify);
            $setting['token']       = serialize($token);
            $setting['update_time'] = date('Y-m-d H:i:s');
            Db::name('setting')
                ->where('setting_id', $setting_id)
                ->update($setting);

            SettingCache::set($setting_id, $setting);

            $setting['verify'] = $verify;
            $setting['token']  = $token;
        } else {
            $setting['verify'] = unserialize($setting['verify']);
            $setting['token']  = unserialize($setting['token']);
        }

        return $setting;
    }
}
