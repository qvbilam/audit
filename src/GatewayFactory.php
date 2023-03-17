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

use Qvbilam\Audit\Contracts\GatewayInterface;
use Qvbilam\Audit\Exceptions\InvalidArgumentException;
use function class_implements;
use function in_array;
use function sprintf;

class GatewayFactory
{
    protected $config;
    protected $gateways = [];

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function formatGateways(array $gateways): array
    {
        $formatted = [];

        foreach ($gateways as $gateway => $setting) {
            if (is_int($gateway) && is_string($setting)) {
                $gateway = $setting;
                $setting = [];
            }

            $formatted[$gateway] = $setting;
            $globalSettings = $this->config->get("gateways.$gateway", []);

            if (is_string($gateway) && !empty($globalSettings) && is_array($setting)) {
                $formatted[$gateway] = new Config(array_merge($globalSettings, $setting));
            }
        }

        return $formatted;
    }

    /**
     * @return mixed|GatewayInterface
     *
     * @throws InvalidArgumentException
     */
    public function gateway(string $name)
    {
        if (!isset($this->gateways[$name])) {
            $this->gateways[$name] = $this->createGateway($name);
        }

        return $this->gateways[$name];
    }

    protected function formatGatewayClassName($name): string
    {
        $name = ucfirst(str_replace(['-', '_', ''], '', $name));

        return __NAMESPACE__."\\Gateways\\{$name}Gateway";
    }

    /**
     * @param mixed $gateway
     * @param mixed $config
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    protected function makeGateway($gateway, $config)
    {
        if (!class_exists($gateway) || !in_array(GatewayInterface::class, class_implements($gateway))) {
            throw new InvalidArgumentException('网关未继承');
        }

        return new $gateway($config);
    }

    /**
     * > This function creates a gateway object based on the name of the gateway.
     *
     * @param string name The name of the gateway to create
     *
     * @return GatewayInterface A gateway object
     *
     * @throws InvalidArgumentException
     */
    protected function createGateway(string $name): GatewayInterface
    {
        $config = $this->config->get("gateways.$name", []);
        if (!isset($config['timeout'])) {
            $config['timeout'] = $this->config->get('timeout', 5);
        }
        $config['options'] = $this->config->get('options', []);

        $className = $this->formatGatewayClassName($name);
        $gateway = $this->makeGateway($className, $config);

        if (!($gateway instanceof GatewayInterface)) {
            throw new InvalidArgumentException(sprintf('Gateway "%s" must implement interface %s.', $name, GatewayInterface::class));
        }

        return $gateway;
    }
}
