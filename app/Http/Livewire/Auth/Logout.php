<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Logout extends Component
{
    use LivewireAlert;
    public function logout()
    {
        Auth::logout();
        $this->alert('success', 'Logout berhasil, terima kasih sudah memakai aplikasi MMS.');

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
