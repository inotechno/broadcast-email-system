<?php

namespace App\Console\Commands;

use App\Jobs\SendEmail;
use App\Jobs\SendScheduledEmail;
use App\Models\Campaign;
use App\Models\EmailLog;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckScheduledEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:check-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for scheduled emails to send';

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

            // Pilih campaign yang jadwal mulainya sudah tiba dan belum berhenti
            $campaigns = Campaign::with('categories.subscribers')
                ->where('executed', false)
                ->where('start_send_at', '<=', $currentDateTime)
                ->where('status', 'active')
                ->get();

            foreach ($campaigns as $campaign) {

                $initialDate = $campaign->start_send_at;

                foreach ($campaign->categories as $category) {
                    $subscribers =  $category->subscribers->where('active', 1);

                    // Bagi pengikut menjadi 3000 per hari
                    $subscribersChunks = $subscribers->chunk(3000);

                    $date = $initialDate;
                    foreach ($subscribersChunks as $subscribersChunk) {

                        foreach ($subscribersChunk as $subscriber) {
                            // SendEmail::dispatch($subscriber->email, $campaign->subject, $campaign->message, $campaign->from_email)->delay($delay);

                            EmailLog::create([
                                'campaign_id' => $campaign->id,
                                'recipient' => $subscriber->email,
                                'subject' => $campaign->subject,
                                'message' => $campaign->message,
                                'send_at' => $date,
                                'status' => 'pending' // Awalnya diatur pending ke queued, ubah menjadi sent atau failed dalam pekerjaan
                            ]);

                            $campaign->update(['executed' => true]);
                            // Log::alert("Update: " . $update);
                        }

                        // Tambah satu hari ke tanggal setelah selesai mengirim 3000 pengikut
                        $date = Carbon::parse($date)->addDay();
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::alert("Error in process campaign emails: " . $th->getMessage());
        }
    }
}
