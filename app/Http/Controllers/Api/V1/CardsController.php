<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Card;
use App\Http\Controllers\Controller;
use App\Http\Resources\Card as CardResource;
use App\Http\Requests\Admin\StoreCardsRequest;
use App\Http\Requests\Admin\UpdateCardsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Traits\FileUploadTrait;


class CardsController extends Controller
{

    public function my()
    {

        $notes = Card::where('author_id', \Auth::user()->id)->get();

        return new CardResource($notes);
    }


    public function index()
    {
        

        return new CardResource(Card::with(['author'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('card_view')) {
            return abort(401);
        }

        $card = Card::with(['author'])->findOrFail($id);

        return new CardResource($card);
    }

    public function store(StoreCardsRequest $request)
    {
        if (Gate::denies('card_create')) {
            return abort(401);
        }
        

        $card = Card::create($request->all());


        if($request->base64file){

            $timestamp = Carbon::now()->timestamp;
            $card->addMediaFromBase64($request->base64file) //starting method
            ->usingFileName($card->id.'-'.$timestamp.'.jpg')
                ->withCustomProperties(['mime-type' => 'image/jpeg']) //middle method
//                ->addMediaConversion('thumb')
//                ->setManipulations(['w' => 30])
                ->preservingOriginal() //middle method
                ->toMediaCollection('img');
        }


        if ($request->hasFile('img')) {
            $card->addMedia($request->file('img'))->toMediaCollection('img');
        }

        return (new CardResource($card))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCardsRequest $request, $id)
    {
        if (Gate::denies('card_edit')) {
            return abort(401);
        }

        $card = Card::findOrFail($id);
        $card->update($request->all());
        
        if (! $request->input('img') && $card->getFirstMedia('img')) {
            $card->getFirstMedia('img')->delete();
        }
        if ($request->hasFile('img')) {
            $card->addMedia($request->file('img'))->toMediaCollection('img');
        }

        return (new CardResource($card))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('card_delete')) {
            return abort(401);
        }

        $card = Card::findOrFail($id);
        $card->delete();

        return response(null, 204);
    }
}
