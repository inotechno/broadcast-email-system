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
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Edit Campaign</h4>
                    <p class="card-title-desc">Set a configuration edit campaign</p>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if ($tabActive == 'content') active @endif"
                                wire:click="$set('tabActive', 'content')" data-bs-toggle="tab" href="#content"
                                role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Content</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if ($tabActive == 'preview') active @endif" data-bs-toggle="tab"
                                href="#preview" wire:click="previewCampaign()" role="tab" aria-selected="false"
                                tabindex="-1">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Preview</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane @if ($tabActive == 'content') active @endif" id="content"
                            role="tabpanel">
                            <div class="mb-3">
                                <label for="subject">Campaign Subject</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    wire:model="subject">

                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3" wire:ignore.self>
                                <label for="message">Compose Message</label>
                                @livewire('component.trix-editor', ['message' => $message])

                                @error('message')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label>Attached Files <small class="text-warning">*
                                        Upload file max 10mb</small></label>
                                <input type="file" class="form-control @error('attachments') is-invalid @enderror"
                                    multiple wire:model="attachments">

                                @error('attachments')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    @foreach ($campaign_attachments as $attachment)
                                        <div class="col-md-4 mb-2">
                                            <div class="bg-light p-3 d-flex mb-3 rounded">
                                                <div class="flex-grow-1">
                                                    <h5 class="font-size-14"></i>
                                                        {{ $attachment->file_name }}</h5>
                                                    <p class="text-muted mb-0">{{ $attachment->file_size / 1024 }} KB
                                                    </p>
                                                </div>
                                                <a wire:click="deleteAttachment({{ $attachment->id }})" href="#"
                                                    class="bx bxs-x-circle text-danger h2 mt-2 flex-grow-2"></a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane @if ($tabActive == 'preview') active @endif" id="preview"
                            role="tabpanel">
                            {!! $previewContent !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-4" style="overflow-y: auto; max-height: 100vh;">
            <div class="card">
                <div class="card-body p-4">
                    <div class="search-box">
                        <p class="text-muted">Template</p>

                        <div class="btn-group-horizontal btn-group-sm" role="group">
                            @foreach ($templates as $template)
                                <input type="radio" class="btn-check" name="template" id="template1"
                                    autocomplete="off" wire:click="$set('template_id', {{ $template->id }})"
                                    @if ($template_id == $template->id) checked @endif>
                                <label class="btn btn-outline-danger" for="template1">{{ $template->title }}</label>
                            @endforeach
                        </div>

                        @error('template_id')
                            <div class="alert alert-danger">{{ $errors->first('template_id') }}</div>
                        @enderror
                    </div>

                    <hr class="my-2">

                    <div class="search-box">
                        <p class="text-muted">Categories</p>

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
                            <div class="alert alert-danger">{{ $errors->first('category_id') }}</div>
                        @enderror
                    </div>

                    <hr class="my-2">

                    <div class="">
                        <p class="text-muted">Scheduling</p>
                        <p wire:ignore.self>Dates and times are relative to the Server Time
                            Current Server Time is {{ $currentTime }} </p>

                        <div class="mb-3">
                            <label for="start_send_at">Start Send At</label>
                            <input type="datetime-local"
                                class="form-control @error('start_send_at') is-invalid @enderror"
                                wire:model="start_send_at">

                            @error('start_send_at')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="">
                        <p class="text-muted">Send Test</p>
                        <p wire:ignore.self> (comma separate addresses - all must be existing subscribers)
                        </p>
                        <div class="mb-3">
                            <label for="email_tests">Email Address(es)</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('email_tests') is-invalid @enderror"
                                    wire:model="email_tests" id="email_tests" aria-describedby="email_tests_button">
                                <button type="button" class="btn btn-primary" wire:click="sendTestCampaign()"
                                    id="email_tests_button">Send Test</button>
                            </div>

                            @error('email_tests')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-danger" wire:click="reset()">Reset</button>
                        <button class="btn btn-primary" wire:click="update()">Submit</button>
                    </div>

                </div>
            </div>
            <!-- end card -->
        </div>
    </div>

</div>


@push('plugin')
    <script>
        document.addEventListener('livewire:load', function() {

        });
    </script>
@endpush
