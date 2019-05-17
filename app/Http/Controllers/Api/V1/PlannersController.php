<?php

namespace App\Http\Controllers\Api\V1;

use App\Planner;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\Planner as PlannerResource;
use App\Http\Requests\Admin\StorePlannersRequest;
use App\Http\Requests\Admin\UpdatePlannersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class PlannersController extends Controller
{
    public function myIndex()
    {

//        $plans = Planner::where('author_id', \Auth::user()->id)->groupBy(function($q) {
//        return Carbon::parse($q->created_at)->format('m');
//        return Carbon::createFromFormat($q->created_at)->format('m');
//        return Carbon::createFromFormat('d.m.Y h:i:s', $q->created_at)->format('m');
//            dd($q->id);
//        })->get();


        $plans = Planner::where('author_id', \Auth::user()->id)->get()->groupBy(function($data) {
            $date = Carbon::parse($data->time)->format('d.m.Y');
            return $date;
        });

        return $plans;

//        return new PlannerResource($plans);
    }

	 public function indexUser($user)
    {
		//DB::connection()->enableQueryLog();
		$planners = Planner::with(['author','users'])->ofUser($user)->orderBy('time','asc')->get();
		//$query1 = DB::getQueryLog();
		//dd($sponsors,$query1);
        return new PlannerResource($planners);
    }

    public function toggleDone(Request $request, $id){
        $post = Planner::findOrFail($id);

        if($post->done == 1){
            $done = 0;
        } else {
            $done = 1;
        }

        $post->update([
            'done' => $done
        ]);

        $post->save();

        return $post;
    }


    public function index()
    {


        return new PlannerResource(Planner::with(['users', 'author'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('planner_view')) {
            return abort(401);
        }

        $planner = Planner::with(['users', 'author'])->findOrFail($id);

        return new PlannerResource($planner);
    }

    public function store(StorePlannersRequest $request)
    {
//        if (Gate::denies('planner_create')) {
//            return abort(401);
//        }

        $time = Carbon::parse($request->time)->format(config('app.date_format') . ' H:i:s');

        $request->request->add([
            'time' => $time
        ]);

        $planner = Planner::create($request->all());
        $planner->users()->sync($request->input('users', []));


        return (new PlannerResource($planner))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdatePlannersRequest $request, $id)
    {
        if (Gate::denies('planner_edit')) {
            return abort(401);
        }

        $planner = Planner::findOrFail($id);
        $planner->update($request->all());
        $planner->users()->sync($request->input('users', []));



        return (new PlannerResource($planner))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('planner_delete')) {
            return abort(401);
        }

        $planner = Planner::findOrFail($id);
        $planner->delete();

        return response(null, 204);
    }
}
