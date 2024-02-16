<div wire:ignore>
    <textarea id="editor" wire:model.defer="message"></textarea>
    <input type="file" wire:model="file">
</div>
@push('plugin')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    @this.set('message', editor.getData());
                });

                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return {
                        upload: () => {
                            return loader.file.then(file => new Promise((resolve, reject) => {
                                // Set up the form data
                                let formData = new FormData();
                                formData.append('file', file);

                                // Use Livewire's upload mechanism
                                @this.upload('file', file, (uploadedFilename) => {
                                    // File was uploaded successfully and is now in Livewire's temporary directory.
                                    resolve({
                                        default: 'storage/app/livewire/tmp/' +
                                            uploadedFilename
                                    });
                                }, () => {
                                    // Error handling
                                    reject(
                                        'An error occurred during the upload'
                                    );
                                });
                            }));
                        }
                    };
                };
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
