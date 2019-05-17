<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use App\User;
use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event as EventResource;
use App\Http\Requests\Admin\StoreEventsRequest;
use App\Http\Requests\Admin\UpdateEventsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Traits\FileUploadTrait;


class EventsController extends Controller
{
    public function index()
    {


        return new EventResource(Event::with(['attendees', 'sponsors', 'agenda', 'industry'])->get());
    }
    public function allIndex(request $request)
    {
      $month = $request->month;
      $year = $request->year;

      if($month and $year){
        $events = Event::whereMonth('date_from',$month)->whereYear('date_from',$year)->with(['attendees', 'sponsors', 'agenda', 'industry'])->get();
      }
      else{
      $events = Event::with(['attendees', 'sponsors', 'agenda', 'industry'])->get();
      }
      return $events;
    }
 public function indexUser($user)
    {
		//DB::connection()->enableQueryLog();
		$events = Event::with(['attendees', 'sponsors', 'agenda', 'industry'])->ofUser($user)->orderBy('name','asc')->get();
		//$query1 = DB::getQueryLog();
		//dd($sponsors,$query1);
        return new EventResource($events);
    }
    public function pastIndex()
    {
         $events = Event::whereDate('date_to','<=', date('Y-m-d'))->with(['attendees', 'sponsors', 'agenda', 'industry'])->get();
         return $events;
    }
    public function futureIndex()
    {
         $events = Event::whereDate('date_from','>=', date('Y-m-d'))->with(['attendees', 'sponsors', 'agenda', 'industry'])->get();
         return $events;
    }

    public function toggleLike($id)
    {

        $event = Event::findOrFail($id);

        if($event->liked){
            $event->fav_users()->detach([Auth::user()->id], false);
        }else{
            $event->fav_users()->sync([Auth::user()->id]);
        }

        return $event;

    }


    public function sendAgendaRequest($id)
    {

        $event = Event::findOrFail($id);
        $event->agenda_requests()->sync([Auth::user()->id]);

        return $event;

    }

    public function show($id)
    {
//        if (Gate::denies('event_view')) {
//            return abort(401);
//        }

        $event = Event::with(['attendees', 'sponsors', 'agenda_requests', 'sessions', 'agendas', 'industry'])->findOrFail($id);

        return new EventResource($event);
    }

    public function store(StoreEventsRequest $request)
    {
        if (Gate::denies('event_create')) {
            return abort(401);
        }

        $event = Event::create($request->all());
        $event->attendees()->sync($request->input('attendees', []));
        $event->sponsors()->sync($request->input('sponsors', []));
        $event->agenda()->sync($request->input('agenda', []));
        if ($request->hasFile('full_agenda')) {
            $event->addMedia($request->file('full_agenda'))->toMediaCollection('full_agenda');
        }

        return (new EventResource($event))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateEventsRequest $request, $id)
    {
        if (Gate::denies('event_edit')) {
            return abort(401);
        }

        $event = Event::findOrFail($id);
        $event->update($request->all());
        $event->attendees()->sync($request->input('attendees', []));
        $event->sponsors()->sync($request->input('sponsors', []));
        $event->agenda()->sync($request->input('agenda', []));
        if (! $request->input('full_agenda') && $event->getFirstMedia('full_agenda')) {
            $event->getFirstMedia('full_agenda')->delete();
        }
        if ($request->hasFile('full_agenda')) {
            $event->addMedia($request->file('full_agenda'))->toMediaCollection('full_agenda');
        }

        return (new EventResource($event))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('event_delete')) {
            return abort(401);
        }

        $event = Event::findOrFail($id);
        $event->delete();

        return response(null, 204);
    }

	public function eventRelation($event,$model,$type,$id){
		 if (Gate::denies('event_edit')) {
            return abort(401);
        }
		 $eventid = Event::findOrFail($event);
		 $code=400;
		 if ($model=='sponsors'){
			 if($type=='add'){
			 $eventid->sponsors()->attach($id);
			 $code=202;
			 }elseif($type=='del'){
			 $eventid->sponsors()->detach($id);
			  $code=204;
			 }
		 }elseif($model=='attendees'){
			 if($type=='add'){
			 $eventid->attendees()->attach($id);
			  $code=202;
			 }elseif($type=='del'){
			 $eventid->attendees()->detach($id);
			  $code=204;
			 }
		 }


		   return response(null, $code);


	}



}
