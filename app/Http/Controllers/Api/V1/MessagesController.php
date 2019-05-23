<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use App\User;
use App\Viber;
use App\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\Message as MessageResource;
use App\Http\Requests\Admin\StoreMessagesRequest;
use App\Http\Requests\Admin\UpdateMessagesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\UserMessage as UserMessageResource;

use App\Http\Controllers\Traits\FileUploadTrait;


class MessagesController extends Controller
{


    public function sendViberMsg(Request $request)
    {
        $Viber = new Viber();
        dd($Viber->message_post(
            '01234567890A=',
            [
                'name' => 'Admin', // Имя отправителя. Максимум символов 28.
                'avatar' => 'http://avatar.example.com' // Ссылка на аватарку. Максимальный размер 100кб.
            ],
            'Test'
        ));
    }


    public function notifiUnRead()
    {
      $auth = Auth::user();
             // GET UNREAD MSGS
     $unreadMessages = \App\Message::where(function ($query) use ($auth) {
         $query->where('friend_id',$auth->id)
             ->where('read', 0);
     })->count();

      return $unreadMessages;
    }

    public function my()
    {
        return Auth::user()->myMessages()->get();
    }

    public function myMessanger()
    {
        $auth = Auth::user();

        // $myMessages = User::whereHas('myMessages', function($q) use ($auth){
        //     $q->where('author_id', $auth->id)
        //       ->orWhere('friend_id', $auth->id)
        //         ->orderBy('created_at', 'DESC');
        // })->with('myMessages')->orderBy('created_at', 'DESC')
        //     ->get()->unique()->toArray();

        $friendsMessages = User::whereHas('friendsMessages', function($q) use ($auth){
            $q->where('author_id', $auth->id)
              ->orWhere('friend_id', $auth->id)
                ->orderBy('created_at', 'DESC');
        })->with('friendsMessages')->with('myMessages')->orderBy('created_at', 'DESC')
            ->get();


            // $merged = array_merge($myMessages, $friendsMessages);
        // $merged = array_merge($friendsMessages);
        //
        // $final  = [];
        //
        // foreach ($merged as $current) {
        //     if ( ! in_array($current, $final)) {
        //         $final[] = $current;
        //     }
        // }
        // return $friendsMessages;
      return  UserMessageResource::collection($friendsMessages);



//        return Message::orderBy('created_at', 'desc')
//            ->where('author_id', $auth->id)
//            ->orWhere('friend_id', $auth->id)
//            ->get()
//            ->unique(['author_id', 'friend_id']);


//        return User::whereHas('myMessages', function($q) use ($auth){
//            $q->where('author_id', $auth->id)
//              ->orWhere('friend_id', $auth->id);
//        })->with([ 'myMessages' => function($query) use ($auth) {
//            $query->where('author_id', $auth->id)
//                  ->orWhere('friend_id', $auth->id)
//                  ->orderBy('created_at', 'desc')
//                  ->limit(1);
//        }])->get();




//        return Message::orderBy('created_at', 'desc')
//            ->where('author_id', $auth->id)
//            ->orWhere('friend_id', $auth->id)
//            ->get();

//        select('friend_id', 'body', 'created_at')
//        ->distinct(['friend_id'])
    }


    public function personalDialog($id)
    {
        $auth = Auth::user();



        $messages = Message::orderBy('created_at', 'desc')
            ->where(function ($query) use ($auth, $id) {
              $query->where('author_id',$id)
                  ->where('friend_id', $auth->id);
            });

        foreach ($messages->get() as  $message) {
          $message->update([
              'read' => 1
          ]);
          $message->save();
        };

            $messages = Message::orderBy('created_at', 'desc')
                ->where(function ($query) use ($auth, $id) {
                    $query->where('author_id',$auth->id)
                        ->where('friend_id', $id);
                })->orWhere(function($query) use ($auth, $id) {
                    $query->where('author_id',$id)
                        ->where('friend_id', $auth->id);
                })->get();



        return $messages;

    }

    public function sendPersonalMsg(Request $request)
    {
        $auth = Auth::user();

        $message = Message::create([
            'body' => $request->body,
            'friend_id' => $request->friend_id,
            'author_id' => $auth->id
        ]);

        return $message;

    }

    public function groupDialog($id)
    {
        $auth = Auth::user();

        $messages = Message::orderBy('created_at', 'desc')
            ->where('group_id', $id)->get();

        return $messages;

    }

    public function sendGroupMsg(Request $request)
    {
        $auth = Auth::user();

        $message = Message::create([
            'body' => $request->body,
            'group_id' => $request->group_id,
            'author_id' => $auth->id
        ]);

        return $message;

    }


    public function index()
    {
        return new MessageResource(Message::with(['users', 'author', 'group'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('message_view')) {
            return abort(401);
        }

        $message = Message::with(['users', 'author', 'group'])->findOrFail($id);

        return new MessageResource($message);
    }

    public function store(StoreMessagesRequest $request)
    {
        if (Gate::denies('message_create')) {
            return abort(401);
        }

        $message = Message::create($request->all());
        $message->users()->sync($request->input('users', []));
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $key => $file) {
                $message->addMedia($file)->toMediaCollection('attachments');
            }
        }

        return (new MessageResource($message))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateMessagesRequest $request, $id)
    {
        if (Gate::denies('message_edit')) {
            return abort(401);
        }

        $message = Message::findOrFail($id);
        $message->update($request->all());
        $message->users()->sync($request->input('users', []));
        $filesInfo = explode(',', $request->input('uploaded_attachments'));
        foreach ($message->getMedia('attachments') as $file) {
            if (! in_array($file->id, $filesInfo)) {
                $file->delete();
            }
        }
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $key => $file) {
                $message->addMedia($file)->toMediaCollection('attachments');
            }
        }

        return (new MessageResource($message))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('message_delete')) {
            return abort(401);
        }

        $message = Message::findOrFail($id);
        $message->delete();

        return response(null, 204);
    }
}
