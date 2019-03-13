<?php

namespace App\Http\Controllers\Api\V1;

use App\Like;
use App\Http\Controllers\Controller;
use App\Http\Resources\Like as LikeResource;
use App\Http\Requests\Admin\StoreLikesRequest;
use App\Http\Requests\Admin\UpdateLikesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class LikesController extends Controller
{
    public function index()
    {
        

        return new LikeResource(Like::with(['author', 'post'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('like_view')) {
            return abort(401);
        }

        $like = Like::with(['author', 'post'])->findOrFail($id);

        return new LikeResource($like);
    }

    public function store(StoreLikesRequest $request)
    {
        if (Gate::denies('like_create')) {
            return abort(401);
        }

        $like = Like::create($request->all());
        
        

        return (new LikeResource($like))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateLikesRequest $request, $id)
    {
        if (Gate::denies('like_edit')) {
            return abort(401);
        }

        $like = Like::findOrFail($id);
        $like->update($request->all());
        
        
        

        return (new LikeResource($like))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('like_delete')) {
            return abort(401);
        }

        $like = Like::findOrFail($id);
        $like->delete();

        return response(null, 204);
    }
}
