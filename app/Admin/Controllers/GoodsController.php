<?php

namespace App\Admin\Controllers;

use App\Models\Admin\Goods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('id', __('Id'));
        $grid->column('goods_code', __('Goods code'));
        $grid->column('goods_name', __('Goods name'));
        $grid->column('cate_id_one', __('Cate id one'));
        $grid->column('cate_id_two', __('Cate id two'));
        $grid->column('attribute_list', __('Attribute list'));
        $grid->column('vendor_id', __('Vendor id'));
        $grid->column('goods_sales', __('Goods sales'));
        $grid->column('goods_smallpic', __('Goods smallpic'));
        $grid->column('goods_bigpic', __('Goods bigpic'));
        $grid->column('goods_details', __('Goods details'));
        $grid->column('is_hot', __('Is hot'));
        $grid->column('status', __('Status'));
        $grid->column('sort_weight', __('Sort weight'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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

        $show->field('id', __('Id'));
        $show->field('goods_code', __('Goods code'));
        $show->field('goods_name', __('Goods name'));
        $show->field('cate_id_one', __('Cate id one'));
        $show->field('cate_id_two', __('Cate id two'));
        $show->field('attribute_list', __('Attribute list'));
        $show->field('vendor_id', __('Vendor id'));
        $show->field('goods_sales', __('Goods sales'));
        $show->field('goods_smallpic', __('Goods smallpic'));
        $show->field('goods_bigpic', __('Goods bigpic'));
        $show->field('goods_details', __('Goods details'));
        $show->field('is_hot', __('Is hot'));
        $show->field('status', __('Status'));
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

        $form->text('goods_code', __('Goods code'));
        $form->text('goods_name', __('Goods name'));
        $form->number('cate_id_one', __('Cate id one'));
        $form->number('cate_id_two', __('Cate id two'));
        $form->textarea('attribute_list', __('Attribute list'));
        $form->number('vendor_id', __('Vendor id'));
        $form->number('goods_sales', __('Goods sales'));
        $form->text('goods_smallpic', __('Goods smallpic'));
        $form->text('goods_bigpic', __('Goods bigpic'));
        $form->textarea('goods_details', __('Goods details'));
        $form->number('is_hot', __('Is hot'));
        $form->number('status', __('Status'))->default(1);
        $form->number('sort_weight', __('Sort weight'));

        return $form;
    }
}
