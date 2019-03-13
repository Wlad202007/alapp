<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use App\User;
use App\UsersLike;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersLike as UsersLikeResource;
use App\Http\Requests\Admin\StoreUsersLikesRequest;
use App\Http\Requests\Admin\UpdateUsersLikesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class UsersLikesController extends Controller
{
    public function index()
    {
        return new UsersLikeResource(UsersLike::with(['author', 'user'])->get());
    }

    public function like(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $authUser = \Auth::user();
        $voteCheck = UsersLike::where('author_id',$authUser->id)->where('user_id',$id)->first();

        if(!$voteCheck){
            $vote = UsersLike::create([
                'author_id' => $id,
                'user_id' => $authUser->id,
                'text' => $request->rate
            ]);
            return $vote;
        } else {
            $voteCheck->delete();
            return 'unliked';
        }

    }

    public function show($id)
    {
        if (Gate::denies('users_like_view')) {
            return abort(401);
        }

        $users_like = UsersLike::with(['author', 'user'])->findOrFail($id);

        return new UsersLikeResource($users_like);
    }

    public function store(StoreUsersLikesRequest $request)
    {
        if (Gate::denies('users_like_create')) {
            return abort(401);
        }

        $users_like = UsersLike::create($request->all());
        
        

        return (new UsersLikeResource($users_like))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateUsersLikesRequest $request, $id)
    {
        if (Gate::denies('users_like_edit')) {
            return abort(401);
        }

        $users_like = UsersLike::findOrFail($id);
        $users_like->update($request->all());
        
        
        

        return (new UsersLikeResource($users_like))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('users_like_delete')) {
            return abort(401);
        }

        $users_like = UsersLike::findOrFail($id);
        $users_like->delete();

        return response(null, 204);
    }
}
