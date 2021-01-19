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
    /**
     * 返回所有专栏
     *
     * @method GET
     * @api /columns
     *
     * @return Column column
     */
    public function index()
    {
        $columns = Column::paginate(20);

        return response($columns, Response::HTTP_OK);
    }

    /**
     * 查找指定专栏
     * @method GET
     * @api /columns/{column}
     *
     *
     * @return Column column
     */
    public function show(Column $column)
    {
        return response($column, Response::HTTP_OK);
    }

    /**
     * 创建并存储专栏
     * @method POST
     * @api /columns
     *
     * @return Column column
     */
    public function store(StoreColumnRequest $request)
    {
        $validatedData = $request->all();

        $column = new Column($validatedData);

        $user = $request->user();

        $column->save();

        // 授权用户拥有此专栏
        Bouncer::allow($user)->toOwn($column)->to(['view', 'update', 'delete']);

        // 返回专栏和200状态码
        return response($column, Response::HTTP_OK);
    }

    /**
     * 更新专栏
     * @method PUT
     * @api /columns/{column}
     *
     *
     * @return Column column
     */
    public function update(UpdateColumnRequest $request, Column $column)
    {
        $validatedData = $request->all();

        $column->save($validatedData);

        return response($column, Response::HTTP_OK);
    }

    public function edit(Column $column)
    {
        Gate::authorize('update', $column);
        return response($column->makeVisible('description_raw'),Response::HTTP_OK);
    }

    /**
     * 删除专栏
     * @method DELETE
     * @api /columns/{column}
     *
     * @param uuid id
     *
     */
    public function destroy(Column $column)
    {
        Gate::authorize('delete', $column);

        $column->delete();

        // 响应
        return response([
            'message' => 'successfully delete'
        ], Response::HTTP_OK);
    }

    /**
     * 专栏下的文章
     * @method GET
     *
     * @param Column column
     */
    public function article(Column $column)
    {
        $articles = $column->articles()->paginate(10);

        return response($articles, Response::HTTP_OK);
    }
}
