<?php
require_once "../src/SensitiveWord.php";
$filename  = './words.txt';
$sensitive = new \Codetrainee\SensitiveWords\SensitiveWord();
$sensitive->addWords($filename);
$txt   = "鸡鸡";
$words = $sensitive->filter($txt);//敏感词替换
$word  = $sensitive->detection($txt);//敏感词检测
var_dump($words, $word);
