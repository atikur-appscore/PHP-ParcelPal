<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Contracts\OfflineService;

class OfflineController extends ApiController
{
    public function update(Request $request, OfflineService $service)
    {
    	$data = $request->only('runs','parcels','favourites');
    	$validator = \Validator::make($data, [
            'runs.*.title' => "required|min:2|max:255",
	        'runs.*.date' => 'required',
	        'runs.*.start_location' => 'required',
	        'runs.*.end_location' => 'required',
	        'runs.*.distance' => 'required|numeric',
            'favourites.*.name' => 'required',
            'favourites.*.street_number' => 'required',
            'favourites.*.street_name' => 'required',
            'favourites.*.suburb' => 'required',
            'favourites.*.state' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator_fails_offline','error' => $validator->errors()->all()], 401);
        }
    	try {
    		$service->offline($data);
    	} catch (\Exception $e) {
    		return response()->json(['status' => 'not_update_offline','error' => $e->getMessage()], 401);
    	}

    	return response()->json(['success' => true]);
    }
}
