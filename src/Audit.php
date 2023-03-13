<?php

/*
 * This file is part of the qvbilam/audit
 *
 * (c) qvbilam <qvbilam@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Qvbilam\Audit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Qvbilam\Audit\Enum\RiskEnum;
use Qvbilam\Audit\Enum\StatusEnum;
use Qvbilam\Audit\Exceptions\HttpException;
use Qvbilam\Audit\Response\TextResponse;

class Audit
{
    protected string $key;
    protected string $appId;

    private array $clientOptions = [];

    const REQUEST_SUCCESS_CODE = '1100';

    public function __construct(string $key, string $appId = 'default')
    {
        $this->key = $key;
        $this->appId = $appId;
    }

    public function getHttpClient(): Client
    {
        return new Client($this->clientOptions);
    }

    public function setClientOptions(array $clientOptions): static
    {
        $this->clientOptions = $clientOptions;

        return $this;
    }

    /**
     * 文本审核.
     *
     * @throws GuzzleException
     * @throws HttpException
     */
    public function text(string $text, string $type = 'SOCIAL'): TextResponse
    {
        $url = 'http://api-text-bj.fengkongcloud.com/v2/saas/anti_fraud/text';
        $params = array_filter([
            'accessKey' => $this->key,
            'appId' => $this->appId,
            'type' => $type,
            'data' => [
                'text' => $text,
                'tokenId' =>0,
            ],
        ]);

        try {
            $response = $this->getHttpClient()->post($url, [
                'json' => $params,
            ]);
            if (200 != $response->getStatusCode()) {
                throw new HttpException('请求失败');
            }

            $responseContent = json_decode($response->getBody()->getContents());

            if (self::REQUEST_SUCCESS_CODE != $responseContent->code) {
                throw new HttpException($responseContent->message);
            }
            $responseContentDetail = json_decode($responseContent->detail);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

        $result = new TextResponse();
        $result->setRequestId($responseContent->requestId);
        $result->setRiskType(RiskEnum::SMv2ToType((string) $responseContentDetail->riskType));
        $result->setScore((int) $responseContent->score / 10);
        $result->setText($text);
        $result->setStatus(StatusEnum::SMv2ToStatus($responseContent->riskLevel));
        $result->setDescription($responseContentDetail->description);

        return $result;
    }
}
