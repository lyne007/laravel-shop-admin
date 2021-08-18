<?php

namespace App\Models\Admin;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    // 解决时间格式.000000Z
    use DefaultDatetimeFormat;
}
