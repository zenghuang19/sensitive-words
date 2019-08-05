# Sensitive-words

Sensitive Fliter for Laravel5 based on [sensitive-words](https://github.com/zenghuang19/sensitive-words).


## Install

```shell
composer require zenghuang19/sensitive-words
```


## Usage

Using facade:

```php
require_once "../src/SensitiveWord.php";
$filename  = './words.txt';
$sensitive = new \Codetrainee\SensitiveWords\SensitiveWord();
$sensitive->addWords($filename);
$txt   = "鸡鸡";
$words = $sensitive->filter($txt);//敏感词替换
$word  = $sensitive->detection($txt);//敏感词检测
var_dump($words, $word);
```

## 百度开放平台内容审核
例子
```php
$APP_ID = '百度AppID';
$API_KEY = 'API Key';
$SECRET_KEY = 'Secret Key';
$client = new AipImageCensor($APP_ID, $API_KEY, $SECRET_KEY);
$result = $client->textCensorUserDefined("测试文本");
dd($result);
if ($result['conclusionType'] != 1){
    //不合格的返回代码
}
```
个人账号
百度的文本审核是免费的，只限制QPS
图片审核每天限制2000张。企业账号未了解。更多使用方式及返回参数请查看 [百度官方文档](https://ai.baidu.com/docs#/ImageCensoring-PHP-SDK/418b8ff4)

##### laravel-admin 文本检查开发中
## License

MIT
