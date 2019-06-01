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

    public function SendPush($id){
      \OneSignal::sendNotificationToUser(
      "Some Message",
      $userId = $id
      );

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

    public function localnotifiUnRead()
    {
     $auth = Auth::user();

     $notifiMessages = \App\Message::where(function ($query) use ($auth) {
         $query->where('friend_id',$auth->id)
             ->where('notifi', 0);
     });

     $nowmatch = $notifiMessages->count();

     foreach ($notifiMessages->get() as  $notifi) {
       $notifi->update([
           'notifi' => 1
       ]);
       $notifi->save();
     };

      return $nowmatch;
    }

    public function my()
    {
        return Auth::user()->myMessages()->get();
    }

    public function myMessanger()
    {
        $auth = Auth::user();

        $allmsg = Message::where('author_id', \Auth::user()->id)
            ->whereNotNull('author_id')
            ->whereNotNull('friend_id')
            ->where('group_id', null)
            ->orWhere('friend_id', \Auth::user()->id)
            ->orderBy('created_at')
            ->get();

        $array = [];
        $auth_id = $auth->id;

        foreach($allmsg as $msg){

            if($msg->friend_id==$auth_id){
                $array[$msg->author_id] = [
                    'type' => '0',
                    'author'=> $msg->author,
                    'body'=> $msg->body,
                    'time'=> $msg->created_at,
                ];
            }elseif($msg->author_id == $auth_id){
                $array[$msg->friend_id] = [
                    'type' => '1',
                    'author'=> $msg->friend,
                    'body'=> $msg->body,
                    'time'=> $msg->created_at,
                ];
            }

        }
        $allmsg = null;

        $array_sorted = array_column($array, 'time');
        array_multisort($array_sorted, SORT_ASC, $array);

        return $array;
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
