<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class TrixEditor extends Component
{
    public $message;

    public function updatedMessage($value)
    {

        $this->emit('messageUpdated', $value);
    }

    public function render()
    {
        return view('livewire.component.trix-editor');
    }
}
