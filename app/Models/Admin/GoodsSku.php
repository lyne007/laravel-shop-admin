<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodsSku extends Model
{
    use HasFactory;
    protected $table = 'goods_skus';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];

    protected function insertBatch(array $data,int $goods_id)
    {
        return DB::transaction(function () use($data,$goods_id) {
            DB::delete("delete from goods_skus where goods_id=$goods_id");
            DB::table('goods_skus')->insert($data);
        }, 5);
    }

}
