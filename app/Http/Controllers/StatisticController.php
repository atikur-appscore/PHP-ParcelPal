<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Run;
use DB;

class StatisticController extends Controller
{
    public function dashboard()
    {
        $total_admin = User::select(DB::raw('count(id) as `total_admin`'))->where('type_id', 2)->where('is_delete', 0)->get();
        $total_user = User::select(DB::raw('count(id) as `total_user`'))->where('type_id', 0)->where('is_delete', 0)->get();

        $data = [
            'total_admin' => $total_admin[0]['total_admin'],
            'total_user' => $total_user[0]['total_user'],
            'total_chat' => Run::count()
        ];
        return response()->json(['data' => $data], 200);
    }
}
