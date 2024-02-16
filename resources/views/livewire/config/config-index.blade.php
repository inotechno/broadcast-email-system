<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Configuration</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                        <li class="breadcrumb-item active">Configuration</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="outer-repeater" method="post">
                        <div data-repeater-list="outer-group" class="outer">
                            <div data-repeater-item class="outer">
                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">App Name</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('app_name') is-invalid @enderror "
                                            placeholder="Enter App Name..." wire:model="app_name">
                                        @error('app_name')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">App URL</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('app_url') is-invalid @enderror "
                                            placeholder="Enter App Name..." wire:model="app_url">
                                        @error('app_url')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">Mail Type</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('mail_mailer') is-invalid @enderror"
                                            placeholder="Enter Mail Type..." wire:model="mail_mailer">
                                        @error('mail_mailer')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">Mail Host</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('mail_host') is-invalid @enderror"
                                            placeholder="Enter Mail Host..." wire:model="mail_host">
                                        @error('mail_host')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">Mail Port</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('mail_port') is-invalid @enderror"
                                            placeholder="Enter Mail Port..." wire:model="mail_port">
                                        @error('mail_port')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">Mail Username</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('mail_username') is-invalid @enderror"
                                            placeholder="Enter Mail Username..." wire:model="mail_username">
                                        @error('mail_username')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">Mail Password</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('mail_password') is-invalid @enderror"
                                            placeholder="Enter Mail Password..." wire:model="mail_password">
                                        @error('mail_password')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">Mail Encryption</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('mail_encryption') is-invalid @enderror"
                                            placeholder="Mail Encryption..." wire:model="mail_encryption">

                                        @error('mail_encryption')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group
                                            row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">Mail From Address</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('mail_from_address') is-invalid @enderror"
                                            placeholder="Enter
                                                Mail From Address..."
                                            wire:model="mail_from_address">
                                        @error('mail_from_address')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label for="taskname" class="col-form-label col-lg-2">Mail From Name</label>
                                    <div class="col-lg-10">
                                        <input type="text"
                                            class="form-control @error('mail_from_name') is-invalid @enderror"
                                            placeholder="Enter
                                                Mail From Name..."
                                            wire:model="mail_from_name">
                                        @error('mail_from_name')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row justify-content-end">
                        <div class="col-lg-10">
                            <button wire:click="testEmailConnection()" class="btn btn-info"
                                wire:loading.attr="disabled">Test Connection Email</button>
                            <button wire:click="save()" class="btn btn-primary" wire:loading.attr="disabled">Save
                                Configuration</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

</div>
