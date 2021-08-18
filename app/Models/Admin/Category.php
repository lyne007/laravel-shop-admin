<?php

namespace App\Models\Admin;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelTree;
    // 解决时间格式.000000Z
    use DefaultDatetimeFormat;

    protected $table = 'category';

    public function __construct(array $attributes=[])
    {
        parent::__construct($attributes);
        $this->setParentColumn('cate_parent_id');
        $this->setOrderColumn('sort_weight');
        $this->setTitleColumn('cate_name');
    }

}
