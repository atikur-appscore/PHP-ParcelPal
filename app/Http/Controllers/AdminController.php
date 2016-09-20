<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class AdminController extends Controller
{
    const TYPE_ID = 2;

    public function index()
    {
        $users = User::where('type_id', self::TYPE_ID)->where('is_delete', 0)->get();
        return response()->json(['data' => $users], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = \Validator::make($data, [
            'first_name' => "required|min:2|max:255",
            'last_name' => "required|min:2|max:255",
            'email' => "required|email|max:255|unique:users",
            'password' => 'required|min:6',
            'phone' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => '404','message' => $validator->errors()->first()], 404);
        }
        $user = new User;

        $user->type_id = self::TYPE_ID;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->location = $request->location;
        $user->phone = $request->phone;
        $user->save();

        return response()->json(['data'=> $user], 200);
    }

    public function show($id)
    {
        $user = User::where('id', $id)
            ->where('type_id', 2)
            ->where('is_delete', 0)
            ->first();

        if (empty($user)) {
            return response()->json(['message' => '404', 'code'=>'404'], 404);
        } else {
            return response()->json(['data' => $user], 200);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $validator = \Validator::make($data, [
            'first_name' => "required|min:2|max:255",
            'last_name' => "required|min:2|max:255",
            'email' => "required|email|max:255|unique:users,email," . $request->id,
            'password' => 'min:6',
            'phone' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => '404','message' => $validator->errors()->first()], 404);
        }
        $user = User::find($request->id);

        if (empty($user)) {
            return response()->json(['message' => '404', 'code'=> '404'], 404);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->location = $request->location;
        $user->phone = $request->phone;
        
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json(['data' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        
        if (empty($user)) {
            return response()->json(['message' => '404', 'code' => '404'], 404);
        }

        $user->delete();

        return response()->json(['data' => 1], 200);
    }
}
