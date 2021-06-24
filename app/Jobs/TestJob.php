<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Filesystem\Filesystem;

use App\Traits\Log;
use App\Models\User;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Log;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // throw new \Exception('Oops! Something went wrong!');
        $this->log('TestJob User: '.$this->user->name, 'testjob.txt');
        logger('Redis: In Jobs/TestJob User '.$this->user->name);
    }

    public function tags()
    {
        return ['account-user'];
    }
}
