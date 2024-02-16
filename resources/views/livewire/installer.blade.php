<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Wizard Installation</h4>

                    <div id="basic-example">

                        @if ($step === 1)
                            <!-- Database Configuration -->
                            <h3>Database Configuration</h3>
                            <section id="step-1">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="host">Host Name</label>
                                            <input type="text"
                                                class="form-control @error('host') is-invalid @enderror"
                                                wire:model="host" id="host" placeholder="Enter Hostname">

                                            @error('host')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="port">Port</label>
                                            <input type="number"
                                                class="form-control @error('port') is-invalid @enderror"
                                                wire:model="port" id="port" placeholder="Enter Port">

                                            @error('port')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="database">Database Name</label>
                                            <input type="text"
                                                class="form-control @error('database') is-invalid @enderror"
                                                wire:model="database" id="database" placeholder="Enter Database Name">
                                            @error('database')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="username">Username</label>
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                wire:model="username" id="username" placeholder="Enter Username">
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="password">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                wire:model="password" id="password" placeholder="Enter Password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @elseif($step === 2)
                            <!-- Application Configuration -->
                            <h3>Application Configuration</h3>
                            <section id="step-2">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="app_name">Application Name</label>
                                            <input type="text"
                                                class="form-control @error('app_name') is-invalid @enderror"
                                                id="app_name" placeholder="Enter Application Name"
                                                wire:model="app_name">
                                            @error('app_name')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="app_url">Application URL</label>
                                            <input type="text"
                                                class="form-control @error('app_url') is-invalid @enderror"
                                                id="app_url" placeholder="Enter Application URL" wire:model="app_url">
                                            @error('app_url')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </section>
                        @endif
                    </div>

                    <div>
                        @if ($step > 1)
                            <button class="btn btn-secondary" wire:click="previousStep">Previous</button>
                        @endif

                        @if ($step < 2)
                            <button class="btn btn-info" wire:click="nextStep">Next</button>
                        @else
                            <button class="btn btn-primary" wire:click="saveData"
                                wire:loading.attr="disabled">Submit</button>
                        @endif
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
</div>
