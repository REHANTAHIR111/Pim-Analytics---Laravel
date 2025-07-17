<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class TestCron extends Command
{
    protected $signature = 'test:cron';
    protected $description = 'Send a test email every minute using Laravel cron job';

    public function handle()
    {
        try {
            // $data = [
            //     'data' => 'Learn how to Use Cron Jobs in Laravel !',
            //     'main' => 'FOR LEARING HOW TO SEND EMAIL WITH THE USECASE OF CRONJOBS {main}',
            //     'main1' => 'FOR LEARING HOW TO SEND EMAIL WITH THE USECASE OF CRONJOBS {main1}',
            //     'data2' => 'FOR LEARING HOW TO SEND EMAIL WITH THE USECASE OF CRONJOBS {data2}',
            //     'data3' => 'FOR LEARING HOW TO SEND EMAIL WITH THE USECASE OF CRONJOBS {data3}',
            //     'data4' => 'FOR LEARING HOW TO SEND EMAIL WITH THE USECASE OF CRONJOB {data4}S'
            // ];

            // Mail::send('mail', $data, function($message) {
            //     $message->to('abdulhadirathore018@gmail.com')->subject('Learn Cron Jobs');
            // });

            // $this->info('Email sent successfully at ' . now());
            // Log::info('Cron job email sent at ' . now());

            $users = User::whereNotNull('email')->get();

            foreach ($users as $user) {
                $data = [
                    'data' => 'Learn how to Use Cron Jobs in Laravel!',
                    'main' => 'FOR LEARNING HOW TO SEND EMAIL WITH THE USE CASE OF CRONJOBS {main}',
                    'main1' => 'FOR LEARNING HOW TO SEND EMAIL WITH THE USE CASE OF CRONJOBS {main1}',
                    'data2' => 'FOR LEARNING HOW TO SEND EMAIL WITH THE USE CASE OF CRONJOBS {data2}',
                    'data3' => 'FOR LEARNING HOW TO SEND EMAIL WITH THE USE CASE OF CRONJOBS {data3}',
                    'data4' => 'FOR LEARNING HOW TO SEND EMAIL WITH THE USE CASE OF CRONJOBS {data4}'
                ];

                Mail::send('mail', $data, function ($message) use ($user) {
                    $message->to($user->email)->subject('Learn Cron Jobs');
                });
            }

        } catch (\Exception $e) {
            $this->error('Failed to send email: ' . $e->getMessage());
            Log::error('Cron job email failed: ' . $e->getMessage());
        }
    }
}
