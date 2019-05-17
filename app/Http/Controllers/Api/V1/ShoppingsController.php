<?php

namespace App\Http\Controllers\Api\V1;

use App\Shopping;
use App\Http\Controllers\Controller;
use App\Http\Resources\Shopping as ShoppingResource;
//use App\Http\Requests\Admin\StoreCommentsRequest;
//use App\Http\Requests\Admin\UpdateCommentsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class ShoppingsController extends Controller
{

  public function shoppingDone(Request $request, $id){
      $shopping = Shopping::findOrFail($id);

      if($shopping->done == 1){
          $done = 0;
      } else {
          $done = 1;
      }

      $shopping->update([
          'done' => $done
      ]);

      $shopping->save();

      return $shopping;
  }
    public function index()
    {
        return new ShoppingResource(Shopping::with(['shoppinglist', 'author'])->get());
    }

    public function show($id)
    {

        $shopping = Shopping::with(['shoppinglist', 'author'])->findOrFail($id);

        return new ShoppingResource($shopping);
    }

    public function store(Request $request)
    {

        $shopping = Shopping::create($request->all());


    }


    public function destroy($id)
    {


        $shopping = Shopping::findOrFail($id);
        $shopping->delete();

        return response(null, 204);
    }

}
