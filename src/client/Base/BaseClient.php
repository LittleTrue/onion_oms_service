<?php

namespace onion\OmsClient\Base;

use GuzzleHttp\RequestOptions;
use onion\OmsClient\Application;
use onion\OmsClient\Base\Exceptions\ClientError;

/**
 * 底层请求
 */
class BaseClient
{
    use MakesHttpRequests;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $json = [];

    /**
     * @var string
     */
    protected $language = 'zh-cn';

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Set json params.
     *
     * @param array $json Json参数
     */
    public function setParams(array $json)
    {
        $this->json = json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Set Headers Language params.
     *
     * @param string $language 请求头中的语种标识
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Make a get request.
     *
     * @throws ClientError
     */
    public function httpGet($uri, array $options = [])
    {
        $options = $this->_headers($options);

        return $this->request('GET', $uri, $options);
    }

    /**
     * Make a post request.
     *
     * @throws ClientError
     */
    public function httpPostJson($uri)
    {
        return $this->requestPost($uri, [RequestOptions::BODY => $this->json]);
    }

    /**
     * @throws ClientError
     */
    protected function requestPost($uri, array $options = [])
    {
        $options = $this->_headers($options);

        return $this->request('POST', $uri, $options);
    }

    /**
     * set Headers.
     *
     * @return array
     */
    private function _headers(array $options = [])
    {
        $timestamp                        = date('Y-m-d H:i:s');
        $private_key                      = $this->app['config']->get('private_key');
        $options[requestOptions::HEADERS] = [
            'Content-type' => 'application/json',
            'app_key'      => $this->app['config']->get('app_key'),
            'timestamp'    => $timestamp,
            'sign'         => strtoupper(md5($private_key . $this->json . $private_key)),
        ];

        return $options;
    }
}
