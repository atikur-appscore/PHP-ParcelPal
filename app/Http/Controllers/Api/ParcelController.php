<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Parcel;
use App\Services\Contracts\ParcelService;

class ParcelController extends ApiController
{
    protected $dataSelect = ['id','id as identifier','parcel_id','run_id','recipient_name','address','type','weight','delivery_instructions','priority', 'user_id'];

    public function __construct(Parcel $parcel)
    {
        parent::__construct($parcel);
    }

    public function lists($item = null)
    {
        $item = $this->repository->where('user_id', $this->user->id)->get($this->dataSelect);
        parent::lists($item);
        return response()->json([
            'success' => true,
            'data' => [
                'parcels' => $this->items
            ]
        ]);
    }

    public function add(Request $request, ParcelService $service)
    {
        $data = $request->only('parcel');
        $rules = [
            'recipient_name' => 'required|min:2|max:255',
            'parcel_id' => 'required|min:2|max:255|unique:parcels',
            'run_id' => 'required|numeric',
            'address' => 'required|min:2',
            'weight' => 'required|numeric',
            'type' => 'required',
            'priority' => 'required',
        ];

        return $this->storeData($rules, $data['parcel'], $service);
    }

    // public function update(Request $request, ParcelService $service)
    // {   
    //     $data = $request->only('parcel');
    //     $rules = [
    //         'delivered' => 'required'
    //     ];

    //     return $this->updateData($rules, $data['parcel'], $service, $data['parcel']['identifier']);
    // }

    public function update(Request $request, ParcelService $service)
    {
        $data = $request->only('parcel');
        $validator = \Validator::make($data, [
            'parcel.identifier' => 'required',
            'parcel.delivered' => 'required',
            'parcel.damage' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator_fails_' . $this->repositoryName,'error' => $validator->errors()->all()], 401);
        }
        try {
            $entity = $this->repository->findOrFail($data['parcel']['identifier']);
            $service->delivered($entity, $data['parcel']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'not_delivered_' . $this->repositoryName], 401);
        }
        
        return response()->json(['success' => true]);
    }

    public function rearrange(Request $request, ParcelService $service)
    {
        $data = $request->only('parcels','run');
        $validator = \Validator::make($data, [
            'parcels.*.identifier' => 'required',
            'parcels.*.priority' => 'required',
            'run.distance' => 'required',
            'run.calculated' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator_fails_' . $this->repositoryName,'error' => $validator->errors()->all()], 401);
        }
        try {
            $service->rearrange($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'not_rearrange_' . $this->repositoryName], 401);
        }
        
        return response()->json(['success' => true]);
    }

    public function delivered(Request $request, ParcelService $service)
    {
        $data = $request->only('parcel');
        $validator = \Validator::make($data, [
            'parcel.identifier' => 'required',
            'parcel.delivered' => 'required',
            'parcel.damage' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator_fails_' . $this->repositoryName,'error' => $validator->errors()->all()], 401);
        }
        try {
            $entity = $this->repository->findOrFail($data['parcel']['identifier']);
            $service->delivered($entity, $data['parcel']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'not_delivered_' . $this->repositoryName], 401);
        }
        
        return response()->json(['success' => true]);
    }

    public function detail(Request $request)
    {
        parent::detail($request);

        return response()->json([
            'success' => true,
            'data' => [
                'parcel' => $this->item
            ]
        ]);
    }

    public function delete(Request $request, ParcelService $service)
    {
        return $this->deleteData($service, $request->parcel['identifier']);
    }

}
