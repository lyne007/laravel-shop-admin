<?php

namespace App\Admin\Controllers;

use App\Models\Admin\AttributeKey;
use App\Models\Admin\AttributeValue;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class AttributeValueController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AttributeValue';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AttributeValue());
        $grid->column('id', __('Id'));
        $grid->column('attributekey')->display(function($attrKey){
            return $attrKey['attribute_name'];
        });
        $grid->column('attribute_value', __('Attribute value'));
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
        $show = new Show(AttributeValue::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('attribute_id', __('Attribute id'));
        $show->field('attribute_value', __('Attribute value'));
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
        $form = new Form(new AttributeValue());

        $form->select('attribute_id', __('Attribute id'))->options('/admin/api/attr');
        $form->text('attribute_value', __('Attribute value'));

        return $form;
    }
}
