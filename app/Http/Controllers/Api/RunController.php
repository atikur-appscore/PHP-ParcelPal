<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Run;
use App\Services\Contracts\RunService;

class RunController extends ApiController
{
    protected $dataSelect = ['id','id as identifier','title','date_at','start_location','end_location','distance','calculated'];

	protected $rules = [
        'title' => "required|min:2|max:255",
        'date' => 'required',
        'start_location' => 'required',
        'end_location' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'distance' => 'required|numeric'
    ];

    public function __construct(Run $run)
    {
        parent::__construct($run);
    }

    public function lists($item = null)
    {
        $item = $this->repository->where('user_id',$this->user->id)->get($this->dataSelect);
        parent::lists($item);
        return response()->json([
            'success' => true,
            'data' => [
                'runs' => $this->items->load('parcels')
            ]
        ]);
    }

    public function add(Request $request, RunService $service)
    {
        $data = $request->only('title','date','start_time','end_time','start_location','end_location','distance');
        $data['date_at'] = date($this->format, $request->date);
        $data['start_time'] = date('H:i:s', $request->start_time);
        $data['end_time'] = date('H:i:s', $request->end_time);

        return $this->storeData($this->rules, $data, $service);
    }

    public function update(Request $request, RunService $service)
    {
        $data = $request->only('title','date','start_time','end_time','start_location','end_location','distance');
        $data['date_at'] = date($this->format, $request->date);
        $data['start_time'] = date('H:i:s', $request->start_time);
        $data['end_time'] = date('H:i:s', $request->end_time);
        
        return $this->updateData($this->rules, $data, $service, $request->identifier);
    }

    public function detail(Request $request)
    {
        parent::detail($request);

        return response()->json([
            'success' => true,
            'data' => [
                'runs' => $this->item
            ]
        ]);
    }
}
