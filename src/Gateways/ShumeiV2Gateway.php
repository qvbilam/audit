<?php
declare(strict_types=1);

namespace Qvbilam\Audit\Gateways;

use Qvbilam\Audit\Contracts\ContentInterface;
use Qvbilam\Audit\Enum\RiskEnum;
use Qvbilam\Audit\Enum\StatusEnum;
use Qvbilam\Audit\Exceptions\HttpException;
use Qvbilam\Audit\HttpClient;
use Qvbilam\Audit\Response\Response;
use stdClass;

class ShumeiV2Gateway extends Gateway
{
    use HttpClient;

    const TEXT_URL = "http://api-text-bj.fengkongcloud.com/v2/saas/anti_fraud/text";
    const IMAGE_URL = "http://api-img-bj.fengkongcloud.com/v2/saas/anti_fraud/img";
    const FIELD_APP_KEY = "app_key";
    const FIELD_APP_ID = "app_id";
    const DEFAULT_USER_ID = "0";
    const TEXT_TYPE = "text.type";
    const IMAGE_TYPE = "image.type";
    const IMAGE_CHANNEL = "image.channel";

    const REQUEST_SUCCESS_CODE = '1100';


    /**
     * > This function takes a ContentInterface object, gets the text from it, gets the text type from the config, creates
     * a params array, sends a POST request to the TEXT_URL with the params, gets the response, and returns the response
     * after auditing it
     *
     * @param ContentInterface $content The content to be audited.
     *
     * @return Response A response object.
     * @throws HttpException
     */
    public function text(ContentInterface $content): Response
    {
        $text = $content->getContent();
        $type = $this->config->get(self::TEXT_TYPE);
        $params = $this->params(['text' => $text, 'type' => $type]);
        $response = $this->getRequestResult($this->postJson(self::TEXT_URL, $params));
        return $this->auditResponse($response, $text);
    }


    /**
     * > This function takes a ContentInterface object, and returns a Response object
     *
     * @param ContentInterface $content The content to be audited.
     *
     * @return Response A response object.
     * @throws HttpException
     */
    public function image(ContentInterface $content): Response
    {
        $image = $content->getContent();
        $type = $this->config->get(self::IMAGE_TYPE);
        $channel = $this->config->get(self::IMAGE_CHANNEL);
        $params = $this->params(["img" => $image, "channel" => $channel, "type" => $type]);
        $response = $this->getRequestResult($this->postJson(self::IMAGE_URL, $params));
        return $this->auditResponse($response, $image);
    }


    /**
     * It takes an array of data, adds the app key and app id to it, and returns the array
     *
     * @param array data The data to be sent to the server.
     *
     * @return array The params method is returning an array of data.
     */
    protected function params(array $data): array
    {
        $type = $data['type'];
        $params = [
            'accessKey' => $this->config->get(self::FIELD_APP_KEY),
            'appId' => $this->config->get(self::FIELD_APP_ID),
            'type' => $type,
            'data' => $data,
        ];
        $params['data']['tokenId'] = self::DEFAULT_USER_ID;
        unset($params['data']['type']);

        return $params;
    }


    /**
     * > If the response status code is not 200, throw an exception. If the response code is not 0, throw an exception.
     * Otherwise, return the response content
     *
     * @param response The response object returned by the GuzzleHttp client
     *
     * @return stdClass The response from the API.
     * @throws HttpException
     */
    protected function getRequestResult($response): stdClass
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

    protected function auditResponse($response, string $content): Response
    {
        $responseContentDetail = $response->detail;
        if (is_string($response->detail)) {
            $responseContentDetail = json_decode($response->detail);
        }

        $result = new Response();
        $result->setRequestId($response->requestId);
        $result->setRiskType(RiskEnum::SMv2ToType((string) $responseContentDetail->riskType));
        $result->setScore((int) $response->score / 10);
        $result->setContent($content);
        $result->setStatus(StatusEnum::SMv2ToStatus($response->riskLevel));
        $result->setDescription($responseContentDetail->description);

        return $result;
    }
}