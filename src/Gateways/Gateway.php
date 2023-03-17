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

namespace Qvbilam\Audit\Gateways;

use Qvbilam\Audit\Config;
use Qvbilam\Audit\Contracts\GatewayInterface;
use function get_class;

abstract class Gateway implements GatewayInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * @var array
     */
    protected $clientOptions;

    public function __construct(array $config)
    {
        $this->config = new Config($config);
        $this->setClientOptions(['timeout' => $this->config->get('timeout', 5)]);
    }

    /**
     * > It returns the name of the class, but without the namespace and the word "Gateway" at the end.
     *
     * @return string the name of the gateway
     */
    public function getName(): string
    {
        return strtolower(str_replace([__NAMESPACE__.'\\', 'Gateway'], '', get_class($this)));
    }

    /**
     * It returns the timeout value.
     *
     * @return int the timeout value
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * > Sets the timeout for the gateway.
     *
     * @param int timeout The timeout of the request in seconds
     *
     * @return Gateway the Gateway object
     */
    public function setTimeout(int $timeout): Gateway
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * It returns the clientOptions array.
     *
     * @return array the clientOptions array
     */
    public function getClientOptions(): array
    {
        return $this->clientOptions;
    }

    /**
     * > Sets the client options for the widget.
     *
     * @param array clientOptions An array of options to pass to the client
     */
    public function setClientOptions(array $clientOptions)
    {
        $this->clientOptions = $clientOptions;
    }
}