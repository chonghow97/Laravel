<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Fortify;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Fortify::loginView(function () {
    return view('auth.login');
});

Fortify::registerView(function () {
    $users = DB::select('SELECT teams.id,teams.name,COUNT(team_user.team_id) AS Quota FROM `teams` LEFT JOIN team_user ON teams.id = team_user.team_id WHERE teams.id>1 GROUP BY teams.id');
    return view('auth.register')->with('users',$users);
});
