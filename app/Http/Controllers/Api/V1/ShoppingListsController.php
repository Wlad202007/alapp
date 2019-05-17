<?php

namespace App\Http\Controllers\Api\V1;

use App\ShoppingList;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShoppingList as ShoppingListResource;
//use App\Http\Requests\Admin\StorePostsRequest;
//use App\Http\Requests\Admin\UpdatePostsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

//use App\Http\Controllers\Traits\FileUploadTrait;


class ShoppingListsController extends Controller
{
    public function index()
    {

        return new ShoppingListResource(ShoppingList::with(['author','shoppings'])->where('author_id', \Auth::user()->id)->get());
    }

    public function show($id)
    {
        $shoppingslist = ShoppingList::with(['author','shoppings'])->findOrFail($id);

        return new ShoppingListResource($shoppingslist);
    }

    public function store(Request $request)
    {

        $shoppinglist = ShoppingList::create($request->all());


    }

    public function update(Request $request, $id)
    {
        $shoppingslist = ShoppingList::findOrFail($id);
        $shoppingslist->update($request->all());


        return (new ShoppingListResource($shoppingslist))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        $shoppingslist = ShoppingList::where('id',$id)->withTrashed()->first();
        $shoppingslist->delete();

        return response(null, 204);
    }
}
