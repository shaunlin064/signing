<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EmailSend;
use Mail;
use DB;

/**
 * Class SendEmails
 * Email通知信件排程寄信
 * @package App\Console\Commands
 */
class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '寄出通知信件';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * Email通知信排程寄信處理頁面
     * 取得紀錄中未計送出的email通知，寄出該信件並修改狀態為已寄出
     * @throws null : 如maail寄信錯誤，則rollback並Log錯誤訊息
     * @return mixed
     */
    public function handle()
    {
        //
        $emails = EmailSend::where('status',0)->get();

        foreach($emails as $k=>$v){
            DB::beginTransaction();
            try{

                Mail::send($v['template'], json_decode($v['content'],true), function ($message) use ($v) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_NAME'));
                    $message->to($v['receiver_email'], $v['receiver_name'])->subject($v['subject']);
                });

                $v->status = 1;
                $v->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                \Log::error($ex->getMessage());
            }
        }

    }
}
