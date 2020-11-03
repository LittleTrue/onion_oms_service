<?php

namespace onion\OmsClient\Base;

use GuzzleHttp\Psr7\Response;
use onion\OmsClient\Base\Exceptions\ClientError;

/**
 * Trait MakesHttpRequests
 */
trait MakesHttpRequests
{
    /**
     * @var bool
     */
    protected $transform = true;

    /**
     * @var string
     */
    protected $baseUri = '';

    /**
     * @throws ClientError
     */
    public function request($method, $uri, array $options = [])
    {
        $uri = $this->app['config']->get('base_uri') . $uri;

        $response = $this->app['http_client']->request($method, $uri, $options);

        return $this->transform ? $this->transformResponse($response) : $response;
    }

    /**
     * @throws ClientError
     */
    protected function transformResponse(Response $response)
    {
        if (200 != $response->getStatusCode()) {
            throw new ClientError(
                "接口连接异常，异常码：{$response->getStatusCode()}，请联系管理员",
                $response->getStatusCode()
            );
        }
        $result = json_decode($response->getBody()->getContents(), true);

        //返回代码:0 成功,300-399 验证失败,400-499 业务异常,500+ 系统异常 
        if ($result['code'] == 0) {
            return $result;
        } else {
            throw new ClientError($result['msg'], $result['code']);
        }
    }
}
