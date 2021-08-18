<?php

namespace App\Admin\Controllers;

use App\Models\Admin\Banner;
use App\Models\Admin\Merchant;
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


    protected function grid()
    {
        $grid = new Grid(new Banner());

        $grid->column('merchant_id', __('Merchant id'))->display(function(){
            $merchant = Merchant::where('id',$this->merchant_id)->first('m_name');
            return $merchant?$merchant->m_name:null;
        });
        $grid->column('b_image', __('B image'))->image('',50,50);
        $grid->column('b_href', __('B href'))->display(function(){
            return '<a href="'.$this->b_href.'" target="__brank">'.$this->b_href.'</a>';
        });
        $grid->column('b_sort_weight', __('B sort weight'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('merchant_id', __('Merchant id'))->select(function(){
                return Merchant::pluck('m_name as text','id');
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

        $form->select('merchant_id', __('Merchant id'))->options(function(){
            return Merchant::pluck('m_name as text','id');
        })->required();
        $form->image('b_image', __('B image'))->uniqueName()->required();
        $form->url('b_href', __('B href'))->setWidth(5);

        $form->slider('b_sort_weight', __('B sort weight'))->options([
            'max'       => 300,
            'min'       => 1,
            'step'      => 1,
            'postfix'   => '排序'
        ]);

        return $form;
    }
}
