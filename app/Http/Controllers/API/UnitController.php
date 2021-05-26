<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return UnitResource::collection(Unit::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUnitRequest $request
     * @return UnitResource
     */
    public function store(StoreUnitRequest $request)
    {
        return UnitResource::make($request->presist());
    }



    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUnitRequest $request
     * @param int $id
     * @return UnitResource
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        return UnitResource::make($request->presist($unit));
    }


    public function show(Unit $unit)
    {
        return UnitResource::make($unit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
    }
}
