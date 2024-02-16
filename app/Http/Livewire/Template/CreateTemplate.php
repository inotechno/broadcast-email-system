<?php

namespace App\Http\Livewire\Template;

use App\Models\Template;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class CreateTemplate extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $htmlContent, $previewContent = '';
    public $title, $thumbnail;

    public function updatePreview()
    {
        $this->previewContent = $this->htmlContent;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
        ]);

        try {
            $uid = Str::random(15);
            $extension = $this->thumbnail->extension();

            // Upload file ke penyimpanan yang diinginkan (misalnya: GCS)
            $path = $this->thumbnail->storeAs('assets/template_thumbnail', "{$uid}.{$extension}", 'gcs');

            Template::create([
                'title' => $this->title,
                'thumbnail' => $path,
                'template' => $this->htmlContent
            ]);

            $this->alert('success', 'Template Added Successfully');
            return redirect()->route('campaign.manage.template');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.template.create-template')->layout('layouts.app', ['title' => 'Create Template']);
    }
}
