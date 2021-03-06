<?php

namespace App\Models\Admin;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    // 解决时间格式.000000Z
    use DefaultDatetimeFormat;

    public function attributeKey(){
        return $this->hasOne(AttributeKey::class,'id','attribute_key_id');
    }
}
