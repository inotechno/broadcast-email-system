<?php

namespace App\Http\Livewire;

use Dotenv\Dotenv;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Installer extends Component
{
    use LivewireAlert;

    public $step = 1;
    public $host;
    public $port;
    public $database;
    public $username;
    public $password;
    public $app_name;
    public $app_url;

    // protected $rules = [
    //     'host' => 'required_if:step,1',
    //     'port' => 'required_if:step,1|numeric',
    //     'database' => 'required_if:step,1',
    //     'username' => 'required_if:step,1',
    //     'password' => 'nullable',
    //     'app_name' => 'required_if:step,2',
    //     'app_url' => 'sometimes|required_if:step,2|url',
    // ];

    protected $messages = [
        'host.required_if' => 'The host field is required.',
        'port.required_if' => 'The port field is required.',
        'port.numeric' => 'The port must be a number.',
        'database.required_if' => 'The database field is required.',
        'username.required_if' => 'The username field is required.',
        'password.required_if' => 'The password field is required.',
        'app_name.required_if' => 'The application name field is required.',
        'app_url.required_if' => 'The application URL field is required.',
        'app_url.url' => 'The application URL must be a valid URL.',
    ];

    protected function getRules()
    {
        $rules = [
            'host' => 'required_if:step,1',
            'port' => 'required_if:step,1|numeric',
            'database' => 'required_if:step,1',
            'username' => 'required_if:step,1',
            'password' => 'nullable',
        ];

        if ($this->step === 2) {
            $rules += [
                'app_name' => 'required',
                'app_url' => 'required|url',
            ];
        }

        return $rules;
    }

    public function nextStep()
    {

        $this->validate();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function saveData()
    {
        $this->validate();
        Artisan::call('optimize');

        try {
            $this->setEnvVariables();
            $this->migrateDatabase();
            $this->alert('success', 'Installation Successfully');
            $this->reset(['step', 'host', 'port', 'database', 'username', 'password', 'app_name', 'app_url']);
            return redirect()->route('login');
        } catch (\Exception $e) {
            $this->alert('error', json_encode($e->getMessage()));
            Log::error('Installation Error: ' . $e->getMessage());
        }
    }

    private function generateAppKey()
    {
        Artisan::call('key:generate', ['--force' => true]);
    }

    private function setEnvVariables()
    {
        $env = DotenvEditor::load();
        $env->setKey('APP_ENV', 'local');
        // $env->setKey('APP_DEBUG', 'true');
        $env->setKey('APP_NAME', $this->app_name);
        $env->setKey('APP_URL', $this->app_url);
        $env->setKey('DB_HOST', $this->host);
        $env->setKey('DB_PORT', $this->port);
        $env->setKey('DB_DATABASE', $this->database);
        $env->setKey('DB_USERNAME', $this->username);
        $env->setKey('DB_PASSWORD', $this->password);
        // Memeriksa apakah 'APP_INSTALLED' sudah ada di file .env
        if (!$env->keyExists('APP_INSTALLED')) {
            // Jika tidak ada, tambahkan key 'APP_INSTALLED' dan setel nilainya menjadi true
            $env->setKey('APP_INSTALLED', 'true');
        } else {
            // Jika sudah ada, setel nilainya menjadi true
            $env->setKey('APP_INSTALLED', 'true');
        }

        $env->save();
    }

    private function migrateDatabase()
    {
        try {
            Artisan::call('optimize');
            Artisan::call('migrate:fresh', ['--seed' => true]);
        } catch (\Exception $e) {
            $this->alert('error', 'Database migration error: ' . $e->getMessage());
            Log::error('Database migration error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.installer')->layout('layouts.default', ['title' => 'Installation Step']);
    }
}
