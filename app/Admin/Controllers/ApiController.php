<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin\AttributeKey;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * 获取顶级分类
     * @param $f 区分返回数据是否需要添加【顶级分类】0不添加
     * @return \Illuminate\Http\JsonResponse
     */
    public function cate(Request $request,$f = 1)
    {
        $q = $request->get('q') ?? 0;
        $cate = Category::select('id','cate_name as text')->where('cate_parent_id',$q)->get();

        if ($f) {
            $cate1[0]['id'] = 0;
            $cate1[0]['text'] = '顶级分类';
            $cate = array_merge($cate1,$cate->toArray());
        }
        return response()->json($cate);
    }

    /**
     * 获取属性key列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function attr()
    {
        $data = AttributeKey::select('id','attribute_name as text')->get()->toArray();
        return response()->json($data);
    }

}
