<?php

namespace App\Http\Controllers;

use App\Http\Requests\Columns\StoreColumnRequest;
use App\Http\Requests\Columns\UpdateColumnRequest;
use App\Models\Column;
use Illuminate\Http\Response;
use Silber\Bouncer\BouncerFacade as Bouncer;

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
            'data'=>$column
        ],Response::HTTP_OK);
    }

    public function destroy()
    {
    }
}
