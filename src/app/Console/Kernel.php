<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Reservation;
use App\Mail\ReminderMail;
use Illuminate\Support\Facades\Mail;
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

        // 予約情報のリマインダーを毎朝7時に送信
        $schedule->call(function () {
            $today = Carbon::today();
            $reservations = Reservation::where('date', $today)
            ->get();

            foreach ($reservations as $reservation) {
                Mail::to($reservation->user->email)
                    ->send(new ReminderMail($reservation));
            }
        })->dailyAt('07:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
