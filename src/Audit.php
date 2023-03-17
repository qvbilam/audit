<?php
declare(strict_types=1);

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
     * @param string $content
     * @return array
     * @throws Exceptions\HttpException
     */
    public function text(string $content): array
    {
        $gateways = $this->config->get("default.gateways", []);
        return $this->auditor()->audit("text", $content, $gateways);
    }

    /**
     * @param string $image
     * @return array
     * @throws Exceptions\HttpException
     */
    public function image(string $image): array
    {
        $gateways = $this->config->get("default.gateways", []);
        return $this->auditor()->audit("image", $image, $gateways);
    }

    public function auditor(): Auditor
    {
        return $this->auditor ?: $this->auditor = new Auditor($this->gatewayFactory);
    }



}