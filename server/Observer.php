<?php
/**
 * Created by PhpStorm.
 * User: hirsi
 * Email: whuanxu@163.com
 * Github: https://github.com/Ninee
 * Date: 2017/8/29
 * Time: 下午10:56
 */

namespace Server;


class Observer
{

    public static function setQrCodeObserver($qrCodeUrl)
    {
        vbot('console')->log('获取二维码链接:' . $qrCodeUrl, '自定义消息');
        file_put_contents(vbot('config')['path'] . '/qrurl.txt', $qrCodeUrl);
    }

    public static function setBeforeMessageObserver()
    {
        vbot('console')->log('准备接收消息', '自定义消息');
    }

    public static function setExitObserver()
    {
        vbot('console')->log('程序退出', '自定义消息');
    }

    public static function  setFetchContactObserver()
    {
        vbot('console')->log('获取通讯录', '自定义消息');
    }

    public static function setLoginSuccessObserver()
    {
        vbot('console')->log('登录成功', '自定义消息');
    }

    public static function setNeedActivateObserver()
    {
        vbot('console')->log('将要掉线', '自定义消息');
    }

    public static function setReLoginSuccessObserver()
    {
        vbot('console')->log('重新登录成功', '自定义消息');
    }

}