<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLog;
use App\Models\NumLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['first_name','last_name','contact_number','created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $filter = $request->filter;
        $searchValue = $request->search;
        
        $query = User::where("role", 3)->orderBy($columns[$column], $dir);
       
            
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('first_name', 'like', '%'.$searchValue.'%')
                ->orWhere('last_name', 'like', '%'.$searchValue.'%');
            });
        }
       
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            //'contact_number' => 'required|regex:/(09)[0-9]{9}/',
            ]);

        $book = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
          //  'contact_number' => $request->contact_number,
            'role' => 3,
        ]);

        return response()->json($book, 200);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            // 'contact_number' => 'required|regex:/(09)[0-9]{9}/',
        ]);
        $book = User::find($id);
        $book->first_name = $request->first_name;
        $book->last_name = $request->last_name;
        // $book->contact_number = $request->contact_number;
        $book->save();

        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = User::find($id);
        $book->delete();
        return response()->json($book, 200);
    }

    public function setAccount(Request $request){
        $request->validate([
            'email' => 'required|string|email|unique:users,email,'.$request->id,
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::find($request->id);
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json($user, 200);
    }

    public function reportUser(Request $request){

        $columns = ['first_name','last_name','contact_number','created_at'];
        $length = $request->length;
        $column = $request->column;
        $datea = $request->datedata;
        $dir = $request->dir;
        $filter = $request->filter;
        $searchValue = $request->search;

        // dd($request);
        $dated = Carbon::parse($datea)->format('Y-m-d');

        if(is_null($filter) && $filter == null){
            //  return  $date;
            $query = UserLog::select('users.*', 'user_log.log', 'user_log.date')
                ->join('users', 'users.id','=', 'user_log.user_id')
                ->where("users.role","!=", 3)
                // ->where("user_log.log",">", 0)
                ->where('user_log.date', $dated)->orderBy('users.'.$columns[$column], $dir);
        }else{
            // return "hello";
            $query = UserLog::select('users.*', 'user_log.log', 'user_log.date')
                ->join('users', 'users.id','=', 'user_log.user_id')
                ->where("users.role","!=", 3)
                ->where('users.role', $filter)
                ->where('user_log.date',$dated )->orderBy('users.'.$columns[$column], $dir);
            }
       
            
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('users.first_name', 'like', '%'.$searchValue.'%')
                ->orWhere('users.last_name', 'like', '%'.$searchValue.'%');
            });
        }
       
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    public function userList(){
        $user = User::all();
        return response()->json($user, 200);
    }

    public function getNumLog(Request $request){
        $numlog = NumLog::all();
        return response()->json($numlog, 200);
    }
}
