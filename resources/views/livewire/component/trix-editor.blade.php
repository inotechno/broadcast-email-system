<div>
    @if ($errors->has('message'))
        <div class="alert alert-danger">{{ $errors->first('message') }}</div>
    @endif

    <trix-editor id="text-editor" wire:model.defer="message"></trix-editor>
</div>
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
    <style>
        #text-editor {
            /* max-height: 80vh; */
            min-height: 50vh
                /* Maksimum 80% tinggi viewport */
        }
    </style>
@endpush

@push('plugin')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            var trixEditor = document.getElementById("text-editor");
            if (trixEditor) {
                trixEditor.addEventListener("trix-change", function() {
                    var trixHTML = trixEditor.value; // Gunakan .value untuk mendapatkan teks
                    window.livewire.emit('messageUpdated', trixHTML);
                });
            }
        });
    </script>
@endpush
