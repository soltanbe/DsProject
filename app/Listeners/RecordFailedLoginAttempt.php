<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RecordFailedLoginAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        FailedLoginAttempt::record(
            $event->user,
            $event->credentials['username'],
            request()->ip()
        );
        DB::table('user_log')->insert(array(
            'user_id'=>1,
            'ip'=>'1',
            'last_login'=>date('Y-m-d h:i:s')
        ));

    }
}
