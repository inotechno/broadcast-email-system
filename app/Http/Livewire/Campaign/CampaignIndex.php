<?php

namespace App\Http\Livewire\Campaign;

use App\Jobs\SendEmail;
use App\Models\Campaign;
use App\Models\EmailLog;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CampaignIndex extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $category_id, $name, $description, $status, $category, $campaign_id, $campaign;
    public $search = null;
    public $editMode = false;
    public $deleteMode = false;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function getCampaign($id)
    {
        $this->campaign_id = $id;
        $this->campaign = Campaign::find($id);
    }

    public function duplicateCampaign()
    {
        $uuid = Str::random(15);
        // dd($categories);
        try {
            $categories = $this->campaign->categories->pluck('id')->toArray();
            $campaign = $this->campaign->toArray();

            $campaign['uuid'] = $uuid;
            $campaign['executed'] = false;
            $campaign['start_sent_at'] = Carbon::now()->addMinutes(10);
            $newCampaign = Campaign::create($campaign);
            // $newCampaign->categories()->sync($categories);

            $this->alert('success', 'Duplicate Campaign Successfully');
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function draftCampaign()
    {
        try {
            $this->campaign->update([
                'status' => 'draft'
            ]);

            $this->alert('success', 'Draft Campaign Successfully');
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function resendCampaign()
    {
        try {
            $logs = $this->campaign->logs()->where('status', 'failed')->get();
            // $logs = EmailLog::where('campaign_id', $this->campaign_id)->where('status', 'failed')->get();
            // dd($logs);

            if ($logs->isNotEmpty()) {
                foreach ($logs as $log) {
                    SendEmail::dispatch($log->recipient, $this->campaign->subject, $this->campaign->message);
                }

                $this->alert('success', 'Resend Campaign Successfully');
            } else {
                $this->alert('warning', 'This Campaign Not Failed Recipient');
            }

            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function deleteCampaign()
    {
        try {
            $this->campaign->delete();

            $this->alert('success', 'Deleted Campaign Successfully');
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function render()
    {
        $campaigns = Campaign::with('categories.subscribers', 'logs', 'template')
            ->when($this->search, function ($builder) {
                $builder->where(function ($builder) {
                    $builder->where('subject', 'like', '%' . $this->search . '%');
                    $builder->whereHas('categories', function ($builder) {
                        $builder->where('name', 'like', '%' . $this->search . '%');
                        $builder->orWhere('description', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->withStatusCounts()
            ->orderBy('created_at', 'DESC');

        $campaigns = $campaigns->paginate(16);

        return view('livewire.campaign.campaign-index', compact('campaigns'))->layout('layouts.app', ['title' => 'Campaign Lists']);
    }
}
