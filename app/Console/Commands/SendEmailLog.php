<?php

namespace App\Console\Commands;

use App\Models\EmailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Storage;

class SendEmailLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-email-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     *
     * @return int
     */
    public function handle()
    {
        try {
            $currentDateTime = Carbon::now();

            $emails = EmailLog::with('campaign.attachments')
                ->where('status', 'pending')
                ->where('send_at', '<=', $currentDateTime)
                ->get();

            foreach ($emails as $email) {
                $attachments = [];

                if ($email->campaign_id == 0) {
                    $from_email = 'sales@ads.rumahaplikasi.co.id';
                } else {
                    $from_email = $email->campaign->from_email;
                    $campaign_attachments = $email->campaign->attachments;
                    foreach ($campaign_attachments as $index => $attachment) {
                        $attachments[$index]['url'] = $attachment->file_url;
                        $attachments[$index]['name'] = $attachment->file_name;
                        $attachments[$index]['mime'] = $attachment->file_mime;
                    }
                }

                SendEmail::dispatch($email->recipient, $email->subject, $email->message, $from_email, $attachments);
                $email->update(['status' => 'queued']);
                // Log::alert("Update: " . $update);
            }
        } catch (\Throwable $th) {
            Log::alert("Error in sending campaign emails: " . $th->getMessage());
        }
    }
}
