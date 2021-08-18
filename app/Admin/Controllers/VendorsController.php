<?php

namespace App\Admin\Controllers;

use App\Models\Admin\Vendor;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VendorsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Vendor';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Vendor());

        $grid->column('id', __('Id'));
        $grid->column('vendor_name', __('Vendor name'));
        $grid->column('contactor', __('Contactor'));
        $grid->column('phone', __('Phone'));
        $grid->column('status', __('Status'))->using([0=>'禁用',1=>'正常'])->label([1=>'success',0=>'warning']);
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
        $show = new Show(Vendor::findOrFail($id));

//        $show->field('id', __('Id'));
        $show->field('vendor_name', __('Vendor name'));
        $show->field('contactor', __('Contactor'));
        $show->field('phone', __('Phone'));
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
        $form = new Form(new Vendor());

        $form->text('vendor_name', __('Vendor name'))->required();
        $form->text('contactor', __('Contactor'))->required();
        $form->mobile('phone', __('Phone'))->required();
        $form->switch('status', __('Status'))->default(1);

        return $form;
    }
}
