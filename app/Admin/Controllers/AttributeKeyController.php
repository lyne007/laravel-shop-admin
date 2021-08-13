<?php

namespace App\Admin\Controllers;

use App\Models\Admin\AttributeKey;
use App\Models\Admin\AttributeValue;
use App\Models\Admin\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Tree;

class AttributeKeyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AttributeKey';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AttributeKey());

        $grid->column('id', __('Id'));
        $grid->column('category_id', __('Category id'))->display(function($category_id){
            return Category::where('id',$category_id)->first('cate_name')->toArray()['cate_name'];
        });
        $grid->column('attribute_name', __('Attribute name'));
        $grid->column('attributeValues')->display(function($attributeValues){
            return implode(',',array_column($attributeValues,'attribute_value'));
        });

        /*$grid->column('attribute_value')->display(function () {
            $attr_values = AttributeValue::where('attribute_key_id',$this->id)->pluck('attribute_value');
            return implode(',',$attr_values->toArray());
        });*/
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
        $show = new Show(AttributeKey::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_id', __('Category id'))->as(function($category_id){
            return Category::where('id',$category_id)->first('cate_name')->toArray()['cate_name'];
        });
        $show->field('attribute_name', __('Attribute name'));
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
        $form = new Form(new AttributeKey());

        $form->column(1/2, function ($form) {
            $form->select('category_id', __('Category id'))->options('/admin/api/cate/0');
            $form->text('attribute_name', __('Attribute name'));

        });


        return $form;
    }
}
