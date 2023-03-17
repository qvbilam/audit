<?php
declare(strict_types=1);

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
     * @param string $type
     * @param string $content
     * @param array $gateways
     * @return array
     * @throws HttpException
     */
    public function audit(string $type, string $content, array $gateways = []): array
    {
        $this->content->setContentType($type);
        $this->content->setContent($content);


        $isSuccessful = false;
        $result = [];
        foreach ($this->gatewayFactory->formatGateways($gateways) as $gateway => $config){
            $result[$gateway]["gateway"] = $gateway;
            try{
                $result[$gateway]["status"] = self::STATUS_SUCCESS;
                $result[$gateway]["result"] = $this->gatewayFactory->gateway($gateway)->$type($this->content);
                $isSuccessful = true;
                break;
            }catch (Exception $e){
                echo $e->getMessage() . PHP_EOL;
                $result[$gateway]["status"] = self::STATUS_FAIL;
                $result[$gateway]["status"] = $e;
            }
        }

        if(!$isSuccessful){
            throw new HttpException("无可用网关");
        }

        return $result;
    }
}