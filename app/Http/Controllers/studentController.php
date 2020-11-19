<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class studentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|View|int
     */
    public function show($id)
    {
        //fetch student name
        $user = DB::table('users')
            ->join('teams','teams.id','=','users.current_team_id')
            ->where('users.id','=',$id)
            ->select('users.name','teams.name as team')
            ->get();

        //fetch student evaluation
        $evaluations = DB::table('evaluations')
            ->join('users','users.id','=','evaluations.user_id')
            ->where('evaluations.team_id','=',$id)
            ->where('evaluations.isSubmit','=','1')
            ->select('users.name','evaluations.rate','evaluations.description')
            ->get();

        if($evaluations == '[]'){
            return redirect('/dashboard');
        }

        return View('student.index')
            ->with('result',$evaluations)
            ->with('user',$user);
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
        //
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
