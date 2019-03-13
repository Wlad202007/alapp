<?php

namespace App\Http\Controllers\Api\V1;

use App\Agenda;
use App\Http\Controllers\Controller;
use App\Http\Resources\Agenda as AgendaResource;
use App\Http\Requests\Admin\StoreAgendasRequest;
use App\Http\Requests\Admin\UpdateAgendasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class AgendasController extends Controller
{
    public function index()
    {
        $agendas = Agenda::with(['event'])->get();
//        $agendas = Agenda::with(['event'])->groupBy('date')->get();

        return new AgendaResource($agendas);
    }

	 public function indexEvent($event)
    {
        $agendas = Agenda::where('event_id',$event)->with(['event'])->orderBy('date','asc')->get();

        return new AgendaResource($agendas);
    }

    public function show($id)
    {
        if (Gate::denies('agenda_view')) {
            return abort(401);
        }

        $agenda = Agenda::with(['event'])->findOrFail($id);

        return new AgendaResource($agenda);
    }

    public function store(StoreAgendasRequest $request)
    {
        if (Gate::denies('agenda_create')) {
            return abort(401);
        }

        $agenda = Agenda::create($request->all());
        
        

        return (new AgendaResource($agenda))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateAgendasRequest $request, $id)
    {
        if (Gate::denies('agenda_edit')) {
            return abort(401);
        }

        $agenda = Agenda::findOrFail($id);
        $agenda->update($request->all());
        
        
        

        return (new AgendaResource($agenda))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('agenda_delete')) {
            return abort(401);
        }

        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return response(null, 204);
    }
}
