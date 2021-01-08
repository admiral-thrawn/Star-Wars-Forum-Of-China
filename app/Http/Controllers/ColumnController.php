<?php

namespace App\Http\Controllers;

use App\Http\Requests\Columns\StoreColumnRequest;
use App\Http\Requests\Columns\UpdateColumnRequest;
use App\Models\Column;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Silber\Bouncer\BouncerFacade as Bouncer;

/**
 * 专栏控制器
 *
 * index()列表
 * show()查找指定
 * store()创建并存储
 * update()更新
 * destroy()删除
 *
 * @author admiral-thrawn
 */
class ColumnController extends Controller
{
    public function index()
    {
        $columns = Column::pagenate(20);

        return response([
            'data' => $columns
        ], Response::HTTP_OK);
    }

    public function show(Column $column)
    {
        return response([
            'data' => $column
        ], Response::HTTP_OK);
    }

    public function store(StoreColumnRequest $request)
    {
        $validatedData = $request->validate();

        $column = new Column($validatedData);

        $user = $request->user();

        $column->save();

        // 授权用户拥有此专栏
        Bouncer::allow($user)->toOwn($column)->to(['view', 'update', 'delete']);

        // 返回专栏和200状态码
        return response([
            'data' => $column
        ], Response::HTTP_OK);
    }

    public function update(UpdateColumnRequest $request, Column $column)
    {
        $validatedData = $request->validate();

        $column->save($validatedData);

        return response([
            'data' => $column
        ], Response::HTTP_OK);
    }

    public function destroy(Column $column)
    {
        Gate::authorize('delete', $column);

        $column->delete();

        // 响应
        return response([
            'message' => 'successfully delete'
        ], Response::HTTP_OK);
    }
}
