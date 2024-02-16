<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Campaign Templates</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Campaign</a></li>
                        <li class="breadcrumb-item active">Template</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2 ">
                        <p class="text-muted">Template Lists</p>
                        <a href="{{ route('campaign.template.create') }}" class="btn btn-primary">Add Template</a>
                    </div>
                    <div class="row">
                        @if ($templates->count() > 0)
                            @foreach ($templates as $template)
                                <div class="col-sm-3">
                                    <div class="card p-1 border shadow-none">
                                        <div class="p-3 d-flex justify-content-between">
                                            <div>
                                                <h5><a href="blog-details.html"
                                                        class="text-dark">{{ $template->title }}</a>
                                                </h5>
                                                <p class="text-muted mb-0">{{ $template->created_at->format('d M, Y') }}
                                                </p>
                                            </div>

                                            @if ($template->is_default)
                                                <h3>
                                                    <span class="badge bg-warning badge-md"><i
                                                            class="bx bxs-star"></i></span>
                                                </h3>
                                            @endif

                                        </div>

                                        <div class="position-relative">
                                            <img src="{{ Storage::disk('gcs')->url($template->thumbnail) }}"
                                                alt="" class="img-thumbnail">
                                        </div>

                                        <div class="p-2">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('campaign.template.edit', $template->id) }}"
                                                    class="btn btn-sm m-1 btn-warning align-middle"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class='bx bx-edit-alt'></i>
                                                </a>

                                                <button class="btn btn-sm m-1 btn-info align-middle"
                                                    wire:click="getTemplate({{ $template->id }})" data-bs-toggle="modal"
                                                    data-bs-target="#modal-preview-template">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Preview">
                                                        <i class='bx bx-image-alt'></i>
                                                    </span>
                                                </button>

                                                <button class="btn btn-sm m-1 btn-primary align-middle"
                                                    wire:click="getTemplate({{ $template->id }})" data-bs-toggle="modal"
                                                    data-bs-target="#modal-confirm-default">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Change Default">
                                                        <i class='bx bx-transfer-alt'></i>
                                                    </span>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="card bg-warning text-white text-center p-3">
                                    <blockquote class="card-blockquote font-size-14 mb-0">
                                        <p>Data not found</p>
                                        <footer class="blockquote-footer mt-0 text-white font-size-12 mb-0">
                                            Please click the "Add Template" button to add a template.
                                        </footer>
                                    </blockquote>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{ $templates->links('livewire.pagination') }}

                    @if ($templates)
                        <span>Showing {{ $templates->firstItem() }} to {{ $templates->lastItem() }} of
                            {{ $templates->total() }}
                            results</span>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div wire:ignore.self id="modal-preview-template" class="modal fade" tabindex="-1"
        aria-labelledby="previewTemplate" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewTemplate">Preview Template</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($template)
                        <img class="img-fluid" src="{{ Storage::disk('gcs')->url($template->thumbnail) }}"
                            alt="{{ $template->title }}">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="modal-confirm-default" class="modal fade" tabindex="-1"
        aria-labelledby="myModalConfirmDelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalConfirmDelete">Confirm Change Default</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($template)
                        <p>Apakah Anda yakin ingin menjadikan template {{ $template->title }} ini default?</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="changeDefault()" class="btn btn-primary">Change
                        Default</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('plugin')
    <script>
        document.addEventListener('livewire:load', function() {
            window.addEventListener('close-modal', event => {
                $('#modal-confirm-default').modal('hide');
            });
        });
    </script>
@endpush
