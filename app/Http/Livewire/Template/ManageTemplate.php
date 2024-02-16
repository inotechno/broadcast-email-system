<?php

namespace App\Http\Livewire\Template;

use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ManageTemplate extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $editMode = false;
    public $deleteMode = false;
    public $limit = 12;
    public $search = null;
    public $template_id, $template;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function getTemplate($id)
    {
        $this->template_id = $id;
        $this->template = Template::find($id);
    }

    public function resetInputFields()
    {
        $this->template = '';
        $this->template_id = '';
    }

    public function changeDefault()
    {
        // dd($this->template);
        try {
            $template = $this->template;
            DB::transaction(function () use ($template) {
                // Set semua `is_default` menjadi false
                Template::query()->update(['is_default' => false]);

                // Set `is_default` menjadi true untuk template yang diinginkan
                $template->update(['is_default' => true]);
            });

            $this->alert('success', 'Template Change Default Successfully');
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputFields();
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function render()
    {
        $templates = Template::orderBy('is_default', 'desc')
            ->when($this->search, function ($builder) {
                $builder->where(function ($builder) {
                    $builder->where('title', 'like', '%' . $this->search . '%');
                    $builder->orWhere('template', 'like', '%' . $this->search . '%');
                });
            });

        if ($this->limit == null) {
            $this->limit = PHP_INT_MAX;
        }

        $templates = $templates->paginate($this->limit);

        // if ($templates->isEmpty()) {
        //     $templates = collect(); // Inisialisasi sebagai koleksi kosong
        // }
        // dd($templates);
        return view('livewire.template.manage-template', compact('templates'))->layout('layouts.app', ['title' => 'Manage Campaign Template']);
    }
}
