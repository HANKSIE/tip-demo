<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tip', function (Request $request) {
    return response()->json($request->all());
});

Route::get('/stores', function () {
    return response()->json(
        [
            'stores' => [
                ['id' => 1, 'name' => '店家1'],
                ['id' => 2, 'name' => '店家2'],
            ],
        ]
    );
});

Route::get('/store/{id}/options', function ($id) {
    return response()->json(
        $id == 1 ?
        [
            'employees' => [
                ['id' => 1, 'name' => '店家1的店員1'],
                ['id' => 2, 'name' => '店家1的店員2'],
            ],
            'amounts' => [100, 200, 300],
            'comments' => ['bad', 'normal', 'very good'],
        ]
        :
        [
            'employees' => [
                ['id' => 3, 'name' => '店家2的店員1'],
                ['id' => 4, 'name' => '店家2的店員2'],
            ],
            'amounts' => [1000, 2000, 3000],
            'comments' => ['差', '一般', '棒透了'],
        ]

    );
});
