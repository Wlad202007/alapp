<?php

namespace App\Http\Controllers\Api\V1;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Requests\Admin\StoreCommentsRequest;
use App\Http\Requests\Admin\UpdateCommentsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class CommentsController extends Controller
{
    public function index()
    {
        

        return new CommentResource(Comment::with(['post', 'author'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('comment_view')) {
            return abort(401);
        }

        $comment = Comment::with(['post', 'author'])->findOrFail($id);

        return new CommentResource($comment);
    }

    public function store(StoreCommentsRequest $request)
    {
        if (Gate::denies('comment_create')) {
            return abort(401);
        }

        $comment = Comment::create($request->all());
        
        

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCommentsRequest $request, $id)
    {
        if (Gate::denies('comment_edit')) {
            return abort(401);
        }

        $comment = Comment::findOrFail($id);
        $comment->update($request->all());
        
        
        

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('comment_delete')) {
            return abort(401);
        }

        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response(null, 204);
    }
}
