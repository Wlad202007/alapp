<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Resources\Group as GroupResource;
use App\Http\Requests\Admin\StoreGroupsRequest;
use App\Http\Requests\Admin\UpdateGroupsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class GroupsController extends Controller
{
    public function index()
    {
        return new GroupResource(Group::with([])->get());
    }
	
	 public function indexUser($user)
    {
		//DB::connection()->enableQueryLog();
		$groups = Group::ofUser($user)->orderBy('name','asc')->get();
		//$query1 = DB::getQueryLog();
		//dd($sponsors,$query1);
        return new GroupResource($groups);
    }

    public function toggleJoin($id){

        $auth = Auth::user();

        if($auth->joined->contains($id)){
            $auth->joined()->detach($id);
            return 0;
        } else {
            $auth->joined()->attach($id);
            return 1;
        }

        return '';
    }

    public function show($id)
    {
//        if (Gate::denies('group_view')) {
//            return abort(401);
//        }

        $group = Group::with([])->findOrFail($id);

        return new GroupResource($group);
    }

    public function store(StoreGroupsRequest $request)
    {
        if (Gate::denies('group_create')) {
            return abort(401);
        }

        $group = Group::create($request->all());



        return (new GroupResource($group))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateGroupsRequest $request, $id)
    {
        if (Gate::denies('group_edit')) {
            return abort(401);
        }

        $group = Group::findOrFail($id);
        $group->update($request->all());




        return (new GroupResource($group))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('group_delete')) {
            return abort(401);
        }

        $group = Group::findOrFail($id);
        $group->delete();

        return response(null, 204);
    }
	
	public function groupRelation($group,$model,$type,$id){
		 if (Gate::denies('group_edit')) {
            return abort(401);
        }
		 $groupid = Group::findOrFail($group);
		 $code=400;
		 if ($model=='posts'){
			 if($type=='add'){
			 $groupid->posts()->attach($id);
			 $code=202;
			 }elseif($type=='del'){
			 $groupid->posts()->detach($id);
			  $code=204;
			 }
		 }elseif($model=='users'){
			 if($type=='add'){
			 $groupid->users()->attach($id);
			  $code=202;
			 }elseif($type=='del'){
			 $groupid->users()->detach($id);
			  $code=204;
			 }
		 }
		 
		 
		   return response(null, $code);
		
		
	}
}