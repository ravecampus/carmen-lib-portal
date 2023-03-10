<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLog;
use App\Models\NumLog;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'role' => 'required',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password)
        ]);

       return response()->json($user,200);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(!Auth::attempt($credentials)):
            $errors = ['errors'=>['main' => ['Invalid Account!']]];
            return response()->json($errors,401);
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        $a = Auth::user();
        if($a->role == 0 || $a->role == 1 || $a->role == 2){
            NumLog::create([
                'user_id' => $a->id,
                'log' => 1,
                'date' => Carbon::now()->format('Y-m-d'),
            ]);
            $ulog = UserLog::where('user_id', $a->id)->where('date', Carbon::now()->format('Y-m-d'))->first();
            if(!isset($ulog)){
                UserLog::create([
                    'user_id' => $a->id,
                    'log' => 1,
                    'date' => Carbon::now()->format('Y-m-d'),
                ]);
            }
            
        }
        return response()->json($a,200);
    }

    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    public function changePassword(Request $request){
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json($user, 200);
    }

    public function updateProfile(Request $request){
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'role' => 'required',
            // 'contact_number' => 'required|regex:/(09)[0-9]{9}/',
            'email' => 'required|string|email|unique:users,email,'.Auth::id(),
        ]);

        $user = User::find(Auth::id());
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        // $user->contact_number = $request->contact_number;
        $user->grade_level = $request->grade_level;
        $user->role = $request->role;
        $user->save();

        return response()->json($user, 200);

    }
}
