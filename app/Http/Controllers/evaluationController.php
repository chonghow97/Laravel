<?php

namespace App\Http\Controllers;

use App\Models\evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;

class evaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $result =   DB::table('users')
            ->leftJoin('evaluations','users.id','=','evaluations.team_id')
            ->whereNull('evaluations.rate')
            ->whereRaw('users.current_team_id = '.auth()->user()->currentTeam->id, [0]) //same team
            ->whereRaw('users.id != '.auth()->user()["id"], [0]) //filter user its  elf
            ->whereRaw('users.id != 1', [0]) //filter admin
            ->select('users.id','users.name','evaluations.rate','evaluations.user_id')
            ->get();

        return view('evaluation.index')->with('result',$result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'comment' => 'required',
            'rating' => 'required'
        ]);

        //create evaluation
        $evaluation = new evaluation;
        $evaluation->user_id = $request->input('userID');
        $evaluation->team_id = $request->input('student');
        $evaluation->rate = $request->input('rating');
        $evaluation->description = $request->input('comment');
        $evaluation->save();
        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = DB::table('evaluations')
            ->join('users','users.id','=','evaluations.team_id')
            ->select('evaluations.description','users.name','evaluations.rate','evaluations.isSubmit','users.id')
            ->whereRaw('evaluations.team_id = '.$id, [0])
            ->get();
        return view('evaluation.show')->with('result',$result[0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return View(evaluation.edit);
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
