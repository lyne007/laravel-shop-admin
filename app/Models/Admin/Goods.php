<?php

namespace App\Models\Admin;

use Godruoyi\Snowflake\Snowflake;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    public function skus()
    {
        return $this->hasMany(GoodsSku::class,'goods_id');
    }

    protected $fillable = [
        'goods_images'
    ];

    public function getGoodsImagesAttribute($value)
    {
        return json_decode($value,true);
    }
    public function setGoodsImagesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['goods_images'] = json_encode($value);
        }
    }

    /**
     * 初始化sku数据
     * @param $goods_id
     * @return false|string
     */
    public static function getSkus($goods_id)
    {
        $goods = Goods::select('attribute_type','attribute_list')->where('id',$goods_id)->first();
        $skus = GoodsSku::select('id','goods_specs','specs_key','goods_stock','goods_price','spec_pic')->where('goods_id',$goods_id)->orderBy('specs_key')->get();
        $json_data['type'] = $goods['attribute_type'];
        $json_data['attrs'] = json_decode($goods['attribute_list'],true);
        $temp_skus = [];
        foreach ($skus as $k=>$v) {
            $temp_skus[$v['specs_key']] = json_decode($v['goods_specs'],true);
            $temp_skus[$v['specs_key']]['pic'] = $v['spec_pic'];
            $temp_skus[$v['specs_key']]['price'] = $v['goods_price'];
            $temp_skus[$v['specs_key']]['stock'] = $v['goods_stock'];
            $temp_skus[$v['specs_key']]['id'] = $v['id'];
        }
        $json_data['sku'] = $temp_skus;
        return json_encode($json_data,JSON_UNESCAPED_UNICODE);
    }


    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $goods = $model->attributes;
//            if (isset($goods['goods_images'])) {
//                $goods['goods_images'] = json_encode($goods['goods_images']);
//            }
            $goods['goods_price'] = $goods['goods_price'] * 100;
            $skuData = json_decode($goods['sku']);
            if ($skuData->type =='many') {
                // 多规格
                $goods['attribute_list'] = json_encode($skuData->attrs);
            } else {
                // 单规格price，stock必填
            }
            unset($goods['sku']);
            $model->attributes = $goods;
        });
    }
}
