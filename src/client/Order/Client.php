<?php
/*
 * @Description: 
 * @Version: 
 * @Author: Yan
 * @Date: 2020-11-04 15:57:50
 * @LastEditors: Yan
 * @LastEditTime: 2020-11-04 16:43:18
 */

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

    /**
     * 进口订单申报状态查询
     */
    public function queryOrder(array $infos)
    {
        $this->setParams($infos);

        return $this->httpPostJson('/qh-haikou-declare-web/api/order/state');
    }
}
