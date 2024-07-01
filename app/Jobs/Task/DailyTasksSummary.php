<?php

namespace App\Jobs\Task;

use App\Mail\Task\TaskSummaryMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DailyTasksSummary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::withWhereHas('tasks', function ($query) {
            $query->whereDate('created_at', now()->format('Y-m-d'));
        })->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new TaskSummaryMail($user->tasks));
        }

    }
}
