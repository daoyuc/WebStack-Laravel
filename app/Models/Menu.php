<?php
namespace App\Models;

use Encore\Admin\Auth\Database\Menu as DefaultMenu;

class Menu extends DefaultMenu
{
    protected $appends = ['nodeid','text'];
    /**
     * 获取菜单的名字。
     *
     * @param  string  $value
     * @return string
     */
    public function getNodeIdAttribute()
    {
        return $this->id;
    }

    /**
     * 获取菜单的名字。
     *
     * @param  string  $value
     * @return string
     */
    public function getTextAttribute()
    {
        if (!$this->roles->isEmpty()) {
            return $this->title.'【'.$this->roles->pluck('name')->implode(',').'】';
            //return $this->title.'【'.implode(',', $roles->toArray()).'】';
        }
        return $this->title;
    }

    /**
     * Format data to tree like array.
     *
     * @return array
     */
    public function toTree()
    {
        return $this->buildNestedArray();
    }

    /**
     * Build Nested array.
     * change default children to nodes
     *
     * @param array $nodes
     * @param int   $parentId
     *
     * @return array
     */
    protected function buildNestedArray(array $nodes = [], $parentId = 0)
    {
        $branch = [];

        if (empty($nodes)) {
            $nodes = $this->allNodes();
        }

        foreach ($nodes as $node) {
            if ($node[$this->parentColumn] == $parentId) {
                $children = $this->buildNestedArray($nodes, $node[$this->getKeyName()]);

                if ($children) {
                    $node['nodes'] = $children;
                }

                $branch[] = $node;
            }
        }

        return $branch;
    }
}
