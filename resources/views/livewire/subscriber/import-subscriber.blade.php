<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Subscribers</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Subscriber</a></li>
                        <li class="breadcrumb-item active">Import Subcsribers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-2" style="overflow-y: auto; max-height: 81vh;">
            <div class="card">
                <div class="card-body p-4">


                    <div class="search-box">
                        <p class="text-muted">Select Categories</p>

                        <div>
                            <div class="btn-group-horizontal btn-group-sm" role="group">
                                @foreach ($categories as $key => $category)
                                    <input type="checkbox" class="btn-check" name="category_id[]"
                                        id="category_id{{ $key }}" autocomplete="off" wire:model="category_id"
                                        value="{{ $category->id }}">
                                    <label class="btn btn-outline-danger"
                                        for="category_id{{ $key }}">{{ $category->name }}</label>
                                @endforeach
                            </div>

                            @error('category_id')
                                <h6 class="alert alert-danger text-small text-wrap">{{ $errors->first('category_id') }}
                                </h6>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-2">

                    <p class="text-muted">Add Category</p>
                    <form id="form-category" wire:submit.prevent="addCategory" wire:keydown.enter.prevent="addCategory">

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control @error('category_name') is-invalid @enderror"
                                wire:model="category_name">

                            @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <button class="btn btn-primary w-100" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- end card -->
        </div>

        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Custom Tabs</h4>
                    <p class="card-title-desc">Example of custom tabs</p>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link  {{ $activeTab === 'copy_paste' ? 'active' : '' }}" data-bs-toggle="tab"
                                href="#copy_paste" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Copy and paste</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'upload' ? 'active' : '' }}" data-bs-toggle="tab"
                                href="#upload" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Import by upload file</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane {{ $activeTab === 'copy_paste' ? 'active' : '' }}" id="copy_paste"
                            role="tabpanel">
                            <p class="mb-0">
                            <form wire:submit.prevent="importEmails">
                                <label for="">Please enter the email addresses to import, one per line without
                                    comas, in the
                                    box below and click "Import"
                                </label>
                                <textarea wire:model.lazy="emails" class="form-control" id="" cols="30" rows="10"></textarea>
                                <button type="submit" class="btn btn-primary mt-2">Import</button>
                            </form>
                            </p>
                        </div>
                        <div class="tab-pane {{ $activeTab === 'upload' ? 'active' : '' }}" id="upload"
                            role="tabpanel">
                            <form wire:submit.prevent="importFile">
                                <label>Upload file XLSX</label>
                                <p>
                                    Please upload an Excel file containing user information with the following columns:
                                </p>
                                <ul>
                                    <li><strong>Email (mandatory):</strong> This column must contain the user's email
                                        address.</li>
                                    <li><strong>Name:</strong> If you have user names information, include it in this
                                        column.</li>
                                    <li><strong>Phone Number:</strong> If you have user phone number information,
                                        include it in this column.</li>
                                </ul>
                                <input type="file" class="form-control" wire:model.lazy="file"
                                    wire:change="changeTab('upload')" id="fileInput">
                                <button type="submit" class="btn btn-primary mt-2">Import</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('plugin')
    <script>
        document.getElementById('fileInput').addEventListener('change', function() {

        });
    </script>
@endpush
