<?php
/**
 * Created by PhpStorm.
 * User: hirsi
 * Email: whuanxu@163.com
 * Github: https://github.com/Ninee
 * Date: 2017/8/23
 * Time: 下午8:35
 */
namespace Server;
require __DIR__ . '/../vendor/autoload.php';

$vbot = new  VbotServer();
$vbot->run();