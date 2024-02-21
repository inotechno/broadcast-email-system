<?php

namespace App\Http\Livewire\CategorySubscriber;

use App\Models\CategorySubscriber;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $category_id, $name, $description, $status, $category;
    public $search = null;
    public $editMode = false;
    public $deleteMode = false;
    public $inputs = [];
    public $i = 1;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);

        // dd($this->inputs);
    }

    public function resetInputFields()
    {
        $this->category_id = "";
        $this->name = "";
        $this->description = "";
        $this->inputs = [];

        $this->i = 1;
    }

    public function removeRow($i)
    {
        unset($this->inputs[$i]);
    }

    public function store()
    {
        $this->validate([
            'name.0' => 'required',
            'name.*' => 'required',
            // 'description.*' => 'required',
        ]);

        try {
            foreach ($this->name as $key => $value) {
                CategorySubscriber::create(
                    [
                        'name' => $this->name[$key],
                        'description' => $this->description[$key] ?? null,
                    ]
                );
            }

            $this->resetInputFields();
            $this->alert('success', 'Added category subsribers successfully');
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
            $this->alert('error', $th->getMessage());
        }
    }

    public function edit($category_id)
    {
        $this->category_id = $category_id;
        $this->category = CategorySubscriber::find($category_id);
        $this->name = $this->category->name;
        $this->description = $this->category->description;

        $this->editMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            // 'description' => 'required',
        ]);

        try {
            $this->category->update([
                'name' => $this->name,
                'description' => $this->description,
                // 'status' => $this->status,
            ]);

            $this->resetInputFields();
            $this->alert('success', 'Updated category subscriber successfully');
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
            $this->alert('error', $th->getMessage());
        }
    }

    public function remove($category_id)
    {
        $this->category_id = $category_id;
        $this->category = CategorySubscriber::find($category_id);
        $this->name = $this->category->name;
        $this->description = $this->category->description;

        $this->deleteMode = true;
    }

    public function delete()
    {
        try {
            $this->category->delete();

            $this->resetInputFields();
            $this->alert('success', 'Deleted Category Subcsriber Successfully');
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function render()
    {
        $categories = CategorySubscriber::when($this->search, function ($builder) {
            $builder->where(function ($builder) {
                $builder->where('name', 'like', '%' . $this->search . '%');
                $builder->orWhere('description', 'like', '%' . $this->search . '%');
            });
        })->orderBy('name', 'ASC');

        $categories = $categories->paginate(16);

        // foreach ($categories as $category) {
        //     // Panggil lazy loading untuk mendapatkan koleksi subscribers
        //     $subscribers = $category->subscribers;

        //     // Hitung jumlah subscribers dan simpan di property 'subscriber_count'
        //     $category->subscriber_count = $subscribers->count();
        // }

        // dd($categories);
        return view('livewire.category-subscriber.category-index', compact('categories'))->layout('layouts.app', ['title' => 'Category Subscribers']);
    }
}
