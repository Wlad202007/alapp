<?php

namespace App\Http\Controllers\Api\V1;

use App\Session;
use App\Http\Controllers\Controller;
use App\Http\Resources\Session as SessionResource;
use App\Http\Requests\Admin\StoreSessionsRequest;
use App\Http\Requests\Admin\UpdateSessionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Traits\FileUploadTrait;


class SessionsController extends Controller
{
    public function index()
    {
        

        return new SessionResource(Session::with(['user', 'event'])->voteCount()->get());
    }
	
	 public function indexUser($user)
    {
		//DB::connection()->enableQueryLog();
		$session = Session::with(['user', 'event'])->ofUser($user)->voteCount()->orderBy('id','asc')->get();
		//$query1 = DB::getQueryLog();
		//dd($sponsors,$query1);
        return new SessionResource($session);
    }

    public function show($id)
    {
//        if (Gate::denies('session_view')) {
//            return abort(401);
//        }

        $session = Session::with(['user', 'event'])->voteCount()->findOrFail($id);

        return new SessionResource($session);
    }

    public function store(StoreSessionsRequest $request)
    {
        if (Gate::denies('session_create')) {
            return abort(401);
        }

        $session = Session::create($request->all());
        
        if ($request->hasFile('presentation')) {
            $session->addMedia($request->file('presentation'))->toMediaCollection('presentation');
        }

        return (new SessionResource($session))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateSessionsRequest $request, $id)
    {
        if (Gate::denies('session_edit')) {
            return abort(401);
        }

        $session = Session::findOrFail($id);
        $session->update($request->all());
        
        if (! $request->input('presentation') && $session->getFirstMedia('presentation')) {
            $session->getFirstMedia('presentation')->delete();
        }
        if ($request->hasFile('presentation')) {
            $session->addMedia($request->file('presentation'))->toMediaCollection('presentation');
        }

        return (new SessionResource($session))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('session_delete')) {
            return abort(401);
        }

        $session = Session::findOrFail($id);
        $session->delete();

        return response(null, 204);
    }
	
	/**************************
	**$type = yes/no set vote
	**$type = del - delete vote
	*************************/
	
	    public function vote($type,$id,$user)
    {
//        if (Gate::denies('vote_create')) {
//            return abort(401);
//        }

            $user = null;
            $user_id = \Auth::user()->id;

        $session = Session::findOrFail($id);
		if($type == 'del'){
			$session->questions()->sync([]);
		}elseif($type == 'yes' or $type == 'no') {
            $session->questions()->save([$user_id =>['status'=> $type]]);

//            if($type == 'yes') {
//                $session->questions()->attach([$user_id =>['status'=> 'yes']]);
//                $session->questions()->detach([$user_id =>['status'=> 'no']]);
//            }elseif($type == 'no') {
//                $session->questions()->attach([$user_id =>['status'=> 'no']]);
//                $session->questions()->detach([$user_id =>['status'=> 'yes']]);
//            }

        }


        return response(null, 202);
    }
	
	    public function votes($id)
    {
//        if (Gate::denies('vote_view')) {
//            return abort(401);
//        }

        $session = Session::where('id',$id)->voteCount()->first();
		

        return new SessionResource($session);
    }
	
}
