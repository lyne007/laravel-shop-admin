<?php

namespace App\Admin\Controllers;

use App\Models\Admin\Brand;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BrandsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Brand';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Brand());

        $grid->column('brand_name', __('Brand name'));
        $grid->column('desc', __('Desc'));
        $grid->column('logo', __('Logo'))->image('',50,50);
        $grid->column('status', __('Status'))->using([0=>'禁用',1=>'正常']);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->filter(function($filter){
            $filter->equal('brand_name', __('Brand name'));
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
        $show = new Show(Brand::findOrFail($id));

        $show->field('brand_name', __('Brand name'));
        $show->field('desc', __('Desc'));
        $show->field('logo', __('Logo'))->image('',100,100);
        $show->field('status', __('Status'))->using([0=>'禁用',1=>'正常']);
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
        $form = new Form(new Brand());

        $form->text('brand_name', __('Brand name'))->required();
        $form->text('desc', __('Desc'));
        $form->image('logo', __('Logo'));
        $form->switch('status', __('Status'))->default(1);

        return $form;
    }
}
