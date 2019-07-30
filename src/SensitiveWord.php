<?php

namespace Codetrainee\SensitiveWords;


class SensitiveWord
{
    private $replaceCode = '*';

    /**
     * 敏感词库集合
     *
     * @var array
     */
    public $trieTreeMap = [];

    /**
     * 干扰因子集合
     *
     * @var array
     */
    private $disturbList = [
        '&',
        '*',
        '#',
        '？',
        '！',
        '￥',
        '（',
        '）',
        '：',
        '‘',
        '’',
        '“',
        '”',
        '《',
        '》',
        '，',
        '…',
        '。',
        '、',
        'nbsp',
        '】',
        '【',
        '～'
    ];

    public function interference($disturbList = [])
    {
        $this->disturbList = $disturbList;
    }

    /**
     * 替换字符
     * @param string $code
     */
    public function replace($code = '*')
    {
        $this->replaceCode = $code;
    }


    /**
     * 添加敏感词
     * @param $filename
     *
     * @throws \Exception
     */
    public function addWords($filename)
    {
        foreach ($this->getGeneretor($filename) as $words) {
            $nowWords = &$this->trieTreeMap;
            $len      = mb_strlen($words);
            for ($i = 0; $i < $len; $i++) {
                $word = mb_substr($words, $i, 1);
                if (!isset($nowWords[$word])) {
                    $nowWords[$word] = false;
                }
                $nowWords = &$nowWords[$word];
            }
        }
    }

    /**
     * 使用yield生成器
     *
     * @param $filename
     *
     * @return \Generator
     * @throws \Exception
     */
    protected function getGeneretor($filename)
    {
        $handle = fopen($filename, 'r');
        if (!$handle) {
            throw new \Exception('read file failed');
        }
        while (!feof($handle)) {
            yield str_replace([
                '\'',
                ' ',
                PHP_EOL,
                ','
            ], '', fgets($handle));
        }
        fclose($handle);
    }

    /**
     * 查找对应敏感词
     * @param       $txt
     * @param bool  $hasReplace
     * @param array $replaceCodeList
     *
     * @return array|bool
     */
    public function search($txt, $hasReplace = false, &$replaceCodeList = [])
    {
        $wordsList = [];
        $txtLength = mb_strlen($txt);
        for ($i = 0; $i < $txtLength; $i++) {
            $wordLength = $this->checkWord($txt, $i, $txtLength);
            if (!$hasReplace && $wordLength > 0) {
                return true;
            }
            if ($wordLength > 0 && $hasReplace) {
                $words       = mb_substr($txt, $i, $wordLength);
                $wordsList[] = $words;
                $hasReplace && $replaceCodeList[] = str_repeat($this->replaceCode, mb_strlen($words));
                $i += $wordLength - 1;
            }
        }

        if (!$hasReplace) {
            return false;
        }

        return $wordsList;
    }

    /**
     * 过滤敏感词
     *
     * @param $txt
     *
     * @return mixed
     */
    public function filter($txt)
    {
        $replaceCodeList = [];
        $wordsList       = $this->search($txt, true, $replaceCodeList);
        if (empty($wordsList)) {
            return $txt;
        }

        return str_replace($wordsList, $replaceCodeList, $txt);
    }

    /**
     * 检测是否有敏感词
     *
     * @param $txt
     *
     * @return mixed
     */
    public function detection($txt)
    {
        $words = $this->search($txt, false);

        return $words;
    }

    /**
     *  敏感词检测
     * @param $txt
     * @param $beginIndex
     * @param $length
     *
     * @return int
     */
    private function checkWord($txt, $beginIndex, $length)
    {
        $flag       = false;
        $wordLength = 0;
        $trieTree   = &$this->trieTreeMap;
        for ($i = $beginIndex; $i < $length; $i++) {
            $word = mb_substr($txt, $i, 1);
            if ($this->checkDisturb($word)) {
                $wordLength++;
                continue;
            }
            if (!isset($trieTree[$word])) {
                break;
            }
            $wordLength++;
            if ($trieTree[$word] !== false) {
                $trieTree = &$trieTree[$word];
            } else {
                $flag = true;
            }
        }
        $flag || $wordLength = 0;

        return $wordLength;
    }

    /**
     * 干扰因子检测
     *
     * @param $word
     *
     * @return bool
     */
    private function checkDisturb($word)
    {
        return in_array($word, $this->disturbList);
    }
}
