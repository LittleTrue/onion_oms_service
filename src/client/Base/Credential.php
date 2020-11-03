<?php

namespace onion\OmsClient\Base;

use GuzzleHttp\RequestOptions;
use onion\OmsClient\Application;
use onion\OmsClient\Base\Exceptions\ClientError;

/**
 * 身份验证.
 */
class Credential
{
    use MakesHttpRequests;

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get token - 基于auth2.0.
     *
     * @throws ClientError
     */
    // public function token()
    // {
    //     if ($value = $this->app['cache']->get($this->cacheKey())) {
    //         return $value;
    //     }

    //     $result = $this->request(
    //         'POST',
    //         $this->app['config']->get('basics_uri') . '/login/login',
    //         [
    //             RequestOptions::JSON    => $this->credentials(),
    //         ]
    //     );
    //     $this->setToken($token = $result['data']['token'], 7000);

    //     return $token;
    // }

    /**
     * Get token - 快速通信 -- 基于持久化用户token.
     *
     * @throws ClientError
     */
    public function token()
    {
        return $this->app['config']->get('token');
    }

    /**
     * Set token.
     *
     * @param null $ttl
     */
    public function setToken($token, $ttl = null)
    {
        $this->app['cache']->set($this->cacheKey(), $token, $ttl);

        return $this;
    }

    /**
     * Get credentials.
     */
    protected function credentials()
    {
        return [
            'username' => $this->app['config']->get('user_name'),
            'passwd'   => $this->app['config']->get('passwd'),
        ];
    }

    /**
     * Get cachekey.
     */
    protected function cacheKey()
    {
        return 'terp-service-client:' . md5(json_encode($this->credentials()));
    }
}
