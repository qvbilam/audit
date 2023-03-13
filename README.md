

![Packagist Version (custom server)](https://img.shields.io/packagist/v/qvbilam/audit)
[![Tests](https://github.com/qvbilam/audit/actions/workflows/main.yaml/badge.svg)](https://github.com/qvbilam/audit/actions/workflows/main.yaml)
[![StyleCI](https://github.styleci.io/repos/613246431/shield)](https://packagist.org/packages/qvbilam/audit)
![GitHub repo size](https://img.shields.io/github/repo-size/qvbilam/audit)

### 说明
使用 [数美天净](https://help.ishumei.com/) 智能审核

### 安装
通过 composer 拉取包
```json
{
    "require": {
        "qvbilam/audit": "1.*"
    }
}
```
或者通过命令: `composer require qvbilam/audit`

### 使用
#### 验证文本
```php
use Qvbilam\Audit\Audit;
$audit = new Audit("key", "appId");
$response = $audit->text("文本内容");

return $response->toJson(); 
```
返回结果示例
```json
{
  "requestId":"43d9b42af973166ee6127b38aaa8ed88",
  "status":"-1",
  "description":"辱骂：不文明用语：轻度不文明用语",
  "text":"草泥马",
  "riskType":"abuse",
  "score":71
}
```



#### Laravel 中使用
`.env` 文件添加配置:
```shell
# 应用key
AUDIT_KEY=xxxx
# 应用appId
AUDIT_APP_ID=xxxx
```

配置 config/services.php :
```PHP
'audit' => [
    "key" => env("AUDIT_KEY"),
    "app_id" => env("AUDIT_APP_ID"),
],
```

通过自动注入方式使用:
```php
use Qvbilam\Audit\Audit;

public function auditText(Request $request, Audit $audit)
{
    $text = $request->query("txt");
    $audit = $audit->text($text);
    return $audit->toJson();
}
```

或者使用服务名称方式使用:
```php
use Qvbilam\Audit\Audit;

public function auditTextInjection(Request $request)
{
    $text = $request->query("txt");
    return app("audit")->text($text)->toJson();
}
```



### 结果
|       方法       |  类型  |         描述          |
| :--------------: | :----: | :-------------------: |
|     toJson()     | string |    返回json结果集     |
|    toArray()     | array  |    返回array结果集    |
|     isPass()     |  bool  |     是否通过审核      |
|    isReview()    |  bool  |   是否需要人工审核    |
|    isReject()    |  bool  |       是否拒绝        |
|  getRequestId()  | string |      获取请求id       |
|   getStatus()    |  int   |     获取审核状态      |
| getDescription() | string |     获取描述说明      |
|  getRiskType()   | string |     获取风险类型      |
|    getScore()    |  int   | 获取危险分数[0, 1000] |


