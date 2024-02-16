<?php

namespace App\Http\Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;
use Spatie\Permission\Models\Role;

// use Spatie\Menu;

class Sidebar extends Component
{
    public $menus = [];

    public function mount()
    {
        $this->menus = config('menu.administrator');
    }

    public function render()
    {
        // dd($this->menus);
        return view('livewire.component.sidebar');
    }
}
