<?php

namespace App\Http\Livewire\Campaign;

use App\Jobs\SendEmail;
use App\Models\Campaign;
use App\Models\CampaignAttachment;
use App\Models\CategorySubscriber;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCampaign extends Component
{
    use LivewireAlert, WithFileUploads;

    public $subject, $is_html, $message, $start_send_at, $status, $template_id, $created_by, $previewContent, $content, $campaign, $message_without_template, $campaign_attachments;
    public $templates, $categories;
    public $category_id = [];
    public $attachments = [];
    public $email_tests;
    public $currentTime;
    public $tabActive = 'content';

    protected $listeners = ['messageUpdated' => 'updateMessage'];

    public function updateMessage($messageContent)
    {
        $this->message = $messageContent;
        $this->message_without_template = $messageContent;
    }

    public function updated()
    {
        $this->getTime();
    }

    public function resetInputFields()
    {
        $this->subject = "";
        $this->is_html = "";
        $this->message = "";
        $this->start_send_at = "";
        $this->status = "";
        $this->template_id = "";
        $this->created_by = "";
        $this->previewContent = "";
        $this->content = "";
        $this->category_id = [];
        $this->attachments = [];
        $this->campaign_attachments = "";
    }

    public function getTime()
    {
        $this->currentTime = now();
    }

    public function mount($id)
    {
        $this->campaign = Campaign::find($id);
        $this->subject = $this->campaign->subject;
        $this->message = $this->campaign->message_without_template;
        $this->message_without_template = $this->campaign->message_without_template;
        $this->start_send_at = $this->campaign->start_send_at;
        $this->template_id = $this->campaign->template_id;
        $this->content = $this->campaign->message;
        $this->category_id = $this->campaign->categories->pluck('id')->toArray();

        $this->campaign_attachments = $this->campaign->attachments;
        $this->templates = Template::get();
        $this->categories = CategorySubscriber::get();
        $this->getTime();
    }

    public function previewCampaign()
    {
        // dd($this->message);
        if ($this->template_id) {
            $template = Template::find($this->template_id);
            // echo $template->template;

            // dd(strpos($template->template, '[SUBJECT]'));
            $previewContent = str_replace('[CONTENT]', $this->message, $template->template);

            if (strpos($previewContent, '[SUBJECT]') !== false) {
                $previewContent = str_replace('[SUBJECT]', $this->subject, $previewContent);
            }

            $this->previewContent = htmlspecialchars_decode($previewContent);
        }

        $this->tabActive = 'preview';
    }

    public function sendTestCampaign()
    {
        $this->validate([
            'template_id'           => 'required',
        ]);

        $this->setContent();
        // echo $this->content;
        // die;

        $emails = explode(',', $this->email_tests);

        try {
            foreach ($emails as $email) {
                SendEmail::dispatch($email, $this->subject, $this->content);
            }

            $this->alert('success', 'Test Send Email Successfully');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function setContent()
    {
        if ($this->template_id) {
            $template = Template::find($this->template_id);
            $content = str_replace('[CONTENT]', $this->message, $template->template);

            if (strpos($content, '[SUBJECT]') !== false) {
                $content = str_replace('[SUBJECT]', $this->subject, $content);
            }

            $this->content = htmlspecialchars_decode($content);
        }
    }

    public function draft()
    {
        $this->validate([
            'subject'           => 'required',
        ]);

        $this->setContent();

        try {
            $uuid = Str::random(15);

            $campaign = $this->campaign->update([
                'uuid' => $uuid,
                'subject' => $this->subject,
                'message' => $this->content,
                'message_without_template' => $this->message_without_template,
                'start_send_at' => $this->start_send_at,
                'status' => 'active',
                'template_id' => $this->template_id,
                'created_by' => Auth::user()->name
            ]);

            foreach ($this->attachments as $attachment) {
                $uid = Str::random(15);
                $extension = $attachment->extension();

                // Upload file ke penyimpanan yang diinginkan (misalnya: GCS)
                $path = $attachment->storeAs('assets/attachments', "{$uid}.{$extension}", 'gcs');

                // Dapatkan informasi file
                $originalName = $attachment->getClientOriginalName();
                $extension = $attachment->getClientOriginalExtension();
                $fileSize = $attachment->getSize(); // Ukuran file dalam bytes
                $mime = $attachment->getClientMimeType();

                // Simpan path file di database atau sesuai kebutuhan
                // ...

                CampaignAttachment::create([
                    'campaign_id' => $campaign->id,
                    'file_url' => $path,
                    'file_name' => $originalName,
                    'file_ext' => $extension,
                    'file_size' => $fileSize,
                    'file_mime' => $mime
                ]);
            }

            $this->alert('success', 'Campaign Saved Draft Successfully');
            return redirect()->route('campaigns');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function update()
    {
        $this->validate([
            'subject'           => 'required',
            'template_id'       => 'required',
            'category_id'       => 'required',
            'message'           => 'required|min:3',
            'start_send_at'     => 'required|after_or_equal:now',
            'attachments'       => 'array|max_attachments_size:10000', // 10000 KB (10MB)
            'attachments.*'     => 'max:10240', // Max 10MB per file (10240 KB)
        ], [
            'max_attachments_size' => 'The total size of attachments cannot exceed 10MB.',
            'attachments.*.max'    => 'The size of each attachment cannot exceed 10MB.',
        ]);

        $this->setContent();
        // dd($this->content);

        try {
            $this->campaign->update([
                'subject' => $this->subject,
                'message' => $this->content,
                'message_without_template' => $this->message_without_template,
                'start_send_at' => $this->start_send_at,
                'status' => 'active',
                'template_id' => $this->template_id,
                'created_by' => Auth::id()
            ]);

            foreach ($this->attachments as $attachment) {
                $uid = Str::random(15);
                $extension = $attachment->extension();

                // Upload file ke penyimpanan yang diinginkan (misalnya: GCS)
                $path = $attachment->storeAs('assets/attachments', "{$uid}.{$extension}", 'gcs');

                // Dapatkan informasi file
                $originalName = $attachment->getClientOriginalName();
                $extension = $attachment->getClientOriginalExtension();
                $fileSize = $attachment->getSize(); // Ukuran file dalam bytes
                $mime = $attachment->getClientMimeType();

                // Simpan path file di database atau sesuai kebutuhan
                // ...

                CampaignAttachment::create([
                    'campaign_id' => $campaign->id,
                    'file_url' => $path,
                    'file_name' => $originalName,
                    'file_ext' => $extension,
                    'file_size' => $fileSize,
                    'file_mime' => $mime
                ]);
            }

            $this->campaign->categories()->sync($this->category_id);

            $this->alert('success', 'Campaign Active Successfully');
            return redirect()->route('campaigns');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function deleteAttachment($id)
    {
        try {
            $attachment = CampaignAttachment::find($id);
            $attachment->delete();
            Storage::disk('gcs')->delete($attachment->file_url);

            $this->alert('success', 'Attachment deleted successfully');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.campaign.edit-campaign')->layout('layouts.app', ['title' => 'Edit Campaign']);
    }
}
