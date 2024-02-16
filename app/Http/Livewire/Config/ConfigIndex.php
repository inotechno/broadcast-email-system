<?php

namespace App\Http\Livewire\Config;

use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Swift_Mailer;
use Swift_SmtpTransport;

class ConfigIndex extends Component
{
    use LivewireAlert;

    public $app_name,
        $app_url,
        $mail_mailer,
        $mail_host,
        $mail_port,
        $mail_username,
        $mail_password,
        $mail_encryption,
        $mail_from_address,
        $mail_from_name;

    protected $rules = [
        'app_name' => 'required',
        'app_url' => 'required',
        'mail_mailer' => 'required',
        'mail_host' => 'required',
        'mail_port' => 'required',
        'mail_username' => 'required',
        'mail_password' => 'required',
        'mail_encryption' => 'required',
        'mail_from_address' => 'required',
        'mail_from_name' => 'required'
    ];

    public function mount()
    {
        $this->app_name = env('APP_NAME');
        $this->app_url = env('APP_URL');
        $this->mail_mailer = env('MAIL_MAILER');
        $this->mail_host = env('MAIL_HOST');
        $this->mail_port = env('MAIL_PORT');
        $this->mail_username = env('MAIL_USERNAME');
        $this->mail_password = env('MAIL_PASSWORD');
        $this->mail_encryption = env('MAIL_ENCRYPTION');
        $this->mail_from_address = env('MAIL_FROM_ADDRESS');
        $this->mail_from_name = env('MAIL_FROM_NAME');
    }

    public function save()
    {
        $this->validate();

        try {
            $env = DotenvEditor::load();
            $env->setKey('APP_NAME', $this->app_name);
            $env->setKey('APP_URL', $this->app_url);
            $env->setKey('MAIL_MAILER', $this->mail_mailer);
            $env->setKey('MAIL_HOST', $this->mail_host);
            $env->setKey('MAIL_PORT', $this->mail_port);
            $env->setKey('MAIL_USERNAME', $this->mail_username);
            $env->setKey('MAIL_PASSWORD', $this->mail_password);
            $env->setKey('MAIL_ENCRYPTION', $this->mail_encryption);
            $env->setKey('MAIL_FROM_ADDRESS', $this->mail_from_address);
            $env->setKey('MAIL_FROM_NAME', $this->mail_from_name);

            $env->save();

            Artisan::call('optimize:clear');
            $this->alert('success', 'Configuration updated successfully, Please Login Again!');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
            //throw $th;
        }
    }

    public function testEmailConnection()
    {
        try {
            // Buat transport SMTP
            $transport = (new Swift_SmtpTransport($this->mail_host, $this->mail_port))
                ->setUsername($this->mail_username)
                ->setPassword($this->mail_password)
                ->setEncryption($this->mail_encryption);

            // Buat instance Swift Mailer dengan transport yang telah dibuat
            $mailer = new Swift_Mailer($transport);

            // Kirim email kosong untuk memeriksa koneksi
            $mailer->send(
                (new \Swift_Message('Test Email Connection'))
                    ->setFrom([$this->mail_from_address => $this->mail_from_name])
                    ->setTo($this->mail_username)->setBody('This is a test email body')
            );

            $this->alert('success', 'Email connection test successful!');
        } catch (\Exception $e) {
            $this->alert('error', 'Email connection test failed. Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.config.config-index')->layout('layouts.app', ['title' => 'Config Application']);
    }
}
