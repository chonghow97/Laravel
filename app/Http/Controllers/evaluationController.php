<?php

namespace App\Http\Controllers;

use App\Models\evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        try {
            $result =   DB::table('users')
            ->leftJoin('evaluations','users.id','=','evaluations.team_id')
                ->where("evaluations.user_id","=",auth()->user()["id"])
            ->whereRaw('users.current_team_id = '.auth()->user()->currentTeam->id, [0]) //same team
            ->whereRaw('users.id != '.auth()->user()["id"], [0]) //filter user its  elf
            ->whereRaw('users.id != 1', [0]) //filter admin
            ->select("users.id")
            ->get();
        } finally{
            if($result == "[]"){
                $result =   DB::table('users')
                ->whereRaw('users.current_team_id = '.auth()->user()->currentTeam->id, [0]) //same team
                ->whereRaw('users.id != '.auth()->user()["id"], [0]) //filter user its self
                ->whereRaw('users.id != 1', [0]) //filter admin
                ->select('users.id','users.name')
                ->get();
            }else{
                $store = $result[0]->id;
                $result =   DB::table('users')
                            ->whereRaw('users.id != '.auth()->user()["id"], [0]) //filter user its  elf
                            ->whereRaw('users.current_team_id = '.auth()->user()->currentTeam->id, [0]) //same team
                            ->whereRaw('users.id != 1', [0]) //filter admin
                            ->whereRaw('users.id != '.$store, [0]) //filter admin
                            ->select('users.id','users.name','users.current_team_id')
                            ->get();
            }
        }
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
            ->select('evaluations.description','users.name','evaluations.rate','evaluations.isSubmit','evaluations.team_id','evaluations.id')
            ->whereRaw('evaluations.id = '.$id, [0])
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
        $evaluate = Evaluation::find($id);
        $evaluate->description = $request->comment;
        $evaluate->isSubmit = $request->isSubmit;
        $evaluate->rate = $request->rating;
        $evaluate->save();
        return redirect('/dashboard');
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
