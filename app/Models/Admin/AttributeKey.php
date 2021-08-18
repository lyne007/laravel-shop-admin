<?php

namespace App\Models\Admin;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeKey extends Model
{
    use HasFactory;
    // 解决时间格式.000000Z
    use DefaultDatetimeFormat;

    /**
     * 一对多
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }


}
