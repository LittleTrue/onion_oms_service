<?php

namespace onion\OmsService;

use onion\OmsClient\Application;
use onion\OmsClient\Base\Exceptions\ClientError;
use onion\OmsClient\Order\Client as Order;

/**
 * 订单推送
 */
class OrderService
{
    /**
     * @var Order
     */
    private $orderClient;

    public function __construct(Application $app)
    {
        $this->orderClient = $app['order'];
    }

    /**
     * 1210订单推送.
     *
     * @throws ClientError
     */
    public function batchOrderInfo(array $infos)
    {
        if (empty($infos)) {
            throw new ClientError('参数缺失', 1000001);
        }

        //校验必须字段与数据, 数据结构
        if (!isset($infos['orderItems']) || !is_array($infos['orderItems'])) {
            throw new ClientError('数组参数缺失', 1000001);
        }

        $response = $this->orderClient->batchOrderInfo($infos);

        return $response['msg'];
    }
}
