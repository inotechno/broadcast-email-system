<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailCampaign extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $files;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content, $files = [])
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {

            $mail = $this->subject($this->subject)->view('emails.dynamic-email');

            // \Log::alert($this->files);
            if (!empty($this->files)) {
                foreach ($this->files as $index => $file) {
                    $fileName = $file['name'];
                    $fileMime = strval($file['mime']);

                    // \Log::info('file Information:');
                    // \Log::info('Name: ' . json_encode($fileName));

                    $mail->attachFromStorageDisk('gcs', $file['url'], $fileName, [
                        'mime' => is_array($fileMime) ? 'application/octet-stream' : $fileMime, // Pilih tipe MIME atau gunakan default jika array
                    ]);
                    // $mail->attach($file['url'], [
                    //     'as' => $fileName, // Nama file pada file
                    //     'mime' => is_array($fileMime) ? 'application/octet-stream' : $fileMime, // Pilih tipe MIME atau gunakan default jika array
                    // ]);

                    // \Log::info(json_encode($mail));

                    // \Log::info('Mime: ' . json_encode($fileMime));
                }
            }

            return $mail;
        } catch (\Throwable $th) {
            \Log::alert($th->getMessage());
        }
    }
}
