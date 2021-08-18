<?php

namespace App\Admin\Controllers;

use App\Models\Admin\Banner;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BannersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Banner';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner());

        $grid->column('id', __('Id'));
        $grid->column('merchant_id', __('Merchant id'));
        $grid->column('b_image', __('B image'));
        $grid->column('b_sort_weight', __('B sort weight'));
        $grid->column('b_href', __('B href'));
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
        $show = new Show(Banner::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('merchant_id', __('Merchant id'));
        $show->field('b_image', __('B image'));
        $show->field('b_sort_weight', __('B sort weight'));
        $show->field('b_href', __('B href'));
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
        $form = new Form(new Banner());

        $form->number('merchant_id', __('Merchant id'));
        $form->image('b_image', __('B image'))->uniqueName();
        $form->number('b_sort_weight', __('B sort weight'));
        $form->text('b_href', __('B href'));

        return $form;
    }
}
