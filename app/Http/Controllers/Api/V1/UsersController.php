<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use Hash;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Validator;


use App\Http\Controllers\Traits\FileUploadTrait;


class UsersController extends Controller
{
    public function swithchReadStatus()
    {
        $auth = Auth::user();
        $lastMessage = 'No new posts';
        // $post_id = $id;
        $groupArray = $auth->joined()->get()->pluck('id')->toArray();
        // $post_id = \App\Post::all()->first()->id; // NEED TO BE REPLACED WITH POST ID FROM REQUEST!!!
        // return $auth->joined()->Select('id')->get()->toArray();
        // $auth->read_status()->attach([$post_id]);

       //return $auth->read_status()->get()->count(); // RETURN ALL SYNCRONYZED POSTS - NOT NECESSARY

               // GET UNREAD MSGS
       $unreadMessages = \App\Post::whereIn('group_id',  $groupArray)
       ->whereDoesntHave('read_by', function($query) use ($auth){
           $query->where('author_id', '=', $auth->id);
       });

       foreach ($unreadMessages->get() as  $Message) {
          $lastMessage = $Message;
          $auth->read_status()->attach($Message->id);
       };
        // GET READ MSGS
        // $readMessages = \App\Post::whereHas('read_by', function($query) use ($auth){
        //     $query->where('author_id', '=', $auth->id);
        // })->get()->count();

        return  $lastMessage;



    }



    public function index()
    {
//        if (Gate::denies('user_access')) {
//            return abort(401);
//        }

        return new UserResource(User::with(['role', 'my_events'])->get());
    }

	 public function indexGroup($group)
    {
		//DB::connection()->enableQueryLog();
        $users = User::with(['role', 'my_events'])->ofGroup($group)->orderBy('name','asc')->get();
		//$query1 = DB::getQueryLog();
		//dd($sponsors,$query1);
        return new UserResource($users);
    }
    public function myAccount()
    {

        $user = User::with(['role', 'my_events', 'fav_events'])->findOrFail(Auth::user()->id);

        return new UserResource($user);
    }

    public function show($id)
    {
//        if (Gate::denies('user_view')) {
//            return abort(401);
//        }

        $user = User::with(['role', 'my_events'])->findOrFail($id);

        return new UserResource($user);
    }

    public function store(StoreUsersRequest $request)
    {
        if (Gate::denies('user_create')) {
            return abort(401);
        }

        $user = User::create($request->all());
        $user->role()->sync($request->input('role', []));
        $user->my_events()->sync($request->input('my_events', []));
        if ($request->hasFile('avatar')) {
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateUsersRequest $request, $id)
    {
        if (Gate::denies('user_edit')) {
            return abort(401);
        }

        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->role()->sync($request->input('role', []));
        $user->my_events()->sync($request->input('my_events', []));
//        if (! $request->input('avatar') && $user->getFirstMedia('avatar')) {
//            $user->getFirstMedia('avatar')->delete();
//        }
        if ($request->hasFile('avatar')) {
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(202);
    }

    public function updateProfile(Request $request)
    {

        if (Auth::user()->email != $request->email) {
            return abort(401);
        }

        $user = Auth::user();
        $user->update($request->all());


        if($request->avatar64){
            $user->clearMediaCollection();
            $timestamp = Carbon::now()->timestamp;
            $user->addMediaFromBase64($request->avatar64) //starting method
            ->usingFileName($user->id.'-'.$timestamp.'.jpg')
                ->withCustomProperties(['mime-type' => 'image/jpeg']) //middle method
//                ->addMediaConversion('thumb')
//                ->setManipulations(['w' => 30])
                ->preservingOriginal() //middle method
                ->toMediaCollection('avatar');
        }


        if ($request->hasFile('avatar')) {
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('user_delete')) {
            return abort(401);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response(null, 204);
    }


    ////  CUSTOM AUTH SYSTEM   //////////////////////////////////////////////

    public function xCsrfToken(Request $request)
    {
        $resources = [
            'token' => csrf_token(),
            'auth' => Auth::check(),
            'user' => Auth::user()
        ];

        return $resources;
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return ['auth'=>'Success'];
        }

        abort(500, 'Something went wrong');

    }

    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);


        if ($validator->fails()) {
            return $validator->messages()->first();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'job' => $request->job,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $simple_role = \DB::table('roles')->where('title', 'Simple user')->pluck('id');
        $user->role()->sync($simple_role);

        Auth::login($user);
        return $user;
    }

    public function resetPassword(Request $request)
    {

    }

	public function userRelation($user,$model,$type,$id){
		 if (Gate::denies('user_edit')) {
            return abort(401);
        }
		 $userid = User::findOrFail($user);
		 $code=400;
		 if ($model=='groups'){
			 if($type=='add'){
			 $userid->joined()->attach($id);
			 $code=202;
			 }elseif($type=='del'){
			 $userid->joined()->detach($id);
			  $code=204;
			 }

		 }elseif($model=='events'){
			 if($type=='add'){
			 $userid->events()->attach($id);
			  $code=202;
			 }elseif($type=='del'){
			 $userid->events()->detach($id);
			  $code=204;
			 }
		 }elseif($model=='sessions'){
			 if($type=='add'){
				$sessionid = \App\Session::findOrFail($id);
				$sessionid->user_id=user;
				$sessionid->save();
			  $code=202;
			 }elseif($type=='del'){
				$sessionid = \App\Session::findOrFail($id);
				$sessionid->user_id=null;
				$sessionid->save();
				$code=204;
			 }
		 }elseif($model=='planners'){
			 if($type=='add'){
			 $userid->planners()->attach($id);
			  $code=202;
			 }elseif($type=='del'){
			 $userid->planners()->detach($id);
			  $code=204;
			 }
		 }


		   return response(null, $code);


	}


}
