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

use Qvbilam\Audit\Contracts\ContentInterface;
use Qvbilam\Audit\HttpClient;
use Qvbilam\Audit\Response\Response;

class BaiduGateway extends Gateway
{
    use HttpClient;

    const URL_TOKEN = 'https://aip.baidubce.com/oauth/2.0/token';
    const URL_TEXT = 'https://aip.baidubce.com/rest/2.0/solution/v1/text_censor/v2/user_defined';
    const URL_IMAGE = 'https://aip.baidubce.com/rest/2.0/solution/v1/text_censor/v2/user_defined';
    /**
     * @var string
     */
    protected $token;

    public function text(ContentInterface $content): Response
    {
        $text = $content->getContent();
        $token = $this->getToken();
        $url = self::URL_TEXT."?access_token=$token";
        $response = $this->post($url, ['text' => $text]);
        $responseContent = json_decode($response->getBody()->getContents());
        print_r($responseContent);
        exit;

        return new Response();
    }

    public function image(ContentInterface $content): Response
    {
        // TODO: Implement image() method.
        return new Response();
    }

    protected function getToken()
    {
        if (empty($this->token)) {
            $clientId = $this->config->get('api_key');
            $clientSecret = $this->config->get('secret_key');
            $url = self::URL_TOKEN."?client_id=$clientId&client_secret=$clientSecret&grant_type=client_credentials";
            $response = $this->post($url);
            $responseContent = json_decode($response->getBody()->getContents());
            $this->token = $responseContent->access_token;
        }

        return $this->token;
    }
}
