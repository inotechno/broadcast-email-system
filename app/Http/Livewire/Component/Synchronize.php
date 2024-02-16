<?php

namespace App\Http\Livewire\Component;

use App\Jobs\Synchronization;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Synchronize extends Component
{
    use LivewireAlert;
    protected $url = 'http://dev-hris.tpm-facility.com/api/';

    public function sync()
    {
        // $Mroles = Http::get($this->url . 'users/list');
        // $site_names = Http::get($this->url . 'sitesname/list');
        // $sites = Http::get($this->url . 'sites/list');
        // $users = Http::get($this->url . 'users/list');

        // $jsonFilePath = storage_path('app/users.json');
        // file_put_contents($jsonFilePath, json_encode($users->json(), JSON_PRETTY_PRINT));
        // dd($users->json());

        try {
            Synchronization::dispatch($this->url);
            $this->alert('success', 'Added group successfully');
        } catch (\Throwable $th) {
            $this->alert('success', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.component.synchronize');
    }
}
