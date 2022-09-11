<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Models\City;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use ApiResponser;

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
            $city = $this->useExternalSrc ? City::getFromExternal($id) : City::find($id);

            if (empty($city)) {
                return $this->error('Not found', 404);
            }

            return $this->success($city);
        }

        return $this->success($this->useExternalSrc ? City::getFromExternal() : City::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityRequest $request)
    {
        $city = City::create($request->validated());

        return $this->success($city, 'Created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return $this->success($city);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
