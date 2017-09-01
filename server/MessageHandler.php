<?php
/**
 * Created by PhpStorm.
 * User: hirsi
 * Email: whuanxu@163.com
 * Github: https://github.com/Ninee
 * Date: 2017/9/8
 * Time: 下午2:47
 */

namespace Server;


use Illuminate\Support\Collection;
use Server\Handlers\AtallHandler;
use Server\Handlers\GirlHandler;

class MessageHandler
{
    public static function setHandler(Collection $message)
    {
        $groups = vbot('groups');
        $members = vbot('members');
        $myself = vbot('myself');

        AtallHandler::messageHandler($message, $members, $groups);
        GirlHandler::messageHandler($message);
    }
}