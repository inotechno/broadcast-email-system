<div class="container-fluid">

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Campaign List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Campaign</a></li>
                            <li class="breadcrumb-item active">Campaign List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 70px;">
                                    #
                                </th>
                                <th scope="col">Campaign</th>
                                <th scope="col">From Address</th>
                                <th scope="col">Estimation Time</th>
                                <th scope="col">Template</th>
                                <th scope="col">Status</th>
                                <th scope="col">Categories</th>
                                <th scope="col">Progress</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($campaigns as $key => $campaign)
                                <tr wire:key="campaign-{{ $campaign->id }}">
                                    <td>
                                        <div class="form-check">
                                            {{ $key + 1 }}
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a href="javascript: void(0);"
                                                class="text-dark">{{ $campaign->subject }}</a></h5>
                                        <p class="text-muted mb-0">{{ $campaign->start_send_at }}</p>
                                    </td>
                                    <td>{{ $campaign->from_email ?? 'Tidak ada' }}</td>
                                    <td>
                                        @if ($campaign->total_queue != 0)
                                            {{ \Carbon\Carbon::now()->addSeconds($campaign->total_queue * 2)->format('Y-m-d H:i:s') }}
                                        @else
                                            Tidak ada
                                        @endif
                                    </td>
                                    <td>{{ $campaign->template->title }}</td>
                                    <td>
                                        @if ($campaign->status == 'draft')
                                            <span class="badge bg-warning fs-6">Draft</span>
                                        @elseif ($campaign->executed)
                                            <span class="badge bg-success fs-6">Executed</span>
                                        @else
                                            <span class="badge bg-primary fs-6">Active/Not Executed</span>
                                        @endif

                                    </td>
                                    <td>
                                        <div>
                                            @foreach ($campaign->categories as $category)
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block">

                                                        <div class="avatar-xs" wire:click="edit({{ $category->id }})"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-update-category">
                                                            <span
                                                                class="avatar-title rounded-circle bg-success text-white font-size-16"
                                                                data-bs-placement="top" title="{{ $category->name }}"
                                                                data-bs-toggle="tooltip">
                                                                {{ mb_substr($category->name, 0, 1) }}
                                                            </span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-danger fs-6" data-bs-placement="top" title="Total Failed"
                                            data-bs-toggle="tooltip">
                                            <i class="bx bx-error-alt"></i>
                                            {{ $campaign->total_failed }}
                                        </span>

                                        <span class="badge bg-secondary fs-6" data-bs-placement="top"
                                            title="Total Pending" data-bs-toggle="tooltip">
                                            <i class="bx bx-cloud-upload"></i>
                                            {{ $campaign->total_pending }}
                                        </span>

                                        <span class="badge bg-warning fs-6" data-bs-placement="top"
                                            title="Total Progress" data-bs-toggle="tooltip">
                                            <i class="bx bx-loader"></i>
                                            {{ $campaign->total_queue }}
                                        </span>

                                        <span class="badge bg-info fs-6" data-bs-placement="top" title="Total Sent"
                                            data-bs-toggle="tooltip">
                                            <i class="bx bx-send"></i>
                                            {{ $campaign->total_sent }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#"
                                                    wire:click="getCampaign({{ $campaign->id }})"
                                                    data-bs-toggle="modal" data-bs-target="#modal-resend"><span
                                                        class="fas fa-sync-alt"></span> Resend Failed</a>
                                                <a class="dropdown-item" href="#"
                                                    wire:click="getCampaign({{ $campaign->id }})"
                                                    data-bs-toggle="modal" data-bs-target="#modal-draft"><span
                                                        class="fas fa-file-contract"></span> Draft</a>
                                                <a class="dropdown-item" href="#"
                                                    wire:click="getCampaign({{ $campaign->id }})"
                                                    data-bs-toggle="modal" data-bs-target="#modal-duplicate"><span
                                                        class="fas fa-copy"></span> Duplicate</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('campaign.edit', $campaign->id) }}"><span
                                                        class="fas fa-edit"></span> Edit</a>
                                                <a class="dropdown-item" href="#"
                                                    wire:click="getCampaign({{ $campaign->id }})"
                                                    data-bs-toggle="modal" data-bs-target="#modal-delete"><span
                                                        class="fas fa-trash-alt"></span> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $campaigns->links('livewire.pagination') }}

            </div>
        </div>
    </div>

    <div wire:ignore.self id="modal-resend" class="modal fade" tabindex="-1" aria-labelledby="resendCampaign"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resendCampaign">Resend Campaign Failed</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to resend of this campaign failed?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" form="form-add-group" wire:click.prevent="resendCampaign()"
                        class="btn btn-primary" wire:loading.attr="disabled">Resend</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="modal-delete" class="modal fade" tabindex="-1" aria-labelledby="deleteCampaign"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCampaign">Delete Campaign</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete of this campaign?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="deleteCampaign()" class="btn btn-primary"
                        wire:loading.attr="disabled">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="modal-duplicate" class="modal fade" tabindex="-1" aria-labelledby="duplicateCampaign"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicateCampaign">Duplicate Campaign</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to create a duplicate of this campaign?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" form="form-add-group" wire:click.prevent="duplicateCampaign()"
                        class="btn btn-primary" wire:loading.attr="disabled">Duplicate</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="modal-draft" class="modal fade" tabindex="-1" aria-labelledby="draftCampaign"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="draftCampaign">Draft Campaign</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to set draft of this campaign?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" form="form-add-group" wire:click.prevent="draftCampaign()"
                        class="btn btn-primary" wire:loading.attr="disabled">Draft</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('plugin')
    <script>
        document.addEventListener('livewire:load', function() {
            window.addEventListener('close-modal', event => {
                $('#modal-resend').modal('hide');
                $('#modal-duplicate').modal('hide');
                $('#modal-draft').modal('hide');
                $('#modal-delete').modal('hide');
            });
        });
    </script>
@endpush
