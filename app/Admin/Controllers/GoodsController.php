<?php

namespace App\Admin\Controllers;

use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\Goods;
use App\Models\Admin\GoodsSku;
use App\Models\Admin\Vendor;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Goods';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Goods());

        $grid->column('goods_code', __('Goods code'));
        $grid->column('goods_name', __('Goods name'));
        $grid->column('cate_id_one', __('分类'))->display(function(){
            $cate1 = Category::where('id',$this->cate_id_one)->first();
            $cate2 = Category::where('id',$this->cate_id_two)->first();
            return $cate1->cate_name .'/'.$cate2->cate_name;
        });

        $grid->column('vendor_id', __('Vendor id'))->display(function(){
            $vendor = Vendor::where('id',$this->vendor_id)->first('vendor_name');
            return $vendor->vendor_name;
        });
        $grid->column('brand_id', __('Brand id'))->display(function(){
            $brand = Brand::where('id',$this->brand_id)->first('brand_name');
            return $brand?$brand->brand_name:null;
        });
        $grid->column('goods_sales', __('Goods sales'));
        $grid->column('goods_main', __('Goods main'))->display(function(){
            return '<img src="'.$this->goods_main.'"/>';
        });
        $grid->column('is_hot', __('Is hot'))->using([0=>'否',1=>'是'])->label([1=>'success',0=>'warning']);
        $grid->column('status', __('Status'))->using([0=>'禁用',1=>'正常'])->label([1=>'success',0=>'warning']);
        $grid->column('sort_weight', __('Sort weight'));
        $grid->column('updated_at', __('Updated at'));
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('goods_code',__('Goods code'));
            $filter->equal('goods_name',__('Goods name'));
            $filter->equal('vendor_id',__('Vendor id'))->select(function (){
                return Vendor::pluck('vendor_name as text','id');
            });
            $filter->equal('brand_id',__('Brand id'))->select(function (){
                return Brand::pluck('brand_name as text','id');
            });

        });
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
        $show = new Show(Goods::findOrFail($id));

        $show->field('goods_code', __('Goods code'));
        $show->field('goods_name', __('Goods name'));
        $show->field('cate_id_one', __('Cate id one'))->as(function($cate_id_one){
            $cate = Category::where('id',$this->cate_id_one)->first();
            return $cate->cate_name;
        });
        $show->field('cate_id_two', __('Cate id two'))->as(function($cate_id_two){
            $cate = Category::where('id',$this->cate_id_two)->first();
            return $cate->cate_name;
        });
        $show->field('vendor_id', __('Vendor id'))->as(function(){
            $vendor = Vendor::where('id',$this->vendor_id)->first('vendor_name');
            return $vendor->vendor_name;
        });
        $show->field('brand_id', __('Brand id'))->as(function(){
            $brand = Brand::where('id',$this->brand_id)->first('brand_name');
            return $brand?$brand->brand_name:null;
        });
        $show->field('sku','商品SKU')->as(function(){
            $sku_json = Goods::getSkus($this->id);
            $sku_data = json_decode($sku_json,true);
            $table = '<div class="box"><div class="box-body"><table class="table table-bordered"><tbody><tr><th>属性/值</th><th>图片</th><th>价格</th><th>库存</th></tr>';

            foreach ($sku_data['sku'] as $sku) {
                $table .= '<tr>';
                $temp = $sku;
                unset($temp['price'],$temp['stock'],$temp['pic'],$temp['id']);
                $td = '<td>';
                foreach ($temp as $item=>$value) {
//                    $td .= '<span style="font-size: 5px">'.$item.'</span>:<label class="label label-default" style="font-size: 13px">'.$value.'</label>';
                    $td .= '<label class="label label-default" style="font-size: 13px">'.$value.'</label> &nbsp;&nbsp;';
                }
                $td .= '</td>';
                $table .= $td;
                $table .= '<td><img width="25" height="25" src="'.$sku['pic'].'"></td>';
                $table .= '<td>'.($sku['price'] / 100).'（元）</td>';
                $table .= '<td>'.$sku['stock'].'</td>';
                $table .= '</tr>';
            }
            $table .= '</tbody></table></div></div>';
            return $table;
        })->setEscape(false);

        $show->field('goods_main', __('Goods main'))->image('','100','100');
        $show->field('goods_images', __('Goods images'))->carousel(500,200);
        $show->field('goods_details', __('Goods details'))->setEscape(false);
        $show->field('goods_sales', __('Goods sales'));
        $show->field('is_hot',__('Is hot'))->using([0=>'否',1=>'是']);
        $show->field('status',__('Status'))->using([0=>'禁用',1=>'正常']);

        $show->field('sort_weight', __('Sort weight'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        $form = new Form(new Goods());
        $form->text('goods_code', __('Goods code'))->required()->rules('required|numeric|min:100')->default(function () {
            $snowflake = new Snowflake();
            return substr($snowflake->id(),5,13);
        });
//        $form->text('goods_code', __('Goods code'))->required()->rules('required|numeric|min:100');
        $form->text('goods_name', __('Goods name'))->required();
        $form->select('cate_id_one', __('Cate id one'))->options('/admin/api/cate/0')->load('cate_id_two','/admin/api/cate/0')->required();
        $form->select('cate_id_two', __('Cate id two'))->required();
        $form->select('vendor_id', __('Vendor id'))->options(function(){
            return Vendor::pluck('vendor_name as text','id');
        })->required();
        $form->select('brand_id', __('Brand id'))->options(function(){
            return Brand::pluck('brand_name as text','id');
        })->required();
        $form->sku('sku','商品SKU')->default(function($form){
            if ($form->isEditing()) {
                return Goods::getSkus($form->model()->id);
            }
        });
        $form->image('goods_main', __('Goods main'))->uniqueName();
        $form->multipleImage('goods_images', __('Goods images'))->uniqueName();
        $form->editor('goods_details',__('Goods Details'));
        $form->radio('status', __('Status'))->options([0 => '禁用', 1=> '正常'])->default(1);
        $form->currency('goods_price', __('Goods price'))->symbol('$');
        $form->number('goods_stock', __('Goods stock'));
        $form->slider('sort_weight', __('Sort weight'))->options([
            'max'       => 300,
            'min'       => 1,
            'step'      => 1,
            'postfix'   => '排序'
        ]);


        $form->saved(function($form){

            $skuData = json_decode($form->sku);
            if ($skuData->type =='many') {
                $goodsSkus = $skuData->sku;
                $insertGoodsSkus = [];
                foreach ($goodsSkus as $k=>$sku) {
                    $insertGoodsSkus[$k]['goods_id'] = $form->model()->id;
                    $insertGoodsSkus[$k]['goods_price'] = $sku->price * 100;
                    $insertGoodsSkus[$k]['goods_stock'] = $sku->stock;
                    $insertGoodsSkus[$k]['spec_pic'] = $sku->pic;
                    unset($sku->pic,$sku->price,$sku->stock,$sku->id);
                    $insertGoodsSkus[$k]['goods_specs'] = json_encode($sku,JSON_UNESCAPED_UNICODE);
                    $insertGoodsSkus[$k]['specs_key'] = $k;
                }

                GoodsSku::insertBatch($insertGoodsSkus,$form->model()->id);

            }
        });
        return $form;
    }

    /**
     * $updateGoodsSkus = [];
    $insertGoodsSkus = [];
    foreach ($goodsSkus as $k=>$sku) {
    if ($form->isEditing() && $sku->id) {
    $updateGoodsSkus[$k]['id'] = $sku->id;
    $updateGoodsSkus[$k]['goods_id'] = $form->model()->id;
    $updateGoodsSkus[$k]['goods_price'] = $sku->price;
    $updateGoodsSkus[$k]['goods_stock'] = $sku->stock;
    $updateGoodsSkus[$k]['spec_pic'] = $sku->pic;
    unset($sku->pic,$sku->price,$sku->stock);
    $updateGoodsSkus[$k]['goods_specs'] = json_encode($sku,JSON_UNESCAPED_UNICODE);
    $updateGoodsSkus[$k]['specs_key'] = $k;
    } else {
    $insertGoodsSkus[$k]['goods_id'] = $form->model()->id;
    $insertGoodsSkus[$k]['goods_price'] = $sku->price;
    $insertGoodsSkus[$k]['goods_stock'] = $sku->stock;
    $insertGoodsSkus[$k]['spec_pic'] = $sku->pic;
    unset($sku->pic,$sku->price,$sku->stock);
    $insertGoodsSkus[$k]['goods_specs'] = json_encode($sku,JSON_UNESCAPED_UNICODE);
    $insertGoodsSkus[$k]['specs_key'] = $k;
    }

    }
    //                var_dump($insertGoodsSkus);
    //                dd($updateGoodsSkus);
    if (!empty($updateGoodsSkus)) {
    $model = new GoodsSku;
    $res = batch()->update($model,$updateGoodsSkus,'id');
    } else {
    $res = GoodsSku::insertBatch($insertGoodsSkus);
    }
    if (!$res) {
    throw new \Exception('产生错误！！');
    }
     */


    /**
     * @param Request $request
     * @return array
     */
    public function uploadSku(Request $request)
    {
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/images');

            // 返回格式
            return ['url'=> Storage::url($path)];
        }
    }

    /**
     * 详情图
     * @param Request $request
     * @return array
     */
    public function uploadDetails(Request $request)
    {
        $urls = [];

        foreach ($request->file() as $file) {
            $urls[] = Storage::url($file->store('public/images'));
        }

        return [
            "errno" => 0,
            "data"  => $urls,
        ];
    }
}
