<?php

namespace App\Http\Controllers\Api\V1;

use App\Sponsor;
use App\Http\Controllers\Controller;
use App\Http\Resources\Sponsor as SponsorResource;
use App\Http\Requests\Admin\StoreSponsorsRequest;
use App\Http\Requests\Admin\UpdateSponsorsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Traits\FileUploadTrait;


class SponsorsController extends Controller
{
    public function index()
    {
        

        return new SponsorResource(Sponsor::with([])->get());
    }

	 public function indexEvent($event)
    {
		//DB::connection()->enableQueryLog();
        $sponsors = Sponsor::ofEvent($event)->orderBy('name','asc')->get();
		//$query1 = DB::getQueryLog();
		//dd($sponsors,$query1);
        return new SponsorResource($sponsors);
    }

	
    public function show($id)
    {
        if (Gate::denies('sponsor_view')) {
            return abort(401);
        }

        $sponsor = Sponsor::with([])->findOrFail($id);

        return new SponsorResource($sponsor);
    }

    public function store(StoreSponsorsRequest $request)
    {
        if (Gate::denies('sponsor_create')) {
            return abort(401);
        }

        $sponsor = Sponsor::create($request->all());
        
        if ($request->hasFile('logo')) {
            $sponsor->addMedia($request->file('logo'))->toMediaCollection('logo');
        }

        return (new SponsorResource($sponsor))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateSponsorsRequest $request, $id)
    {
        if (Gate::denies('sponsor_edit')) {
            return abort(401);
        }

        $sponsor = Sponsor::findOrFail($id);
        $sponsor->update($request->all());
        
        if (! $request->input('logo') && $sponsor->getFirstMedia('logo')) {
            $sponsor->getFirstMedia('logo')->delete();
        }
        if ($request->hasFile('logo')) {
            $sponsor->addMedia($request->file('logo'))->toMediaCollection('logo');
        }

        return (new SponsorResource($sponsor))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('sponsor_delete')) {
            return abort(401);
        }

        $sponsor = Sponsor::findOrFail($id);
        $sponsor->delete();

        return response(null, 204);
    }
}
