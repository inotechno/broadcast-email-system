<?php

namespace App\Http\Livewire\Campaign;

use App\Jobs\SendEmail;
use App\Models\Campaign;
use App\Models\CampaignAttachment;
use App\Models\CategorySubscriber;
use App\Models\EmailLog;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class NewCampaign extends Component
{
    use LivewireAlert, WithFileUploads;

    public $subject, $is_html, $message, $start_send_at, $status, $template_id, $created_by, $previewContent, $content, $message_without_template, $from_email;
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

    public function mount()
    {
        $this->message = '';
        $this->templates = Template::get();
        $this->categories = CategorySubscriber::get();
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
        $this->from_email = "";
        $this->created_by = "";
        $this->previewContent = "";
        $this->content = "";
        $this->category_id = [];
    }

    public function getTime()
    {
        $this->currentTime = now();
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
            $date = Carbon::now()->addSeconds(5);
            foreach ($emails as $email) {
                // SendEmail::dispatch($email, $this->subject, $this->content, $this->from_email);

                EmailLog::create([
                    'campaign_id' => 0,
                    'recipient' => $email,
                    'subject' => $this->subject,
                    'message' => $this->content,
                    'send_at' => $date,
                    'status' => 'pending' // Initially set to queued, change to sent or failed within the job
                ]);
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

            $campaign = Campaign::create([
                'uuid' => $uuid,
                'subject' => $this->subject,
                'from_email' => $this->from_email,
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
            return redirect()->route('campaign.create');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function store()
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
            $uuid = Str::random(15);

            $campaign = Campaign::create([
                'uuid' => $uuid,
                'subject' => $this->subject,
                'from_email' => $this->from_email,
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

            $campaign->categories()->sync($this->category_id);

            $this->alert('success', 'Campaign Active Successfully');
            return redirect()->route('campaign.create');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.campaign.new-campaign')->layout('layouts.app', ['title' => 'New Campaign']);
    }
}
