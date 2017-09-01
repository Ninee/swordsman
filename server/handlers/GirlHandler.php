<?php
/**
 * Created by PhpStorm.
 * User: hirsi
 * Email: whuanxu@163.com
 * Github: https://github.com/Ninee
 * Date: 2017/9/8
 * Time: 下午3:19
 */

namespace Server\Handlers;


use GuzzleHttp\Client;
use Hanson\Vbot\Console\Console;
use Hanson\Vbot\Contact\Myself;
use Hanson\Vbot\Message\Text;
use Hanson\Vbot\Message\Image;
use Hanson\Vbot\Support\File;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

class GirlHandler
{
    public static $keywords = [
        '妹子',
        '美女'
    ];

    private static $target = 'http://www.mmjpg.com';

    private static $http_config = [
        'timeout' => 10.0,
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
        ],
    ];

    public static function messageHandler(Collection $message)
    {
        if ($message['type'] === 'text' && $message['isAt']) {

            if (in_array($message['pure'], self::$keywords)) {
                $client = new Client();
                $crawler = new Crawler();

                $username = $message['from']['UserName'];

                // 随机 1 至当前此此站点文章最大 ID
                $number = random_int(1, 1054);

                try {
                    # 获取随机 ID 数据
                    $response = static::request($client, 'GET', static::$target.'/mm/'.$number, static::$http_config);

                    # 解析页码获得文章内最大页数
                    $crawler->clear();
                    $crawler->addHtmlContent($response);

                    $page_links = $crawler->filter('#page>a');

                    $last_page = (int) $page_links->eq($page_links->count() - 2)->html();

                    # 获取随机 ID 中随机页数据
                    $uri = static::$target.'/mm/'.$number.'/'.random_int(1, $last_page);
                    $response = static::request($client, 'GET', $uri, static::$http_config);

                    # 解析页码获得文章内大图地址
                    $crawler->clear();
                    $crawler->addHtmlContent($response);

                    $image_src = $crawler->filter('#content>a>img')->attr('src');

                    $http_config = [
                        'timeout' => 10.0,
                        'headers' => [
                            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
                            'Accept' => 'image/webp,image/apng,image/*,*/*;q=0.8',
                            'Accept-Encoding' => 'gzip, deflate',
                            'Accept-Language' => 'zh-CN,zh;q=0.8,en;q=0.6',
                            'Cache-Control' => 'no-cache',
                            'Connection' => 'keep-alive',
                            'Host' => 'img.mmjpg.com',
                            'Pragma' => 'no-cache',
                            'Referer' => $image_src,
                        ],
                    ];

                    $response = static::request($client, 'GET', $image_src, $http_config);

                    # 存储图片至本地
                    $file_path = vbot('config')['path'].'/girls/'.md5($image_src).'.jpg';
                    File::saveTo($file_path, $response);

                    return Image::send($username, $file_path);
                } catch (\Exception $e) {
                    vbot('console')->log($e->getMessage(), Console::ERROR);

                    return Text::send($username, '暂时无法为您提供服务！');
                }
            }
        }
    }


    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @param bool $origin
     *
     * @return string|\Psr\Http\Message\ResponseInterface;
     */
    public static function request(Client $client, $method, $uri = '', array $options = [], $origin = false)
    {
        $options = array_merge(['timeout' => 10, 'verify' => false], $options);

        $response = $client->request($method, $uri, $options);

        return $origin ? $response : $response->getBody()->getContents();
    }
}