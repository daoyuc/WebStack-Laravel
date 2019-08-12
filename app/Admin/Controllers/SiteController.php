<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\BatchRestore;
use App\Category;
use Encore\Admin\Controllers\AdminController;
use App\Site;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SiteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '网站';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Site);

        $grid->quickSearch('title', 'url');

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->select('category_id', '分类')
            ->options(Category::selectOptions())
            ->rules('required');
            $create->text('title', '标题')
            ->attribute('autocomplete', 'off')
            ->rules('required|max:50');
            $create->text('url', '地址')
            ->attribute('autocomplete', 'off')
            ->rules('required|max:250');
        });

        $grid->model()->orderBy('id', 'desc');
        $grid->id('ID');
        $grid->category()->title('分类');
        $grid->title('标题')->copyable();
        $grid->thumb('图标')->gallery(['width' => 25, 'height' => 25])->hide();
        $grid->describe('描述')->limit(40);
        $grid->url('地址')->link();//->copyable()
        ;

        $isTrash = request('_scope_') === 'trashed';

        if ($isTrash) {
            $grid->tools(function ($tools) {
                $tools->batch(function (Grid\Tools\BatchActions $batch) {
                    $batch->disableDelete();
                    $batch->add('还原', new BatchRestore());
                });
            });
        }


        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1/2, function ($filter) {
                $filter->equal('category_id', '分类')->select(Category::query()->pluck('title', 'id'));
            });
            $filter->column(1/2, function ($filter) {
                $filter->like('title', '标题');
            });

            $filter->scope('trashed', '回收站')->onlyTrashed();
            $filter->scope('ssl', 'HTTPS')->where('url', 'like', 'https%');
            $filter->scope('nossl', 'HTTP')->where('url', 'not like', 'https%');
        });

        $grid->disableExport();
        $grid->enableHotKeys();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Site::findOrFail($id));

        $show->id('ID');
        $show->category_id('分类');
        $show->title('标题');
        $show->thumb('图标');
        $show->describe('Describe');
        $show->url('Url');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Site);

        $form->select('category_id', '分类')
            ->options(Category::selectOptions())
            ->rules('required');
        $form->text('title', '标题')
            ->attribute('autocomplete', 'off')
            ->rules('required|max:50');
        $form->image('thumb', '图标')
            ->crop(120, 120)
            ->uniqueName();
        //->rules('required');
        $form->text('describe', '描述')
            ->attribute('autocomplete', 'off')
            ->rules('max:300');
        $form->url('url', '地址')
            ->attribute('autocomplete', 'off')
            ->help('请输入 http:// 或 https:// 开头的网址')
            ->rules('required|max:250');

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }

    protected function restore()
    {
        //todo:定义其它需要恢复的关联模型数据
        return Site::onlyTrashed()->find(request('ids'))->each->restore();
    }
}
