<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Mail;
use Illuminate\Foundation\Auth\ResetsPasswords;

class UserController extends Controller
{
    use ResetsPasswords;

    const USER_TYPE = 0;

    public function index()
    {
        $users = User::where('type_id', self::USER_TYPE)->where('is_delete', 0)->get();
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

        $user->type_id = self::USER_TYPE;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->birthday = $request->birthday;
        $user->gender_id = $request->gender_id;
        $user->location = $request->location;
        $user->phone = $request->phone;
        $user->description = $request->description;
        $user->save();

        if (empty($user)) {
            return response()->json(['message' => 'Create user error', 'code' => '404'], 404);
        } else {
            return response()->json(['data'=> $user], 200);
        }
    }

    public function show($id)
    {
        $row = User::where('id', $id)->where('type_id', self::USER_TYPE)->where('is_delete', 0)->first();
        
        if(!$row) {
            return response()->json(['message'=>'404', 'code'=>'404'], 404);
        }

        return response()->json(['data'=>$row], 200);
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
            return response()->json(['message'=>'404', 'code'=>'404'], 404);
        }

        $user->type_id = self::USER_TYPE;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        
        if ($request->birthday) {
            $user->birthday = $request->birthday;
        }

        $user->gender_id = $request->gender_id;
        $user->location = $request->location;
        if ($request->phone) {
            $user->phone = $request->phone;
        }
        $user->description = $request->description;
        $user->save();

        return response()->json(['data' => $user], 200);
    }

    public function destroy($id)
    {
        $row = User::where('id',$id)->first();
        if (!$row) {
            return response()->json(['message'=>'404', 'code'=>'404'], 404);
        }

        $row->delete();
        return response()->json(['data'=>1], 200);
    }

    public function login(Request $request)
    {
        $values = $request->only(['email', 'password']);
        if (\Auth::attempt($values)) {
            if (\Auth::user()->type_id != 2) {
                \Auth::user()->logout();
                return response()->json(['message'=>'404', 'code'=>'404'], 404);
            }
            return response()->json(['data'=>\Auth::user()], 200);
        }

        return response()->json(['message'=>'404', 'code'=>'404'], 404);
    }

    public function reset_password(Request $request){
        return $this->sendResetLinkEmail($request);
    }

    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        return response()->json(['message'=>'OK'], 200);
    }

    protected function getSendResetLinkEmailFailureResponse($response)
    {
        return response()->json(['message'=>'404', 'code'=>'404'], 404);
    }

    public function active($key)
    {
        $id= \Crypt::decrypt($key);
        $user = app(User::class)->find($id);
        if ($user->activate) {
            return view('activate'); //redirect('/#/login');
        }
        $user->update(['active' => true,]);

        return view('activate'); //redirect('/#/login');
        
    }
}
