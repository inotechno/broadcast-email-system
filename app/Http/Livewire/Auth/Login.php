<?php

namespace App\Http\Livewire\Auth;

use App\Actions\Login as ActionsLogin;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Login extends Component
{
    use LivewireAlert;
    public $email;
    public $password;
    public $remember_me;

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'remember_me' => 'nullable'
        ];
    }

    public function _login()
    {
        // dd($this);
        $this->emit('loading', true);
        $validate = $this->validate();

        try {
            $user = User::where('email', $this->email)->first();
            // dd($user);
            if ($user) {
                $action = new ActionsLogin();
                $login = $action->handle($validate);
                // dd($login);
                if ($login) {
                    // $this->emit('sessionRegenerated', csrf_token());
                    $this->alert('success', 'Selamat datang di aplikasi ' . config('app_name'));
                    return redirect()->route('dashboard');
                } else {
                    $this->alert('error', 'Email atau password yang anda gunakan salah, silahkan periksa kembali!');
                    $this->emit('loading', false);
                }
                // dd($user);
            } else {
                $this->alert('error', 'Email tidak terdaftar, silahkan registrasi terlebih dahulu!');
                $this->emit('loading', false);
            }
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
            $this->emit('loading', false);
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.default', ['title' => 'Login']);
    }
}
