<?php

namespace App\Http\Controllers\Api\V1;

use App\Vote;
use App\Http\Controllers\Controller;
use App\Http\Resources\Vote as VoteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return new VoteResource(Vote::with(['user', 'session'])->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//                if (Gate::denies('vote_create')) {
//            return abort(401);
//        }

        $vote = Vote::create($request->all());
        
        

        return (new Vote($vote))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $vote = Vote::with(['user', 'session'])->findOrFail($id);

        return new VoteResource($vote);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('vote_edit')) {
            return abort(401);
        }

        $vote = Vote::findOrFail($id);
        $vote->update($request->all());
        
        
        

        return (new VoteResource($vote))
            ->response()
            ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if (Gate::denies('vote_delete')) {
            return abort(401);
        }

        $vote = Vote::findOrFail($id);
        $vote->delete();

        return response(null, 204);
    }
}
