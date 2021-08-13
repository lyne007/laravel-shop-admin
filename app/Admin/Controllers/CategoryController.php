<?php

namespace App\Admin\Controllers;

use App\Models\Admin\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Tree;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Category';

    /**
     * Make a grid builder.
     *
     * @return Content
     */
    /*protected function grid()
    {
        $grid = new Grid(new Category());
        $grid->model()->where('cate_parent_id','=',0);
        $grid->column('id', __('Id'));
        $grid->column('cate_name', __('Cate name'));
        $grid->column('cate_parent_id', __('Cate parent id'))->display(function($cate_parent_id){
            return $cate_parent_id == 0 ? '一级分类':'二级分类';
        });
        $grid->column('status', __('Status'))->display(function($status){
            return $status==1?"正常":"禁用";
        });
        $grid->column('cate_image', __('Cate image'))->image('','30','30');

        $grid->column('sort_weight', __('Sort weight'));
        $grid->column('show_index', __('Show index'))->display(function($show_index){
            return $show_index==1?"显示":"不显示";
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('cate_name');
        });
        return $grid;
    }*/
    public function index(Content $content)
    {
        $tree = new Tree(new Category);
        $tree->branch(function($branch){
            $src = config('admin.upload.host') . '/uploads/' . $branch['cate_image'] ;
            $logo = "<img src='$src' style='max-width:25px;max-height:25px' class='img'/>";
            return "{$branch['id']} - $logo  - {$branch['cate_name']}";
        });
        return $content
            ->header('分类列表')
            ->body($tree);
    }
    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cate_name', __('Cate name'));
        $show->field('cate_parent_id', __('Cate parent id'));
        $show->field('status', __('Status'));
        $show->field('cate_image', __('Cate image'))->image('','100','100');
        $show->field('sort_weight', __('Sort weight'));
        $show->field('show_index', __('Show index'));
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
        $form = new Form(new Category());

        $form->text('cate_name', __('Cate name'));
        $form->select('cate_parent_id',__('Cate parent id'))->options('/admin/api/cate')->default(0);
        $form->radio('status')->options([0=>"禁用",1=>"启用"])->default(1);
        $form->image('cate_image', __('Cate image'));

//        $form->text('cate_image', __('Cate image'));
        $form->number('sort_weight', __('Sort weight'))->default(0);
        $form->radio('show_index')->options([0=>"不显示",1=>"显示"])->default(0);


        return $form;
    }


}
