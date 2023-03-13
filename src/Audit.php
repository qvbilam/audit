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

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Qvbilam\Audit\Enum\RiskEnum;
use Qvbilam\Audit\Enum\StatusEnum;
use Qvbilam\Audit\Exceptions\HttpException;
use Qvbilam\Audit\Response\ImageResponse;
use Qvbilam\Audit\Response\TextResponse;

class Audit
{
    /**
     * 应用key
     * @var string
     */
    protected $key;

    /**
     * 应用id
     * @var string
     */
    protected $appId;

    /**
     * 用户id
     * @var string
     */
    protected $userId = "0";

    /**
     * 客户端参数
     * @var array
     */
    private $clientOptions = [];

    const REQUEST_SUCCESS_CODE = '1100';

    /**
     * Audit constructor.
     * @param string $key
     * @param string $appId
     */
    public function __construct($key, $appId = 'default')
    {
        $this->key = $key;
        $this->appId = $appId;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client($this->clientOptions);
    }

    /**
     * @param array $clientOptions
     * @return $this
     */
    public function setClientOptions(array $clientOptions)
    {
        $this->clientOptions = $clientOptions;

        return $this;
    }

    /**
     * 文本审核.
     * @param string $text
     * @param string $type
     * @return TextResponse
     * @throws GuzzleException
     * @throws HttpException
     */
    public function text($text, $type = 'SOCIAL')
    {
        $url = 'http://api-text-bj.fengkongcloud.com/v2/saas/anti_fraud/text';
        $responseContent = $this->request($url, ["text" => $text, "type" => $type]);
        $responseContentDetail = $responseContent->detail;
        if(is_string($responseContent->detail)){
            $responseContentDetail = json_decode($responseContent->detail);
        }
        $result = new TextResponse();
        $result->setRequestId($responseContent->requestId);
        $result->setRiskType(RiskEnum::SMv2ToType((string) $responseContentDetail->riskType));
        $result->setScore((int) $responseContent->score / 10);
        $result->setContent($text);
        $result->setStatus(StatusEnum::SMv2ToStatus($responseContent->riskLevel));
        $result->setDescription($responseContentDetail->description);
        return $result;
    }

    /**
     * 图片审核
     * @param string $image
     * @param string $type
     * @param string $channel
     * @return ImageResponse
     * @throws GuzzleException
     * @throws HttpException
     */
    public function image($image, $type = "POLITICS_PORN_AD_BEHAVIOR", $channel = "HEAD_IMG")
    {
        $url = "http://api-img-bj.fengkongcloud.com/v2/saas/anti_fraud/img";
        $responseContent = $this->request($url, ["img" => $image, "channel" => $channel, "type" => $type]);

        $responseContentDetail = $responseContent->detail;
        if(is_string($responseContent->detail)){
            $responseContentDetail = json_decode($responseContent->detail);
        }
        $result = new ImageResponse();
        $result->setRequestId($responseContent->requestId);
        $result->setRiskType(RiskEnum::SMv2ToType((string) $responseContentDetail->riskType));
        $result->setScore((int) $responseContent->score / 10);
        $result->setContent($image);
        $result->setStatus(StatusEnum::SMv2ToStatus($responseContent->riskLevel));
        $result->setDescription($responseContentDetail->description);
        return $result;
    }

    /**
     * 请求
     * @param string $url
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     * @throws HttpException
     */
    protected function request($url, $data)
    {
        try{
            $params = $this->requestParams($data);
            $response = $this->getHttpClient()->post($url, [
                'json' => array_filter($params),
            ]);
        }catch (Exception $e){
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
        return $this->getResponseContent($response);
    }

    /**
     * 获取响应内容
     * @param $response
     * @return mixed
     * @throws HttpException
     */
    protected function getResponseContent($response)
    {
        if (200 != $response->getStatusCode()) {
            throw new HttpException('请求失败');
        }

        $responseContent = json_decode($response->getBody()->getContents());


        if (self::REQUEST_SUCCESS_CODE != $responseContent->code) {
            throw new HttpException($responseContent->message);
        }
        return $responseContent;
    }

    /**
     * 通用请求参数
     * @param array $data
     * @return array
     */
    protected function requestParams(array $data)
    {
        $type = $data["type"];
        $params = [
            'accessKey' => $this->key,
            'appId' => $this->appId,
            "type" => $type,
            "data" => $data,
        ];
        $params["data"]["tokenId"] = $this->userId;
        unset($params["data"]["type"]);
        return $params;
    }
}
