<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Subscribers</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Subscriber</a></li>
                        <li class="breadcrumb-item active">Subcsribers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <p class="text-muted">Subscriber Lists</p>
                        <span>Showing {{ $subscribers->firstItem() }} to {{ $subscribers->lastItem() }} of
                            {{ $subscribers->total() }}
                            results</span>
                    </div>
                    <div class="row">
                        @if ($subscribers->count() > 0)
                            @foreach ($subscribers as $subscriber)
                                <div class="col-xl-4 col-sm-6 text-center text-lg-start">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row d-flex flex-column flex-md-row">
                                                <div class="col-md-3 mb-2">
                                                    <div class="avatar-md">
                                                        <span
                                                            class="avatar-title rounded-circle bg-light text-danger fs-1">
                                                            {{ mb_substr($subscriber->email, 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-7 mb-2">
                                                    <h5 class="text-truncate font-size-15">
                                                        <a href="javascript: void(0);" class="text-dark"
                                                            data-bs-placement="top" title="{{ $subscriber->email }}"
                                                            data-bs-toggle="tooltip">{{ $subscriber->email }}</a>
                                                    </h5>
                                                    <p class="text-muted mb-2 d-flex align-items-center">
                                                        {{ $subscriber->name }}

                                                        @if ($subscriber->active)
                                                            <span class="badge ms-2 bg-success">Active</span>
                                                        @else
                                                            <span class="badge ms-2 bg-danger">Inactive</span>
                                                        @endif
                                                    </p>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            @foreach ($subscriber->categories as $category)
                                                                <span
                                                                    class="badge bg-warning">{{ $category->name }}</span>
                                                            @endforeach
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="col-6 col-md-12 mb-1">
                                                            <button type="button"
                                                                class="btn btn-sm my-md-1 btn-warning"
                                                                wire:click="edit({{ $subscriber->id }})">
                                                                <span data-bs-placement="left" title="Update"
                                                                    data-bs-toggle="tooltip">
                                                                    <i class="bx bxs-edit-alt bx-xs"></i>
                                                                </span>
                                                            </button>
                                                        </div>
                                                        <div class="col-6 col-md-12">
                                                            <button type="button" class="btn btn-sm my-md-1 btn-danger"
                                                                wire:click="remove({{ $subscriber->id }})"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-confirm-delete">
                                                                <span data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    title="Delete">
                                                                    <i class="bx bxs-trash-alt bx-xs"></i>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="card bg-warning text-white text-center p-3">
                                    <blockquote class="card-blockquote font-size-14 mb-0">
                                        <p>Tidak ada data</p>
                                        <footer class="blockquote-footer mt-0 text-white font-size-12 mb-0">
                                            Silahkan klik tombol tambah data untuk menambah data category.
                                        </footer>
                                    </blockquote>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{ $subscribers->links('livewire.pagination') }}

                </div>
            </div>
        </div>

        <div class="col-xl-2" style="overflow-y: auto; max-height: 81vh;">
            <div class="card">
                <div class="card-body p-4">
                    <div class="search-box">
                        <p class="text-muted">Search</p>
                        <div class="position-relative">
                            <input type="text" class="form-control rounded bg-light border-light"
                                placeholder="Search..." wire:model="search">
                            <i class="mdi mdi-magnify search-icon"></i>
                        </div>
                    </div>


                    <hr class="mb-3">

                    <div class="search-box">
                        <p class="text-muted">Limit</p>

                        <div>
                            <div class="btn-group-horizontal btn-group-sm" role="group">
                                <input type="radio" class="btn-check" name="limit" id="limit1" autocomplete="off"
                                    checked="" wire:click="$set('limit', 12)">
                                <label class="btn btn-outline-danger" for="limit1">12</label>

                                <input type="radio" class="btn-check" name="limit" id="limit2" autocomplete="off"
                                    wire:click="$set('limit', 60)">
                                <label class="btn btn-outline-danger" for="limit2">60</label>

                                <input type="radio" class="btn-check" name="limit" id="limit3" autocomplete="off"
                                    wire:click="$set('limit', 240)">
                                <label class="btn btn-outline-danger" for="limit3">240</label>

                                <input type="radio" class="btn-check" name="limit" id="all"
                                    autocomplete="off" wire:click="$set('limit', null)">
                                <label class="btn btn-outline-danger" for="all">All</label>
                            </div>

                        </div>
                    </div>

                    <hr class="mb-3">

                    <div class="search-box">
                        <p class="text-muted">Categories</p>

                        <div>
                            <div class="btn-group-horizontal btn-group-sm" role="group">
                                @foreach ($categories as $key => $category)
                                    <input type="checkbox" class="btn-check" name="filterCategory[]"
                                        id="filterCategory{{ $key }}" autocomplete="off"
                                        wire:model="filterCategory" value="{{ $category->id }}">
                                    <label class="btn btn-outline-danger"
                                        for="filterCategory{{ $key }}">{{ $category->name }}</label>
                                @endforeach
                            </div>

                        </div>
                    </div>


                    <hr class="mb-3">

                    <p class="text-muted">{{ $nameForm }}</p>
                    <form id="form-subcriber"
                        @if (!$editMode) wire:submit.prevent="store" wire:keydown.enter.prevent="store" @else wire:submit.prevent="update" wire:keydown.enter.prevent="update" @endif>

                        <div class="mb-3">
                            <label for="select-category">Categories</label>
                            <select wire:model.defer="category_id"
                                class="form-control @error('category_id') is-invalid @enderror"
                                data-placeholder="Select Categories" id="select-category" multiple>
                                <option></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                wire:model="name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                wire:model="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Phone Number</label>
                            <input type="number" class="form-control @error('phone_number') is-invalid @enderror"
                                wire:model="phone_number">

                            @error('phone_number')
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
    </div>

    <div wire:ignore.self id="modal-confirm-delete" class="modal fade" tabindex="-1"
        aria-labelledby="myModalConfirmDelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalConfirmDelete">Confirm Deletion</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger"
                        wire:loading.attr="disabled">Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('css')
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('plugin')
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
    <script>
        window.initSelectStation = () => {
            $("#select-category").select2({
                width: '100%',
                dropdownAutoWidth: true,
                placeholder: 'Select Option',
            });
        }

        document.addEventListener('livewire:load', function() {

            initSelectStation();

            window.livewire.on('afterDomUpdate', function() {
                initSelectStation();
            });

            $('#select-category').off('change').on('change', function() {
                @this.set('category_id', $(this).val());
            });
        });

        $(document).ready(function() {
            window.addEventListener('close-modal', event => {
                $('#modal-confirm-delete').modal('hide');
            });
        });
    </script>
@endpush
