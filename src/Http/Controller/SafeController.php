<?php

namespace Codetrainee\SensitiveWords\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use James\AliGreen\AliGreen;

class SafeController extends Controller
{
    public function check(Request $request)
    {
        if(!$content = $request->input('content', '')){
            return ['code' => -200, 'msg' => '请输入检测内容'];
        }

        if (config('admin.extensions.safe.enable', 'true')) {
            $ali = AliGreen::getInstance();

            if(Str::startsWith($content, ['http', 'https'])){
                $result = Str::endsWith($content, ['jpg', 'png', 'jpeg', 'gif']) ? $ali->checkImg($content) : ['code' => 200, 'msg' => ['describe' => '正常']];
            } else{
                $result = $ali->checkText($content);
            }
        }else{

        }


        return ['code' => $result['code'], 'msg' => $result['msg']['describe']];
    }
}
