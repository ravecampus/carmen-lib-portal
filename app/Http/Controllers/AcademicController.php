<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academic;

class AcademicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['subject', 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $filter = $request->filter;
        $searchValue = $request->search;
        
            $query = Academic::with('academic_book')->orderBy($columns[$column], $dir);
       
            
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('subject', 'like', '%'.$searchValue.'%');
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
            'subject' => 'string|required',
            ]);

        $book = Academic::create([
            'subject' => $request->subject,
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
            'subject' => 'string|required',
            ]);

        $book = Academic::find($id);
        $book->subject = $request->subject;
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
        //
    }
}
