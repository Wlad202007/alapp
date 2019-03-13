<?php

namespace App\Http\Controllers\Api\V1;

use App\Evaluation;
use App\Http\Controllers\Controller;
use App\Http\Resources\Evaluation as EvaluationResource;
use App\Http\Requests\Admin\StoreEvaluationsRequest;
use App\Http\Requests\Admin\UpdateEvaluationsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class EvaluationsController extends Controller
{
    public function index()
    {
        

        return new EvaluationResource(Evaluation::with(['user', 'event'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('evaluation_view')) {
            return abort(401);
        }

        $evaluation = Evaluation::with(['user', 'event'])->findOrFail($id);

        return new EvaluationResource($evaluation);
    }

    public function store(StoreEvaluationsRequest $request)
    {
//        if (Gate::denies('evaluation_create')) {
//            return abort(401);
//        }

        $evaluation = Evaluation::create($request->all());
        
        

        return (new EvaluationResource($evaluation))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateEvaluationsRequest $request, $id)
    {
        if (Gate::denies('evaluation_edit')) {
            return abort(401);
        }

        $evaluation = Evaluation::findOrFail($id);
        $evaluation->update($request->all());
        
        
        

        return (new EvaluationResource($evaluation))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('evaluation_delete')) {
            return abort(401);
        }

        $evaluation = Evaluation::findOrFail($id);
        $evaluation->delete();

        return response(null, 204);
    }
}
