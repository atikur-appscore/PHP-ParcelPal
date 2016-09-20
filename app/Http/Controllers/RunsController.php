<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\RunCreateRequest;
use App\Run;
use App\Parcel;

class RunsController extends Controller
{
    public function index()
    {
        try {
            $runs = Run::all();
            return response()->json(['data' => $runs], 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e, 'code' => '404'], 404);
        }
    }
    
    public function store(RunCreateRequest $request)
    {
        $run = new Run;
        $run->title = $request->title;
        $run->date = $request->date;
        $run->start_time = $request->start_time;
        $run->end_time = $request->end_time;
        $run->start_location = $request->start_location;
        $run->end_location = $request->end_location;
        $run->save();

        if (empty($run)) {
            return response()->json(['message' => 'Create run error', 'code' => '404'], 404);
        } else {
            return response()->json(['data'=> $run], 200);
        }
    }

    public function show($id)
    {
        $run = Run::find($id);
        if (empty($run)) {
            return response()->json(['message' => '404', 'code' => '404'], 404);
        } else {
            return response()->json(['data' => $run], 200);
        }
    }

    public function parcels(Request $request)
    {
        $run = Run::find($request->run_id);
        try {
            return response()->json(['data' => $run->parcels], 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e, 'code' => '404'], 404);
        }
    }
}
