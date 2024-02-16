<?php

namespace App\Http\Livewire\Subscriber;

use App\Models\CategorySubscriber;
use App\Models\Subscriber;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class SubscriberIndex extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $subscriber_id, $uuid, $email, $name, $phone_number, $active, $categories, $subscriber;
    public $category_id = [];
    public $search = null;
    public $filterCategory = [];
    public $nameForm = "Add Subscriber";

    public $editMode = false;
    public $deleteMode = false;
    public $limit = 12;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function hydrate()
    {
        $this->emit('afterDomUpdate');
    }

    public function updatedFilterCategory()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->categories = CategorySubscriber::all();
    }

    public function resetInputFields()
    {
        $this->subscriber_id = "";
        $this->uuid = "";
        $this->email = "";
        $this->name = "";
        $this->phone_number = "";
        $this->active = "";
        $this->category_id = [];
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->dispatchBrowserEvent('hide-form');
    }

    public function add()
    {
        $this->dispatchBrowserEvent('show-form');
    }

    public function edit($id)
    {
        $this->subscriber = Subscriber::find($id);
        $this->subscriber_id = $this->subscriber->id;
        $this->name = $this->subscriber->name;
        $this->email = $this->subscriber->email;
        $this->phone_number = $this->subscriber->phone_number;
        $this->category_id = $this->subscriber->categories->pluck('id')->toArray();

        $this->nameForm = "Update Subscriber {$this->name}";
        $this->editMode = true;
        $this->updated();
    }

    public function store()
    {
        $this->validate([
            'email' => 'required',
        ]);

        try {
            $uid = Str::random(15);
            $subscriber = Subscriber::updateOrCreate([
                'email' => $this->email
            ], [
                'uuid' => $uid,
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'active' => 1
            ]);

            $subscriber->categories()->sync($this->category_id);
            $this->alert('success', 'Added subscriber successfully');
            $this->resetInputFields();
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function update()
    {
        $this->validate([
            'email' => 'required',
        ]);

        try {
            $this->subscriber->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
            ]);

            $this->subscriber->categories()->sync($this->category_id);
            $this->alert('success', 'Updated subscriber successfully');
            $this->resetInputFields();
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function remove($id)
    {
        $this->subscriber = Subscriber::find($id);
        $this->subscriber_id = $this->subscriber->id;
        $this->name = $this->subscriber->name;
        $this->email = $this->subscriber->email;
        $this->phone_number = $this->subscriber->phone_number;
        $this->category_id = $this->subscriber->categories->pluck('id')->toArray();

        $this->deleteMode = true;
    }

    public function delete()
    {
        try {
            $this->subscriber->delete();
            $this->alert('success', 'Deleted subscriber successfully');
            $this->resetInputFields();
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            //throw $th;
            $this->alert('error', $th->getMessage());
        }
    }

    public function render()
    {
        $subscribers = Subscriber::with('categories')
            ->when(!empty($this->filterCategory), function ($builder) {
                $builder->whereHas('categories', function ($query) {
                    $query->whereIn('category_subscriber_id', (array) $this->filterCategory);
                });
            })
            ->when($this->search, function ($builder) {
                $builder->where(function ($builder) {
                    $builder->where('name', 'like', '%' . $this->search . '%');
                    $builder->orWhere('email', 'like', '%' . $this->search . '%');
                    $builder->orWhere('phone_number', 'like', '%' . $this->search . '%');
                });
            });


        if ($this->limit == null) {
            $this->limit = PHP_INT_MAX;
        }

        $subscribers = $subscribers->paginate($this->limit);
        // dd($subscribers);
        return view('livewire.subscriber.subscriber-index', compact('subscribers'))->layout('layouts.app', ['title' => 'Subscribers']);
    }
}
