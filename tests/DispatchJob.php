<?php

use Carbon\Carbon;
use App\Jobs\SendEmail;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DispatchJob extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_dispatch_job()
    {
        $row = ['email' => 'test1@gmail.com, test2@gmail.com, test3@gmail.com'];
        $emailJob = (new SendEmail($row))->delay(Carbon::now()->addMinutes(1));
        dispatch($emailJob);
        $this->expectsJobs($emailJob);
    }
}
