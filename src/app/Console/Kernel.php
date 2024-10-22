<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // メール認証がされていないユーザーを削除
        $schedule->call(function() {
            $expired_users = User::whereNull('name')
            ->where('created_at', '<', Carbon::now()->subMinutes(60))
            ->delete();
        })->everyMinute();

        // 予約時間を過ぎたら評価入力フォームを表示
        $schedule->call(funvction() {

        })->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
