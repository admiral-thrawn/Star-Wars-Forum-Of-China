<?php

namespace App\Http\Controllers;

use App\Http\Requests\Columns\StoreColumnRequest;
use App\Http\Requests\Columns\UpdateColumnRequest;
use App\Models\Column;
use Illuminate\Http\Response;

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
    }

    public function update(UpdateColumnRequest $request)
    {
    }

    public function destroy()
    {
    }
}
