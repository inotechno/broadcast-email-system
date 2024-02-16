<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Template</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Template</a></li>
                        <li class="breadcrumb-item active">Create Template</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body p-4">
                    <p class="text-muted">Create Template</p>
                    <form id="form-subcriber" wire:submit.prevent="store">

                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                wire:model="title">

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Image Thumbnail</label>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                wire:model="thumbnail">

                            @error('thumbnail')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        @if ($thumbnail)
                            <div class="mb-3">
                                <label class="d-block">Pratinjau:</label>
                                <img src="{{ $thumbnail->temporaryUrl() }}" width="500">
                            </div>
                        @endif

                        <div class="mb-3">
                            <p>Content of the template.
                                The content should at least have [CONTENT] somewhere.
                                You can upload a template file or paste the text in the box below</p>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <label>Template</label>
                                <button type="button" class="btn btn-info btn-sm" id="updatePreview">Update
                                    Preview</button>
                            </div>
                            <textarea wire:model="htmlContent" id="code-editor"></textarea>

                            @error('template')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md mb-2">
                                <button class="btn btn-danger w-100" wire:click="cancel()">Cancel</button>
                            </div>
                            <div class="col-md">
                                <button class="btn btn-primary w-100" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- end card -->
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <p class="text-muted">Preview</p>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! $previewContent !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/foldgutter.min.css">
    <style>
        .CodeMirror {
            height: 75vh;
            /* Menyesuaikan dengan 75% dari tinggi viewport */
            border: 1px solid #ddd;
            /* Opsional, untuk tampilan border */
        }
    </style>
@endpush
@push('plugin')
    <!-- Menambahkan Skrip CodeMirror dari CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>

    <!-- Menambahkan mode dan tema tambahan dari CDN, sesuaikan sesuai kebutuhan -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>
    <!-- Skrip untuk Folding CodeMirror -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/foldcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/foldgutter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/brace-fold.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/xml-fold.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/indent-fold.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/comment-fold.min.js"></script>

    <script>
        function initializeCodeMirror() {

            var editorElement = document.getElementById('code-editor');
            if (!editorElement) return;

            var editor = CodeMirror.fromTextArea(editorElement, {
                lineNumbers: true,
                mode: "htmlmixed",
                theme: "monokai",
                foldGutter: true,
                gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
                extraKeys: {
                    "Ctrl-Q": function(cm) {
                        cm.foldCode(cm.getCursor());
                    }
                }
            });

            $('#updatePreview').on('click', function() {
                @this.set('htmlContent', editor.getValue());
                @this.set('previewContent', editor.getValue());
            })
        }

        document.addEventListener('livewire:load', initializeCodeMirror);
        document.addEventListener('livewire:update', initializeCodeMirror);
    </script>
@endpush
