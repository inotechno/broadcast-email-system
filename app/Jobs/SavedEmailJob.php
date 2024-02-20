<?php

namespace App\Jobs;

use App\Events\EmailSaved;
use App\Events\EmailSavedEvent;
use App\Models\Subscriber;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SavedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Validasi email sebelum melakukan operasi lainnya
        if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            // Email tidak valid, mungkin log atau lakukan tindakan sesuai kebutuhan Anda
            \Log::error('Invalid email address: ' . $this->data['email']);
            return; // Stop eksekusi jika email tidak valid
        }

        $existingEmail = Subscriber::where('email', $this->data['email'])->first();
        // dd($existingEmail);
        if ($existingEmail) {

            // Identify new categories that are not already associated with the subscriber
            $newCategories = array_filter($this->data['categories'], function ($categoryId) use ($existingEmail) {
                return !$existingEmail->categories->contains('id', $categoryId);
            });

            // Log or debug the contents of newCategories before any modification
            \Log::info('New categories before checking:', $newCategories);

            // Add new categories without detaching existing ones
            $existingEmail->categories()->syncWithoutDetaching($newCategories);
        } else {
            // Simpan informasi email, nama, dan nomor telepon ke database
            $uid = Str::random(15);
            $Subscriber = Subscriber::create([
                'uuid' => $uid,
                'email' => $this->data['email'],
                'name' => $this->data['name'] ?? null,
                'phone_number' => $this->data['phone_number'] ?? null,
            ]);

            $Subscriber->categories()->syncWithoutDetaching($this->data['categories']);
        }

        // event(new EmailSavedEvent($Subscriber->email, $Subscriber->name, $Subscriber->phone_number));
    }
}
