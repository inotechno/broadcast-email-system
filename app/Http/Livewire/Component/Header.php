<?php

namespace App\Http\Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public $user;
    public $name;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
    }

    public function render()
    {
        return view('livewire.component.header');
    }
}
