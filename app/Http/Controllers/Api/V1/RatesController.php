<?php

namespace App\Http\Controllers\Api\V1;

use App\Rate;
use App\Http\Controllers\Controller;
use App\Http\Resources\Rate as RateResource;
use App\Http\Requests\Admin\StoreRatesRequest;
use App\Http\Requests\Admin\UpdateRatesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class RatesController extends Controller
{
    public function index()
    {
        

        return new RateResource(Rate::with(['session', 'author'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('rate_view')) {
            return abort(401);
        }

        $rate = Rate::with(['session', 'author'])->findOrFail($id);

        return new RateResource($rate);
    }

    public function store(StoreRatesRequest $request)
    {
//        if (Gate::denies('rate_create')) {
//            return abort(401);
//        }

        $rate = Rate::firstOrCreate($request->all());

        return (new RateResource($rate))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateRatesRequest $request, $id)
    {
        if (Gate::denies('rate_edit')) {
            return abort(401);
        }

        $rate = Rate::findOrFail($id);
        $rate->update($request->all());
        
        
        

        return (new RateResource($rate))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('rate_delete')) {
            return abort(401);
        }

        $rate = Rate::findOrFail($id);
        $rate->delete();

        return response(null, 204);
    }
}
