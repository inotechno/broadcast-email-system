<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Category Subscribers</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Subscriber</a></li>
                        <li class="breadcrumb-item active">Category Subcsribers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card job-filter">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md mb-md-0 mb-2">
                            <form action="javascript:void(0);">
                                <div class="row">
                                    <div class="col-xxl-4 col-lg-4">
                                        <div class="search-box">
                                            <div class="position-relative">
                                                <input type="text" class="form-control rounded bg-light border-light"
                                                    placeholder="Search..." wire:model="search">
                                                <i class="mdi mdi-magnify search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            </form>
                        </div>

                        <div class="col-12 col-md-4 text-md-end mb-md-0 mb-2">
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-add-category">Add
                                Category</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>

    <div class="row">
        @if ($categories->count() > 0)
            @foreach ($categories as $category)
                <div class="col-xl-3 col-sm-6 text-center text-lg-start">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex flex-column flex-md-row">
                                <div class="col-md-3 mb-2">
                                    <div class="avatar-md">
                                        <span class="avatar-title rounded-circle bg-light text-danger fs-1">
                                            {{ mb_substr($category->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-7 mb-2">
                                    <h5 class="text-truncate font-size-15">
                                        <a href="javascript: void(0);" class="text-dark" data-bs-placement="top"
                                            title="{{ $category->description }}"
                                            data-bs-toggle="tooltip">{{ $category->name }}</a>
                                    </h5>
                                    {{-- <p class="text-muted mb-2">{{ $category->subscriber_count }} Subcsribers</p> --}}
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            @if ($category->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-2">
                                    <div class="d-flex flex-wrap">
                                        <div class="col-6 col-md-12 mb-1">
                                            <button type="button" class="btn btn-sm my-md-1 btn-warning"
                                                wire:click="edit({{ $category->id }})" data-bs-toggle="modal"
                                                data-bs-target="#modal-update-category">
                                                <span data-bs-placement="left" title="Update" data-bs-toggle="tooltip">
                                                    <i class="bx bxs-edit-alt bx-xs"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="col-6 col-md-12">
                                            <button type="button" class="btn btn-sm my-md-1 btn-danger"
                                                wire:click="remove({{ $category->id }})" data-bs-toggle="modal"
                                                data-bs-target="#modal-confirm-delete">
                                                <span data-bs-toggle="tooltip" data-bs-placement="left" title="Delete">
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

    {{ $categories->links('livewire.pagination') }}

    <!-- end row -->

    <div wire:ignore.self id="modal-add-category" class="modal fade" tabindex="-1"
        aria-labelledby="myModalAddAttendance" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalAddAttendance">Add Attendance</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="mb-3 col-md">
                                <label for="name">Name <small class="text-danger">* required</small></label>
                                <input type="text" wire:model.lazy="name.0"
                                    class="form-control @error('name.0') is-invalid @enderror"
                                    placeholder="Enter Name" />

                                @error('name.0')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md">
                                <label for="description">Description</label>
                                <input type="text" wire:model.lazy="description.0"
                                    class="form-control @error('description.0') is-invalid @enderror"
                                    placeholder="Enter Description" />
                            </div>

                            @error('description.0')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        @foreach ($inputs as $key => $value)
                            <div class="row">
                                <div class="mb-3 col-md">
                                    <label for="name">Name <small class="text-danger">* required</small></label>
                                    <input type="text" wire:model.lazy="name.{{ $value }}"
                                        class="form-control @error('name.' . $value) is-invalid @enderror"
                                        placeholder="Enter Name" />

                                    @error('name.' . $value)
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md">
                                    <label for="description">Description</label>
                                    <input type="text" wire:model.lazy="description.{{ $value }}"
                                        class="form-control @error('description.' . $value) is-invalid @enderror"
                                        placeholder="Enter Description" />

                                    @error('description.' . $value)
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-2 align-self-center">
                                    <button class="btn btn-danger mt-2"
                                        wire:click.prevent="removeRow({{ $key }})">Delete</button>
                                </div>
                            </div>
                        @endforeach

                        <button wire:click.prevent="add({{ $i }})" type="button"
                            class="btn btn-success mt-3 mt-lg-0">Add</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" form="form-add-group" wire:click.prevent="store()"
                        class="btn btn-primary" wire:loading.attr="disabled">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="modal-update-category" class="modal fade" tabindex="-1"
        aria-labelledby="myModalUpdateCategory" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalUpdateCategory">Update Attendance</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>

                        <div class="row">
                            <div class="mb-3 col-md">
                                <label for="name">Name <small class="text-danger">* required</small></label>
                                <input type="text" wire:model.lazy="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Name" />

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md">
                                <label for="description">Description</label>
                                <input type="text" wire:model.lazy="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter Description" />
                            </div>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" form="form-add-group" wire:click.prevent="update()"
                        class="btn btn-primary" wire:loading.attr="disabled">Submit</button>
                </div>
            </div>
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
