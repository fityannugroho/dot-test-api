<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProvinceRequest;
use App\Http\Resources\ApiCollection;
use App\Http\Resources\ApiResource;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Determine if the data is from database or external source.
     * @var bool
     */
    private bool $useExternalSrc;

    public function __construct() {
        $this->useExternalSrc = config('source.use_external');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input('id');

        if ($id) {
            $province = $this->useExternalSrc ? Province::getFromExternal($id) : Province::find($id);
            return new ApiResource($province);
        }

        return new ApiCollection($this->useExternalSrc ? Province::getFromExternal() : Province::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProvinceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProvinceRequest $request)
    {
        $province = Province::create($request->validated());

        return new ApiResource($province);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
    {
        return new ApiResource($province);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        //
    }
}
