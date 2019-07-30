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

## License

MIT
