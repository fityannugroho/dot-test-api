<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponser
{
	/**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
	protected function success($data, string $message = 'OK', int $code = 200)
	{
		return response()->json([
			'status' => 'success',
            'status_code' => $code,
			'message' => $message,
			'data' => $data
		], $code);
	}

	/**
     * Return an error JSON response.
     *
     * @param  string|array  $message
     * @param  int  $code
     * @return \Illuminate\Http\JsonResponse
     */
	protected function error($message = 'Internal Server Error', int $code = 500)
	{
		return response()->json([
			'status' => 'error',
            'status_code' => $code,
			'message' => $message,
		], $code);
	}

}
