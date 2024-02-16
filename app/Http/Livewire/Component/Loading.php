<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class Loading extends Component
{
    public $show = false;

    protected $listeners = ['loading' => 'toggle'];

    public function toggle($show)
    {
        $this->show = $show;
    }

    public function render()
    {
        return view('livewire.component.loading');
    }
}
