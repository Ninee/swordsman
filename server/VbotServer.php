<?php
/**
 * Created by PhpStorm.
 * User: hirsi
 * Email: whuanxu@163.com
 * Github: https://github.com/Ninee
 * Date: 2017/8/23
 * Time: 下午8:34
 */

namespace Server;
use Hanson\Vbot\Foundation\Vbot;
use Hanson\Vbot\Message\Text;

class VbotServer
{

    private $config;

    public function __construct()
    {
        $this->config = require_once __DIR__ . '/config/vbot.php';
    }

    public function run()
    {
        $robot = new Vbot($this->config);

        $robot->observer->setQrCodeObserver([Observer::class, 'setQrCodeObserver']);
        $robot->observer->setBeforeMessageObserver([Observer::class, 'setBeforeMessageObserver']);
        $robot->observer->setExitObserver([Observer::class, 'setExitObserver']);
        $robot->observer->setFetchContactObserver([Observer::class, 'setFetchContactObserver']);
        $robot->observer->setLoginSuccessObserver([Observer::class, 'setLoginSuccessObserver']);
        $robot->observer->setNeedActivateObserver([Observer::class, 'setNeedActivateObserver']);
        $robot->observer->setReLoginSuccessObserver([Observer::class, 'setReLoginSuccessObserver']);

        $robot->messageHandler->setHandler([MessageHandler::class, 'setHandler']);
        $robot->server->serve();
    }
}