<?php

namespace App\Http\Controllers\Api\V1;

use App\Note;
use App\Http\Controllers\Controller;
use App\Http\Resources\Note as NoteResource;
use App\Http\Requests\Admin\StoreNotesRequest;
use App\Http\Requests\Admin\UpdateNotesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class NotesController extends Controller
{
    public function index()
    {

        return new NoteResource(Note::with(['author'])->get());
    }

	 public function indexUser($user)
    {
		//DB::connection()->enableQueryLog();
        $notes = Note::with(['author'])->ofUser($user)->orderBy('id','asc')->get();
		//$query1 = DB::getQueryLog();
		//dd($sponsors,$query1);
        return new NoteResource($notes);
    }
    public function my()
    {

        $notes = Note::where('author_id', \Auth::user()->id)->get();

        return new NoteResource($notes);
    }

    public function show($id)
    {
        if (Gate::denies('note_view')) {
            return abort(401);
        }

        $note = Note::with(['author'])->findOrFail($id);

        return new NoteResource($note);
    }

    public function store(StoreNotesRequest $request)
    {
        if (Gate::denies('note_create')) {
            return abort(401);
        }

        $note = Note::create($request->all());
        
        

        return (new NoteResource($note))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateNotesRequest $request, $id)
    {
        if (Gate::denies('note_edit')) {
            return abort(401);
        }

        $note = Note::findOrFail($id);
        $note->update($request->all());
        
        
        

        return (new NoteResource($note))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('note_delete')) {
            return abort(401);
        }

        $note = Note::findOrFail($id);
        $note->delete();

        return response(null, 204);
    }
}
