<?php
//批量恢复软删除
namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class BatchRestore extends BatchAction
{
    public function script()
    {
        return <<<EOT

$('{$this->getElementClass()}').on('click', function() {

    $.ajax({
        method: 'post',
        url: '{$this->resource}/restore',
        data: {
            _token:'{$this->getToken()}',
            ids: selectedRows() //$.admin.grid.selected()
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});

EOT;

    }
}
