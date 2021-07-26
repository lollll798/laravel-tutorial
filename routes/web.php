<?php

use App\Http\Controllers\CustomizeLogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Pipeline\Pipeline;
use App\Jobs\TestJob;
use App\Models\User;
use App\Jobs\TestPipelineJob;
use App\UseCases\Facades\Postcard;
use App\UseCases\Facades\PostcardSendingService;
use Spatie\Async\Pool;

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
    $user = User::inRandomOrder()->first();
    TestJob::dispatch($user)->onQueue('high-user');
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

Route::get('/customizeLog', 'CustomizeLogController@customizeLog');


Route::group(['prefix' => 'facades' ], function ()
{
    Route::get('/original-postcards', function () {
        $postcardService = new PostcardSendingService('us', 4, 6);
        $postcardService->hello('This is original postcards function', env('SUPPORT_MAIL'));
    });

    Route::get('/using-facades', function () {
        Postcard::hello('This is from facade call', env('SUPPORT_MAIL'));
    });
});

Route::get('async-test', function() {
    $pool = Pool::create()
    // The maximum amount of processes which can run simultaneously.
        ->concurrency(20)

    // The maximum amount of time a process may take to finish in seconds
    // (decimal places are supported for more granular timeouts).
        ->timeout(15)

    // Configure how long the loop should sleep before re-checking the process statuses in microseconds.
        ->sleepTime(50000);

    for ($i=0; $i < 5; $i++) {
        $pool->add(function () use ($i) {
            dump($i.': do something');
            $string = 'hallo count'.($i+1);
            return compact('string', 'i');
        })->then(function ($output) use ($pool) {
            dump($output['i'].': '.'output: '.$output['i']);
        })->catch(function (Throwable $exception) use ($i) {
            dump($i.': '.'Exception');
        })->timeout(function () use ($i) {
            // Ohh No! A process took too long to finish. Let's do something
            dump($i.': '.'Timeout');
            return 'hallo count'.($i+1);
        });
    }
    dump('Before Pull Wait');
    $pool->wait();
    dump('After Pull Wait');
});
