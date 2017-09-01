<?php
/**
 * Created by PhpStorm.
 * User: hirsi
 * Email: whuanxu@163.com
 * Github: https://github.com/Ninee
 * Date: 2017/9/8
 * Time: 下午3:08
 */

namespace Server\Handlers;


use Hanson\Vbot\Contact\Groups;
use Hanson\Vbot\Contact\Members;
use Hanson\Vbot\Message\Text;
use Illuminate\Support\Collection;

class AtallHandler
{
    public static $keywords = [
        '@all',
        '@All',
        '@所有人'
    ];

    public static function messageHandler(Collection $message, Members $members, Groups $groups)
    {
        if ($message['type'] === 'text') {
            if (in_array($message['content'], self::$keywords)) {
                vbot('console')->log('触发at所有人关键字', '自定义消息');
                foreach ($groups as $group) {
                    var_dump($group);break;
                }
                foreach ($members as $member) {
                    var_dump($member);break;
                }
//                var_dump($members);
                //组装@所有成员的消息
                $at_all_string = '';
                foreach ($members as $key => $member) {
                    $at_all_string .= '@' . $member['NickName'] . ' ';
                }
                var_dump($at_all_string);
//                Text::send($message['from']['UserName'], $at_all_string);
            }
        }
    }
}