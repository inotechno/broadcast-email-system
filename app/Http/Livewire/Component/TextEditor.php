<?php

namespace App\Http\Livewire\Component;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TextEditor extends Component
{
    use WithFileUploads;

    public $message, $file;

    public function uploadImage($imageData)
    {
        // Ensure that $imageData is an instance of UploadedFile
        if ($imageData instanceof \Illuminate\Http\UploadedFile) {

            // Store the image in the public disk within the images directory
            $path = $imageData->store('images', 'public');

            // Assuming you have a method to return the URL for the saved file
            $url = $this->getImageUrl($path); // Implement this method to generate URL

            // Return the URL or any other response you need
            return ['default' => $url];
        }

        // Handle the error case or throw an exception
        throw new \Exception("Invalid file type.");
    }

    // Method to get URL (implement based on your application logic)
    public function getImageUrl($path)
    {
        return \Storage::url($path);
    }

    public function render()
    {
        return view('livewire.component.text-editor');
    }
}
