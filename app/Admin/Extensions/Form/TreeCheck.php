<?php
namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field\MultipleSelect;

class TreeCheck extends MultipleSelect
{
    protected $view = 'admin.extensions.form.treecheck';
    protected $settings = [];

    protected static $css = [
        '/vendor/treeview/bootstrap-treeview.min.css',
    ];

    protected static $js = [
        '/vendor/treeview/bootstrap-treeview.js',
    ];

    public function settings(array $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    public function render()
    {
        $name = $this->formatName($this->column);

        $settings = array_merge([
            'checkNode'          => trans('field.check').trans('field.node'),
            'unCheckNode'        => trans('admin.cancel').trans('field.check').trans('field.node'),
            'toggleNode'         => trans('field.toggle').trans('field.node'),
            'checkAll'           => trans('field.check').trans('admin.all'),
            'unCheckAll'         => trans('admin.cancel').trans('field.check').trans('admin.all'),
            'inputPlaceholder'   => trans('admin.listbox.filter_placeholder'),
        ], $this->settings);
        //dd($settings);

        //dd($this->value());
        $checked = json_encode($this->value());
        $this->script = <<<EOT
var tree = {$this->options['nodes']};
var checked = {$checked};
var set = new Set(checked);
var idStr = 'treecheck-{$this->id}';
var outStr = '#treecheck-{$this->id}-out';
var checkableTree = $('#'+idStr).treeview({data: tree, showIcon: false,showCheckbox: true,'showTags':true});
//修改时选中已有菜单
var checkedNodeId = [];
if (checked){
  $('#' + idStr + ' li').each(function(){
    if (checked.includes(Number($(this).attr('id')))){
      checkedNodeId.push($(this).data('nodeid'));
    }
  })
}
checkedNodeId && checkableTree.treeview('checkNode', [checkedNodeId , { silent: true } ]);
$('#'+idStr).on('nodeChecked', function(event,node) {
    set.add(node.id);
    //$('#{$this->id}').val(Array.from(set).toString());
    var ops = '';
    for (const v of set) {
      ops +='<option value="'+v+'" selected >'+v+'</option>';
    }
    $('#{$this->id}').html(ops);
    $(outStr).append('<p>' + node.text + ' 选中了</p>');
});
$('#'+idStr).on('nodeUnchecked', function(event,node) {
    set.delete(node.id);
    //$('#{$this->id}').val(Array.from(set).toString());
    var ops = '';
    for (const v of set) {
      ops +='<option value="'+v+'" selected >'+v+'</option>';
    }
    $('#{$this->id}').html(ops);
    $(outStr).append('<p>' + node.text + ' 取消选中了</p>');
});
  var getSilent = function(){
   return $('#chk-check-silent').is(':checked') 
  };
	var findCheckableNodess = function() {
  return checkableTree.treeview('search', [ $('#input-check-node').val(), { ignoreCase: false, exactMatch: false } ]);
};
var checkableNodes = findCheckableNodess();

// Check/uncheck/toggle nodes
$('#input-check-node').on('keyup', function (e) {
  checkableNodes = findCheckableNodess();
  $('.check-node').prop('disabled', !(checkableNodes.length >= 1));
});

$('#btn-check-node.check-node').on('click', function (e) {
  checkableTree.treeview('checkNode', [ checkableNodes, { silent: getSilent() }]);
});

$('#btn-uncheck-node.check-node').on('click', function (e) {
  checkableTree.treeview('uncheckNode', [ checkableNodes, { silent: getSilent() }]);
});

$('#btn-toggle-checked.check-node').on('click', function (e) {
  checkableTree.treeview('toggleNodeChecked', [ checkableNodes, { silent: getSilent() }]);
});

// Check/uncheck all
$('#btn-check-all').on('click', function (e) {
  checkableTree.treeview('checkAll', { silent: getSilent() });
});

$('#btn-uncheck-all').on('click', function (e) {
  checkableTree.treeview('uncheckAll', { silent: getSilent() });
});
EOT;
        $this->attribute('value', implode(',', (array) $this->value()));
        return parent::render()->with('settings', $settings);
    }
}
