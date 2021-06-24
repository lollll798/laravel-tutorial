<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/queue', function () {
    // $user = User::inRandomOrder()->first();
    // TestJob::dispatch($user)->onQueue('high-user');
    $pipeline = app(Pipeline::class);
    $pipeline->send('hello bad world')
            ->through([
                function($string, $next) {
                    $string = ucwords($string);

                    return $next($string);
                },
                function($string, $next) {
                    $string = str_ireplace('bad ', '', $string);

                    return $next($string);
                },
                TestPipelineJob::class,
            ])
            ->then(function($string) {
                dump($string);
            });
    return 'Finished';
});
