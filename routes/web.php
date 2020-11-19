<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider wcithin a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('evaluation','App\Http\Controllers\evaluationController');
Route::resource('student','App\Http\Controllers\studentController');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();
    $team = $user->currentTeam;
    $paginate = 10;
    if($user->id === 1){
        $result = DB::table('users')
            ->where('users.id','!=','1')
            ->leftjoin('evaluations',function($join){
            $join->on('evaluations.team_id', '=', 'users.id')
            ->where('evaluations.isSubmit', '1');
        })
            ->select('users.id','users.name',DB::raw('round(AVG(evaluations.rate),0) as Average'),'users.username')
            ->groupBy('users.id','users.name')
            ->orderBy('users.username', 'asc')
            ->paginate($paginate);

        if(isset($_GET) && !empty($_GET)) {
            if(isset($_GET['search']) && !empty($_GET['search'])) {
                setcookie('Last_search', $_GET['search'], time() + (86400 * 30), "/"); // 86400 = 1 day //get by w3school
            }
            if(isset($_GET['Catergory']) && !empty($_GET['Catergory'])) {
                $result = DB::table('users')->where('users.id','!=','1')->leftjoin('evaluations',function($join){$join->on('evaluations.team_id', '=', 'users.id')->where('evaluations.isSubmit', '1');})->select('users.id','users.name',DB::raw('round(AVG(evaluations.rate),0) as Average'),'users.username')->groupBy('users.id','users.name')->orderBy('users.username', 'asc')->get();
                switch ($_GET['Catergory']) {
                    case "studentID":
                        $result = DB::table('users')->where('users.id','!=','1')->leftjoin('evaluations',function($join){$join->on('evaluations.team_id', '=', 'users.id')->where('evaluations.isSubmit', '1');})->select('users.id','users.name',DB::raw('round(AVG(evaluations.rate),0) as Average'),'users.username')->groupBy('users.id','users.name')->where('users.username','like','%'.$_GET['search'].'%')->orderBy('users.username', 'asc')->paginate($paginate);
                        break;
                    case "Average":
                        $result = DB::table('users')->where('users.id','!=','1')->leftjoin('evaluations',function($join){$join->on('evaluations.team_id', '=', 'users.id')->where('evaluations.isSubmit', '1');})->select('users.id','users.name',DB::raw('round(AVG(evaluations.rate),0) as Average'),'users.username')->groupBy('users.id','users.name')->havingRaw('round(AVG(evaluations.rate),0) = ?', [$_GET['search']])->orderBy('users.username', 'asc')->paginate($paginate);
                        break;
                    default:
                        $result = [];
                }
            }
            if(isset($_GET['Sort']) && !empty($_GET['Sort'])){
                if($_GET['Sort'] == 'desc'){
                    $result = DB::table('users')->where('users.id','!=','1')->leftjoin('evaluations',function($join){$join->on('evaluations.team_id', '=', 'users.id')->where('evaluations.isSubmit', '1');})->select('users.id','users.name',DB::raw('round(AVG(evaluations.rate),0) as Average'),'users.username')->groupBy('users.id','users.name')->orderBy('Average', 'desc')->paginate($paginate);
                }else{
                    $result = DB::table('users')->where('users.id','!=','1')->leftjoin('evaluations',function($join){$join->on('evaluations.team_id', '=', 'users.id')->where('evaluations.isSubmit', '1');})->select('users.id','users.name',DB::raw('round(AVG(evaluations.rate),0) as Average'),'users.username')->groupBy('users.id','users.name')->orderBy('Average', 'asc')->paginate($paginate);
                }
            }
        }
        return view("adminDashboard")->with('result',$result);
    }else{
        $result = DB::table('evaluations')
        ->join('users', 'users.id', '=', 'evaluations.team_id')
        ->whereRaw('user_id = '.auth()->user()["id"].'', [0])
        ->select('users.name','users.username','evaluations.id','evaluations.isSubmit')
        ->get();
        return view('dashboard',['team'=>$team,'result'=>$result]);
    }

    return $user->id;
})->name('dashboard');

Fortify::loginView(function () {
    return view('auth.login');
});

Fortify::registerView(function () {
    $users = DB::select('SELECT teams.id,teams.name,COUNT(team_user.team_id) AS Quota FROM `teams` LEFT JOIN team_user ON teams.id = team_user.team_id WHERE teams.id>1 GROUP BY teams.id');
    return view('auth.register')->with('users',$users);
});



