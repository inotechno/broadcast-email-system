<?php

namespace App\Http\Livewire\Subscriber;

use App\Imports\SubscriberImport;
use App\Jobs\SavedEmailJob;
use App\Models\CategorySubscriber;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportSubscriber extends Component
{
    use LivewireAlert, WithFileUploads;
    public $categories;
    public $category_id = [];
    public $file;
    public $emails = '';
    public $category_name;
    public $activeTab = 'copy_paste';

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = CategorySubscriber::all();
    }

    public function resetInputFields()
    {
        $this->file = '';
        $this->category_id = [];
        $this->emails = '';
    }

    public function changeTab($tabId)
    {
        $this->activeTab = $tabId;
    }

    public function importEmails()
    {
        // dd($this->category_id);

        $this->validate([
            'category_id' => 'required'
        ]);

        $this->activeTab = 'copy_paste';
        $emails = explode("\n", $this->emails);

        foreach ($emails as $email) {
            // Dispatch job untuk setiap email dengan informasi tambahan
            SavedEmailJob::dispatch([
                'email' => $email,
                'name' => $this->name ?? null,
                'phone_number' => $this->phone_number ?? null,
                'categories' => $this->category_id
            ]);
        }

        $this->resetInputFields();
        $this->alert('success', 'Emails have been imported successfully!');
    }

    public function importFile()
    {
        $this->validate([
            'category_id' => 'required',
            'file' => 'required|file|mimes:xlsx',
        ]);

        $this->activeTab = 'upload';

        $path = $this->file->storeAs('imports', 'import.xlsx', 'public');
        // Gunakan Excel facade untuk membaca file Excel
        Excel::import(new SubscriberImport, storage_path('app/public/' . $path));

        // Proses data yang diimpor
        $importedData = SubscriberImport::getImportedData();

        if (!empty($importedData)) {
            foreach ($importedData as $data) {
                // Dispatch job untuk setiap email dengan informasi tambahan
                SavedEmailJob::dispatch([
                    'email' => $data['email'],
                    'name' => $data['name'] ?? null,
                    'phone_number' => $data['phone_number'] ?? null,
                    'categories' => $this->category_id
                ]);
            }
        }

        $this->resetInputFields();
        $this->alert('success', 'File imported successfully! Please wait for the process to complete.');
    }

    public function updatedCategories()
    {
        $this->resetPage();
    }

    public function addCategory()
    {
        $this->validate([
            'category_name' => 'required',
        ]);

        try {

            CategorySubscriber::updateOrCreate([
                'name' => $this->category_name,
            ], [
                'name' => $this->category_name,
            ]);

            $this->category_name = '';
            $this->loadCategories();
            $this->alert('success', 'Added category subsribers successfully');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.subscriber.import-subscriber')->layout('layouts.app', ['title' => 'Import Subscribers']);
    }
}
