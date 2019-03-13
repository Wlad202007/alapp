<?php

namespace App\Http\Controllers\Api\V1;

use App\Industry;
use App\Http\Controllers\Controller;
use App\Http\Resources\Industry as IndustryResource;
use App\Http\Requests\Admin\StoreIndustriesRequest;
use App\Http\Requests\Admin\UpdateIndustriesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class IndustriesController extends Controller
{
    public function index()
    {
        

        return new IndustryResource(Industry::with([])->get());
    }

    public function show($id)
    {
        if (Gate::denies('industry_view')) {
            return abort(401);
        }

        $industry = Industry::with([])->findOrFail($id);

        return new IndustryResource($industry);
    }

    public function store(StoreIndustriesRequest $request)
    {
        if (Gate::denies('industry_create')) {
            return abort(401);
        }

        $industry = Industry::create($request->all());
        
        

        return (new IndustryResource($industry))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateIndustriesRequest $request, $id)
    {
        if (Gate::denies('industry_edit')) {
            return abort(401);
        }

        $industry = Industry::findOrFail($id);
        $industry->update($request->all());
        
        
        

        return (new IndustryResource($industry))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('industry_delete')) {
            return abort(401);
        }

        $industry = Industry::findOrFail($id);
        $industry->delete();

        return response(null, 204);
    }
}
