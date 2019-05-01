<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use App\Like;
use App\Post;
use Hash;
use App\User;
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


    public function store_like(StoreLikesRequest $request)
    {
        $post_id = $request['post_id'];
        $user_id = $request['author_id'];

        //$user = Auth::user();

        // if (!$user) {
        //   return null;
        // }
        $like = Like::where('author_id', $user_id)->first();

        if ($like) {
                $like->delete();
                return null;
        } else {
                $like = Like::create($request->all());
        }

        return (new LikeResource($like))
            ->response()
            ->setStatusCode(201);

        //return  $like->author_id;
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
