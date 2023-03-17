<?php

declare(strict_types=1);

/*
 * This file is part of the qvbilam/audit
 *
 * (c) qvbilam <qvbilam@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Qvbilam\Audit;

use Exception;
use Qvbilam\Audit\Exceptions\HttpException;

class Auditor
{
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL = 'fail';

    protected $gatewayFactory;
    protected $content;

    public function __construct(gatewayFactory $gateway)
    {
        $this->gatewayFactory = $gateway;
        $this->content = new Content();
    }

    /**
     * @throws HttpException
     */
    public function audit(string $type, string $content, array $gateways = []): array
    {
        $this->content->setContentType($type);
        $this->content->setContent($content);

        $isSuccessful = false;
        $result = [];
        foreach ($this->gatewayFactory->formatGateways($gateways) as $gateway => $config) {
            $result[$gateway]['gateway'] = $gateway;
            try {
                $result[$gateway]['status'] = self::STATUS_SUCCESS;
                $result[$gateway]['result'] = $this->gatewayFactory->gateway($gateway)->$type($this->content);
                $isSuccessful = true;
                break;
            } catch (Exception $e) {
                echo $e->getMessage().PHP_EOL;
                $result[$gateway]['status'] = self::STATUS_FAIL;
                $result[$gateway]['status'] = $e;
            }
        }

        if (!$isSuccessful) {
            throw new HttpException('无可用网关');
        }

        return $result;
    }
}
