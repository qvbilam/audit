<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Qvbilam\Audit\Audit;

class AuditTest extends TestCase
{
    // 测试客户端
    public function testGetHttpClient(): void
    {
        $t = new Audit("mock-key");
        $this->assertInstanceOf(\GuzzleHttp\ClientInterface::class, $t->getHttpClient());
    }

    // 测试客户端参数
    public function testSetClientOptions(): void
    {
        $t = new Qvbilam\Audit\Audit("mock-key");
        $this->assertNull($t->getHttpClient()->getConfig("field"));

        $t->setClientOptions(["field" => 123]);
        $this->assertSame(123, $t->getHttpClient()->getConfig("field"));
    }

    // 测试异常文本审核
    public function testTextWithBadRequest(): void
    {
        $mockUrl = "http://api-text-bj.fengkongcloud.com/v2/saas/anti_fraud/text";
        $mockText = "马勒戈壁有一群草泥马";
        $mockTextType = "SOCIAL";
        $mockKey = "mock-key";
        $mockAppId = "mock-appId";
        $params = [
            "accessKey" => $mockKey,
            "appId" => $mockAppId,
            "type" => $mockTextType,
            "data" => [
                "text" => $mockText,
                "tokenId" => 0,
            ],
        ];


        $mockBody = '{"code":9100,"message":"余额不足","requestId":"f262b4131a5bce0b16d4fd4bb1caeb26"}';
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, [], $mockBody);


        $mockClient = Mockery::mock(\GuzzleHttp\Client::class);
        $mockClient->allows()->post($mockUrl, [
            "json" => array_filter($params),
        ])->andReturn($mockResponse);


        $t = Mockery::mock(Audit::class, [$mockKey, $mockAppId])->makePartial();
        $t->allows()->getHttpClient()->andReturn($mockClient);


        $this->expectException(\Qvbilam\Audit\Exceptions\HttpException::class);
        $this->expectExceptionMessage("余额不足");

        $t->text("马勒戈壁有一群草泥马");

        $this->fail("failed");
    }

    // 测试文本审核拒绝
    public function testTextWithReject(): void
    {
        $mockUrl = "http://api-text-bj.fengkongcloud.com/v2/saas/anti_fraud/text";
        $mockText = "马勒戈壁有一群草泥马";
        $mockTextType = "SOCIAL";
        $mockKey = "mock-key";
        $mockAppId = "mock-appId";
        $params = [
            "accessKey" => $mockKey,
            "appId" => $mockAppId,
            "type" => $mockTextType,
            "data" => [
                "text" => $mockText,
                "tokenId" => 0,
            ],
        ];

        // 模拟响应值
        $mockBody = '{"businessLabels":[],"code":1100,"detail":"{\"contactResult\":[],\"contextProcessed\":false,\"contextText\":\"\u9a6c\u52d2\u6208\u58c1\u6709\u4e00\u7fa4\u8349\u6ce5\u9a6c\",\"description\":\"\u8fb1\u9a82\uff1a\u4e0d\u6587\u660e\u7528\u8bed\uff1a\u8f7b\u5ea6\u4e0d\u6587\u660e\u7528\u8bed\",\"descriptionV2\":\"\u8fb1\u9a82\uff1a\u4e0d\u6587\u660e\u7528\u8bed\uff1a\u8f7b\u5ea6\u4e0d\u6587\u660e\u7528\u8bed\",\"model\":\"MA000006002002001\",\"riskType\":210}","message":"\u6210\u529f","requestId":"f262b4131a5bce0b16d4fd4bb1caeb26","riskLevel":"REJECT","score":711,"status":0}';
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, [], $mockBody);

        // 定义 $this->httpClient()->post() 返回值
        $mockClient = Mockery::mock(\GuzzleHttp\Client::class);
        $mockClient->allows()->post($mockUrl, [
            "json" => array_filter($params),
        ])->andReturn($mockResponse);


        // 将text() 内局部的http请求替换成 定义$mockClient
        $t = Mockery::mock(Audit::class, [$mockKey, $mockAppId])->makePartial();
        $t->allows()->getHttpClient()->andReturn($mockClient);


        $res = $t->text($mockText, $mockTextType);

        // 验证结果
        $this->assertIsObject($res);

        $this->assertSame(\Qvbilam\Audit\Enum\RiskEnum::ABUSE, $res->riskType);
        $this->assertSame(\Qvbilam\Audit\Enum\StatusEnum::AUDIT_STATUS_REJECT, (int)$res->status);

        $this->assertSame(false, $res->isPass()); // 是否通过
        $this->assertSame(false, $res->isReview()); // 是否重审
        $this->assertSame(true, $res->isReject()); // 是否相同
    }

    // 测试文本审核通过
    public function testTextWithPass(): void
    {
        $mockUrl = "http://api-text-bj.fengkongcloud.com/v2/saas/anti_fraud/text";
        $mockText = "你好";
        $mockTextType = "SOCIAL";
        $mockKey = "mock-key";
        $mockAppId = "mock-appId";
        $params = [
            "accessKey" => $mockKey,
            "appId" => $mockAppId,
            "type" => $mockTextType,
            "data" => [
                "text" => $mockText,
                "tokenId" => 0,
            ],
        ];

        // 模拟响应值
        $mockBody = '{"businessLabels":[],"code":1100,"detail":"{\"contactResult\":[],\"contextProcessed\":false,\"contextText\":\"\u4f60\u597d\",\"description\":\"\u6b63\u5e38\",\"model\":\"M1000\",\"riskType\":0}","message":"\u6210\u529f","requestId":"5e9dc908d58e3044563f772fa10c69ab","riskLevel":"PASS","score":232,"status":0}';
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, [], $mockBody);

        // 定义 $this->httpClient()->post() 返回值
        $mockClient = Mockery::mock(\GuzzleHttp\Client::class);
        $mockClient->allows()->post($mockUrl, [
            "json" => array_filter($params),
        ])->andReturn($mockResponse);


        // 将text() 内局部的http请求替换成 定义$mockClient
        $t = Mockery::mock(Audit::class, [$mockKey, $mockAppId])->makePartial();
        $t->allows()->getHttpClient()->andReturn($mockClient);


        $res = $t->text($mockText, $mockTextType);

        // 验证结果
        $this->assertIsObject($res);

        $this->assertSame(\Qvbilam\Audit\Enum\RiskEnum::NORMAL, $res->riskType);
        $this->assertSame(\Qvbilam\Audit\Enum\StatusEnum::AUDIT_STATUS_PASS, (int)$res->status);

        $this->assertSame(true, $res->isPass()); // 是否通过
        $this->assertSame(false, $res->isReview()); // 是否重审
        $this->assertSame(false, $res->isReject()); // 是否拒绝
    }
}