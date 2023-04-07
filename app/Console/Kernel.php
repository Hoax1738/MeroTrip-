<?php

namespace App\Console;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;
use App\Packages;
use App\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            $commitments=DB::table('commits')
            ->select('*','commits.id as id')
            ->join('commence_dates', 'commits.commence_date_id', '=', 'commence_dates.id')
            ->join('packages', 'commence_dates.package_id', '=', 'packages.id')
            ->where('status','active')
            ->where('next_pay_date','<',date('Y-m-d', strtotime(date('Y-m-d'). ' + 8 days')))
            ->get();

            foreach($commitments as $commit){
                $userInfo=User::find($commit->user_id);
                $last_paid =User::lastPaid($commit->id,$userInfo->id,'job'); // because auth can't be taken by cron job
                $remaining=$commit->price_per_traveller*$commit->travellers - $commit->total_paid;
                if(isset($last_paid->due) && $remaining>0){
                    $futureemi=Packages::futureEMI($remaining,$last_paid->due, $commit->commence_date);
                    $exp = strtotime($commit->next_pay_date);
                    $td= strtotime(date('Y-m-d'));
                    $diff=$exp-$td;
                    $dateDiffDays=($diff/(60*60*24));
                    if($dateDiffDays==7||$dateDiffDays==4||$dateDiffDays==2||$dateDiffDays==1||$dateDiffDays==0||$dateDiffDays<0){
                        $user=[
                        'title'=>$commit->title,
                        'payment_amount'=>$futureemi[0][1],
                        'next_pay_date'=>$commit->next_pay_date,
                        'due_date'=>$dateDiffDays,
                        'name'=>$userInfo->name,
                        ];
                        Mail::to($userInfo->email)->send(new SendMail($user,'payment-notification'));
                    }
                }
            }
        })->dailyAt('7:00')->timezone('Asia/Kathmandu')->emailOutputOnFailure('workpemba@gmail.com');

        $schedule->call(function(){
            $compress=Image::where('drive_id',null)
                ->where('compressed',0)
                ->limit(2)
                ->get();

            foreach($compress as $row){
                if((strpos($row->local_filename,'.jpg')!==false)||(strpos($row->local_filename,'.jpeg')!==false)){
                    $output = exec('cd /home/tripkhata/public_html/public/'.$row->directory.' && jpegoptim --size=250KB '.$row->local_filename);
                    if($output){
                        $row->update([
                            'compressed'=>1
                        ]);
                    }
                }elseif(strpos($row->local_filename,'.png')!==false){
                    $output=exec('cd /home/tripkhata/public_html/public/'.$row->directory.' && pngquant '.$row->local_filename.' --ext .png --force');
                    if($output==""){
                        $row->update([
                            'compressed'=>1
                        ]);
                    }
                }
            }

            $aftercompress=Image::where('drive_id',null)
                ->where('compressed',1)
                ->inRandomOrder()
                ->limit(2)
                ->get();

            foreach($aftercompress as $info){
                $url=url("$info->directory/$info->local_filename");
                $image='https://script.google.com/macros/s/AKfycbwlgFKM2dH16qyYXRq_qsAJ-cCl-_UYqGygQnLS1XxcvdHG4JKkW9yrUfZ6Gm879G7gtw/exec?url='.asset($url);
                $response=Http::get($image);
                if($response){
                    $photos=$response->body();
                    $images=Image::where('id',$info->id)->update(['drive_id'=>$photos]);
                    if(file_exists(public_path("$info->directory/$info->local_filename"))){
                        unlink(public_path("$info->directory/$info->local_filename"));
                    }
                }else{
                    echo "Something went wrong";
                }
            }

        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
