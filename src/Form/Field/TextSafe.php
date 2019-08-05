<?php

namespace Codetrainee\SensitiveWords\Form\Field;

use Encore\Admin\Form\Field;
use Encore\Admin\Form\Field\PlainInput;

class TextSafe extends Field
{
    use PlainInput;

    /**
     * Render this filed.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $this->initPlainInput();

        $this->prepend('<i class="fa fa-pencil fa-fw"></i>')
            ->defaultAttribute('type', 'text')
            ->defaultAttribute('id', $this->id)
            ->defaultAttribute('name', $this->elementName ?: $this->formatName($this->column))
            ->defaultAttribute('value', old($this->column, $this->value()))
            ->defaultAttribute('class', 'form-control '.$this->getElementClassString())
            ->defaultAttribute('placeholder', $this->getPlaceholder())
            ->defaultAttribute('data-prefix', config('admin.route.prefix'));

        $this->addVariables([
            'prepend' => $this->prepend,
            'append'  => $this->append,
        ]);

        $this->script = <<<EOT
$('#{$this->getElementClassString()}').blur(function(){
    var content = $(this).val();
    var prefix = $(this).data('prefix');

    $.ajax({
        method: 'post',
        url: '/' + prefix + '/safe/check',
        data: {
            _token:LA.token,
            content: content
        },
        success: function (re) {
            if(re.code == 200){
                toastr.success(re.msg);
            }else{
                toastr.error(re.msg);
            }
        }
    });
});
EOT;
        return parent::render();
    }
}
