<?php

namespace App\Http\Livewire\Template;

use App\Models\Template;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class EditTemplate extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $htmlContent, $previewContent = '';
    public $title, $thumbnail, $template, $thumbnail_old;
    public function mount($id)
    {
        $this->template = Template::find($id);
        $this->title = $this->template->title;
        $this->thumbnail_old = $this->template->thumbnail;
        $this->htmlContent = $this->template->template;
        $this->previewContent = $this->htmlContent;
    }

    public function updatePreview()
    {
        $this->previewContent = $this->htmlContent;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
        ]);

        try {
            $path = $this->template->thumbnail;

            $uid = Str::random(15);

            // Upload file ke penyimpanan yang diinginkan (misalnya: GCS)
            if ($this->thumbnail) {
                $extension = $this->thumbnail->extension();
                $path = $this->thumbnail->storeAs('assets/template_thumbnail', "{$uid}.{$extension}", 'gcs');

                if ($path) {
                    // Hapus thumbnail lama jika ada
                    if ($this && $this->template->thumbnail) {
                        Storage::disk('gcs')->delete($this->template->thumbnail);
                    }
                }
            }

            $this->template->update([
                'title' => $this->title,
                'thumbnail' => $path,
                'template' => $this->htmlContent
            ]);

            $this->alert('success', 'Template Updated Successfully');
            return redirect()->route('campaign.manage.template');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.template.edit-template')->layout('layouts.app', ['title' => 'Edit Template']);
    }
}
