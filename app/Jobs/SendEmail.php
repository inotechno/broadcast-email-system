<?php

namespace App\Jobs;

use App\Mail\MailCampaign;
use App\Models\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $subject;
    protected $content;
    protected $from;
    protected $attachments;

    public function __construct($email, $subject, $content, $from = null, $attachments = [])
    {
        if ($from == null) {
            $this->from = 'smtp';
        } else {
            $this->from = $from;
        }

        // dd($this->email);
        $this->email = $email;
        $this->subject = $subject;
        $this->content = $content;
        $this->attachments = $attachments;
    }

    public function handle()
    {
        // dd($this->from);
        try {
            $mailer = \MultiMail::from($this->from);
            $mailer->to($this->email)->send(new MailCampaign($this->subject, $this->content, $this->attachments));
            $this->updateEmailLog('sent');
        } catch (\Swift_TransportException $e) {
            \Log::info("Failed : From " . $this->from . ' ' . $e->getMessage());
            $this->updateEmailLog('failed', $this->from . ' ' . $e->getMessage());
        }
    }

    protected function updateEmailLog($status, $errorMessage = null)
    {
        // Menggunakan recipient dan subject untuk mencari log yang sesuai.
        // Asumsi bahwa kombinasi ini unik untuk setiap job. Jika tidak, Anda mungkin perlu mekanisme identifikasi yang lebih kuat.
        $log = EmailLog::where('recipient', $this->email)
            ->where('subject', $this->subject)
            ->whereIn('status', ['queued', 'failed'])
            ->first();

        if ($log) {
            if ($log->status != 'sent') {
                $log->status = $status;
                $log->error = $errorMessage;
                $log->save();
            }
        }
    }
}
