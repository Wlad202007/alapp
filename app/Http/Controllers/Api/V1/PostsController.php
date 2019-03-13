<?php

namespace App\Http\Controllers\Api\V1;

use App\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post as PostResource;
use App\Http\Requests\Admin\StorePostsRequest;
use App\Http\Requests\Admin\UpdatePostsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Traits\FileUploadTrait;


class PostsController extends Controller
{
    public function index()
    {
        return new PostResource(Post::with(['group', 'author'])->get());
    }
 public function indexGroup($group)
    {
		//DB::connection()->enableQueryLog();
        $posts = Post::with(['group', 'author'])->ofGroup($group)->orderBy('created_at','asc')->get();
		//$query1 = DB::getQueryLog();
		//dd($sponsors,$query1);
        return new PostResource($posts);
    }
    public function show($id)
    {
        if (Gate::denies('post_view')) {
            return abort(401);
        }

        $post = Post::with(['group', 'author'])->findOrFail($id);

        return new PostResource($post);
    }

    public function storeAlt(Request $request)
    {
        $post = Post::create($request->all());

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $key => $file) {
                $post->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return Post::with(['author'])->findOrFail($post->id);
    }

    public function store(StorePostsRequest $request)
    {


//        if (Gate::denies('post_create')) {
//            return abort(401);
//        }

        $post = Post::create($request->all());
        
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $key => $file) {
                $post->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdatePostsRequest $request, $id)
    {
//        if (Gate::denies('post_edit')) {
//            return abort(401);
//        }

        $post = Post::findOrFail($id);
        $post->update($request->all());
        
        $filesInfo = explode(',', $request->input('uploaded_gallery'));
        foreach ($post->getMedia('gallery') as $file) {
            if (! in_array($file->id, $filesInfo)) {
                $file->delete();
            }
        }
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $key => $file) {
                $post->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return (new PostResource($post))
            ->response()
            ->setStatusCode(202);
    }

    

    public function destroy($id)
    {
        if (Gate::denies('post_delete')) {
            return abort(401);
        }

        $post = Post::findOrFail($id);
        $post->delete();

        return response(null, 204);
    }
}
