<?php

namespace App\Admin\Controllers;

use App\Models\Admin\Merchant;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Godruoyi\Snowflake\Snowflake;
class MerchantsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Merchant';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Merchant());

        $grid->column('id', __('Id'));
        $grid->column('m_code', __('M code'));
        $grid->column('m_name', __('M name'));
        $grid->column('m_logo_url', __('M logo url'))->display(function(){
            return '<img src="'.$this->m_logo_url.'">';
        });
        $grid->column('m_contact', __('M contact'));
        $grid->column('m_phone', __('M phone'));
        $grid->column('m_email', __('M email'));
        $grid->column('status')->using([0=>'禁用',1=>'正常'])->label([1=>'success',0=>'warning']);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('m_code',_('商户编码'));
            $filter->equal('m_name',_('商户名称'));
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
        $show = new Show(Merchant::findOrFail($id));

        $show->field('m_code', __('M code'));
        $show->field('m_name', __('M name'));
        $show->field('m_logo_url', __('M logo url'))->image('',100,100);
        $show->field('m_contact', __('M contact'));
        $show->field('m_phone', __('M phone'));
        $show->field('m_email', __('M email'));
        $show->field('status',__('Status'))->using([0=>'禁用',1=>'正常']);
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
        $form = new Form(new Merchant());
        $form->text('m_code', __('M code'))->required()->default(function () {
            $snowflake = new Snowflake();
            return substr($snowflake->id(),5,13);
        });
        $form->text('m_name', __('M name'))->required();
        $form->image('m_logo_url', __('M logo url'))->uniqueName();
        $form->text('m_contact', __('M contact'))->required();
        $form->mobile('m_phone', __('M phone'))->required();
        $form->email('m_email', __('M email'));
        $form->switch('status', __('Status'))->default('1');

        return $form;
    }
}
