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

class Audit
{
    protected $config;
    protected $auditor;

    protected $gatewayFactory;

    public function __construct(array $config)
    {
        $this->config = new Config($config);
        $this->gatewayFactory = new GatewayFactory($this->config);
    }

    /**
     * @throws Exceptions\HttpException
     */
    public function text(string $content): array
    {
        $gateways = $this->config->get('default.gateways', []);

        return $this->auditor()->audit('text', $content, $gateways);
    }

    /**
     * @throws Exceptions\HttpException
     */
    public function image(string $image): array
    {
        $gateways = $this->config->get('default.gateways', []);

        return $this->auditor()->audit('image', $image, $gateways);
    }

    public function auditor(): Auditor
    {
        return $this->auditor ?: $this->auditor = new Auditor($this->gatewayFactory);
    }
}
