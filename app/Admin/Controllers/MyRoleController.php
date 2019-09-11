<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MyRoleController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    protected function title()
    {
        return trans('admin.roles');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $roleModel = config('admin.database.roles_model');

        $grid = new Grid(new $roleModel());

        $grid->column('id', 'ID')->sortable();
        $grid->column('slug', trans('admin.slug'));
        $grid->column('name', trans('admin.name'));

        $grid->column('permissions', trans('admin.permission'))->pluck('name')->label();
        $grid->column('menus', trans('admin.menu'))->pluck('title')->label();

        $grid->column('created_at', trans('admin.created_at'));
        $grid->column('updated_at', trans('admin.updated_at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if ($actions->row->slug == 'administrator') {
                $actions->disableDelete();
            }
        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $roleModel = config('admin.database.roles_model');

        $show = new Show($roleModel::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('slug', trans('admin.slug'));
        $show->field('name', trans('admin.name'));
        $show->field('permissions', trans('admin.permissions'))->as(function ($permission) {
            return $permission->pluck('name');
        })->label();
        $show->field('menus', trans('admin.menu'))->as(function ($menu) {
            return $menu->pluck('title');
        })->label();
        $show->field('created_at', trans('admin.created_at'));
        $show->field('updated_at', trans('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {

        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');
        //$menuModel = config('admin.database.menu_model');

        $menuClass = \App\Models\Menu::class;

        $menuModel = new $menuClass();

        $menu = $menuModel->toTree();
        //dd($menu);

        $form = new Form(new $roleModel());
        $form->display('id', 'ID');

        $form->text('slug', trans('admin.slug'))->rules('required');
        $form->text('name', trans('admin.name'))->rules('required');
        //$form->listbox('permissions', trans('admin.permissions'))->options($permissionModel::all()->pluck('name', 'id'));
        $form->listbox('permissions', trans('admin.permissions'))
                ->options($permissionModel::all()->pluck('name', 'id'))
                ->help('只显示当前角色所拥有的权限')
                ->settings(['selectorMinimalHeight' => 180, 'moveAllLabel' => '添加全部', 'removeAllLabel' => '移除全部']);

        //$form->listbox('menus', trans('admin.menu'))->options($menuModel::all()->pluck('title', 'id'));
                // 如果不是编辑状态，则添加字段唯一验证

        //获取已有的菜单id
        /*if (request()->route()->hasParameter('role')) {
            $menu_ids = DB::table(config('admin.database.role_menu_table'))->where('role_id', request()->route()->parameter('role'))->pluck('menu_id');
        } else {
            $menu_ids = [];
        }*/
        //,'menu_ids'=>$menu_ids
        $form->treecheck('menus', trans('admin.menu'))->options(['nodes'=>json_encode($menu)]);//拥有这个角色的 用户 会自动展示该菜单，如不选所有用户可见
        
        //$form->ignore(['menus']);
        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        //保存后回调
        $form->saved(function (Form $form) {
            /*$menu_ids = explode(',', request('menus'));
            DB::table(config('admin.database.role_menu_table'))->where('role_id', $form->model()->id)->delete();
            if (!empty($menu_ids)) {
                $insData = [];
                foreach ($menu_ids as $key => $value) {
                    $insData[] = ['role_id' => $form->model()->id , 'menu_id'=>$value];
                }
                //dd($insData);
                DB::table(config('admin.database.role_menu_table'))->insert($insData);
            }*/
        });

        return $form;
    }
}
