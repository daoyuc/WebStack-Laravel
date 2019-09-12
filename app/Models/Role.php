<?php
namespace App\Models;

use Encore\Admin\Auth\Database\Role as DefaultRole;
use Illuminate\Support\Facades\DB;

class Role extends DefaultRole
{
    protected $appends = ['menu_progress'];

    /**
     * 获取指定可见菜单数量
     *
     * @param  string  $value
     * @return string
     */
    public function getMenuNumAttribute()
    {
        return $this->menus()->count();
    }

    //获取所有菜单数量
    public function getTotalMenuNumAttribute()
    {
        return Menu::count();
    }

    //获取公共可见菜单数量
    public function getPublicMenuNumAttribute()
    {
        return Menu::whereNotIn('id', DB::table(config('admin.database.role_menu_table'))->pluck('menu_id')->unique())->count();
    }

    //获取当前权限可见菜单数量
    public function getMyPublicMenuNumAttribute()
    {
        if ($this->id == 1) {
            return $this->total_menu_num;
        }
        return $this->menu_num + $this->public_menu_num;
    }

    public function getMenuProgressAttribute()
    {
        return floor(($this->my_public_menu_num / $this->total_menu_num)*100);
    }
}
