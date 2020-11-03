<?php

namespace onion\OmsClient\Order;

use onion\OmsClient\Application;
use onion\OmsClient\Base\BaseClient;

/**
 * 订单请求陆海港申报系统
 */
class Client extends BaseClient
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * 推送1210订单.
     */
    public function batchOrderInfo(array $infos)
    {
        $this->setParams($infos);

        return $this->httpPostJson('/qh-haikou-declare-web/api/bbc/import/order/push');
    }
}
