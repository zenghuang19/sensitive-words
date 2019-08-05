<?php

namespace Codetrainee\SensitiveWords\Form\Field;

use Encore\Admin\Form\Field;

class TextareaSafe extends Field
{
    /**
     * Default rows of textarea.
     *
     * @var int
     */
    protected $rows = 5;

    /**
     * Set rows of textarea.
     *
     * @param int $rows
     *
     * @return $this
     */
    public function rows($rows = 5)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Get view of this field.
     *
     * @return string
     */
    public function getView()
    {
        return 'admin::form.textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if (is_array($this->value)) {
            $this->value = json_encode($this->value, JSON_PRETTY_PRINT);
        }

        $this->script = <<<EOT
$('.{$this->getElementClassString()}').blur(function(){
    var content = $(this).val();

    $.ajax({
        method: 'post',
        url: '/admin/safe/check',
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
        return parent::render()->with(['rows' => $this->rows]);
    }
}
