@extends('Admin.Layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $page_title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $page_title }} List</h3>
                            {{-- <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                data-target="#createBannerModal">
                                <i class="fas fa-plus"></i> Add New Banner
                            </button> --}}
                            <a href="" class="float-right btn btn-success btn-sm mr-2" data-toggle="modal"
                                data-target="#cacheCreateModal"> <i class="fas fa-plus-circle"></i> Add New Cache</a>
                            <a href="#" class="float-right btn btn-primary btn-sm mr-2" id="runAllBtn">
                                <i class="fas fa-sync-alt mr-1"></i> Regenerate All Cache
                            </a>

                            <!-- For links -->
                            <a href="#" class="float-right btn btn-danger btn-sm mr-2" id="deleteAllBtn">
                                <i class="fas fa-trash-alt mr-1"></i> Clear All Cache
                            </a>


                        </div>

                        <!-- Filter Section -->
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label for="dealerState">Cache State : </label>
                                    <select class="form-control submitable" id="dealerState">
                                        <option value="">Choose State</option>
                                        @foreach ($inventory_dealer_state as $stateData => $index)
                                            <option value="{{ $stateData }}">{{ $stateData }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover" id="data-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Name</th>
                                        <th>Command</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- View Banner Modal -->
    <div class="modal fade" id="viewBannerModal" tabindex="-1" role="dialog" aria-labelledby="viewBannerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewBannerModalLabel">Banner Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="viewBannerImage" src="" class="img-fluid rounded" alt="Banner Image">
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name:</th>
                                    <td id="viewBannerName"></td>
                                </tr>
                                <tr>
                                    <th>Position:</th>
                                    <td id="viewBannerPosition"></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td id="viewBannerStatus"></td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td id="viewBannerCreatedAt"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="cacheCreateModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create {{ $page_title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createCacheForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="cache_name" class="form-control" style="width: 100%;"
                                        required placeholder="Enter State County (e.g. Austin Travis) " id="cache_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Command</label>
                                    <input type="text" name="hide_cache_command" id="cache_command"
                                        class="form-control" style="width: 100%;" placeholder="add-austin-travis-cache"
                                        disabled>

                                    <input type="hidden" name="cache_command" id="hide_cache_command"
                                        class="form-control" style="width: 100%;" placeholder="add-austin-travis-cache">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="cache_city" id="cache_city" class="form-control"
                                        style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State (Short Name) <span class="text-danger">*</span></label>
                                    <input type="text" name="cache_state" id="cache_state" class="form-control"
                                        style="width: 100%;" maxlength="2" pattern="[A-Za-z]{2}"
                                        oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Zip Codes <span class="text-danger">*</span></label>
                                    <textarea name="zip_codes" class="form-control summernote" style="width: 100%;" cols="30" rows="5"
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>File Location</label>
                                    <input type="text" name="location" id="location" class="form-control"
                                        style="width: 100%;" disabled>
                                    <input type="hidden" name="hide_location" id="hide_location" class="form-control"
                                        style="width: 100%;">
                                    <input type="hidden" name="lastSegment" id="lastSegment" class="form-control"
                                        style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Status</label>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="createRadioPrimary1" name="status" value="1">
                                        <label for="createRadioPrimary1">Active</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="createRadioPrimary2" name="status" value="0"
                                            checked>
                                        <label for="createRadioPrimary2">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editCacheModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit {{ $page_title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCacheForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="hidden" name="cacheId" id="edit_cacheId" class="form-control"
                                        style="width: 100%;">
                                    <input type="text" name="cache_name" class="form-control" style="width: 100%;"
                                        required placeholder="Enter State County (e.g. Austin Travis) "
                                        id="edit_cache_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Command</label>
                                    <input type="text" name="hide_cache_command" id="edit_cache_command"
                                        class="form-control" style="width: 100%;" placeholder="add-austin-travis-cache"
                                        disabled>

                                    <input type="hidden" name="cache_command" id="edit_hide_cache_command"
                                        class="form-control" style="width: 100%;" placeholder="add-austin-travis-cache">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="cache_city" id="edit_cache_city" class="form-control"
                                        style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State (Short Name) <span class="text-danger">*</span></label>
                                    <input type="text" name="cache_state" id="edit_cache_state" class="form-control"
                                        style="width: 100%;" maxlength="2" pattern="[A-Za-z]{2}"
                                        oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Zip Codes <span class="text-danger">*</span></label>
                                    <textarea name="zip_codes" id="edit_zip_codes" class="form-control summernote" style="width: 100%;" cols="30"
                                        rows="5" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>File Location</label>
                                    <input type="text" name="location" id="edit_location" class="form-control"
                                        style="width: 100%;" disabled>
                                    <input type="hidden" name="hide_location" id="edit_hide_location"
                                        class="form-control" style="width: 100%;">
                                    <input type="hidden" name="lastSegment" id="edit_lastSegment" class="form-control"
                                        style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Status</label>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="editRadioPrimary1" name="status" value="1">
                                        <label for="editRadioPrimary1">Active</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="editRadioPrimary2" name="status" value="0">
                                        <label for="editRadioPrimary2">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            window.frontendConfig = {
                url: '{{ config('frontend.url') }}'
            };

            // Initialize DataTable
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                "ajax": {
                    "url": '{{ route('admin.cache-commands.index') }}',
                    "datatype": "json",
                    "dataSrc": "data",
                    "data": function(data) {
                        data.dealer_state = $('#dealerState').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'city',
                        name: 'city',
                    },
                    {
                        data: 'state',
                        name: 'state'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'command',
                        name: 'command'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']
                ]
            });

            $(document).on('change', '.submitable', function() {
                table.ajax.reload();
            });
            // Initialize custom file input
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Create cache form submission
            $('#createCacheForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Get the form data
                var formData = new FormData(this);
                var url = "{{ route('admin.cache-commands.store') }}";
                // You can also manually append data if needed
                // formData.append('key', 'value');

                // Show loading state if needed
                $('.modal-footer button[type="submit"]').html(
                    '<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

                // AJAX request
                $.ajax({
                    url: url, // Replace with your actual endpoint
                    type: 'POST',
                    data: formData,
                    processData: false, // Important for FormData
                    contentType: false, // Important for FormData
                    success: function(response) {
                        // Handle success
                        toastr.success('Cache created successfully!');
                        $('.modal-footer button[type="submit"]').html('Save').prop('disabled',
                            false);
                        table.draw(false);
                        $('#cacheCreateModal').modal('hide');
                        // Refresh data table or do whatever you need
                        // location.reload(); // If you want to reload the page

                        // Reset the form
                        $('#createCacheForm')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        var errorMessage = xhr.responseJSON.message || 'An error occurred';
                        toastr.error(errorMessage);
                    },
                    // complete: function() {

                    //     // Re-enable button


                    // }
                });
            });

            // View banner
            $(document).on('click', '.view-btn', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.banner.show') }}',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#viewBannerName').text(response.data.name);
                            $('#viewBannerPosition').text(response.data.position);
                            $('#viewBannerStatus').html(response.data.status ?
                                '<span class="badge bg-success">Active</span>' :
                                '<span class="badge bg-danger">Inactive</span>');
                            $('#viewBannerCreatedAt').text(response.data.created_at);

                            if (response.data.image) {
                                $('#viewBannerImage').attr('src',
                                    window.frontendConfig.url +
                                    '/dashboard/images/banners/' +
                                    response.data.image);
                            } else {
                                $('#viewBannerImage').attr('src',
                                    'https://via.placeholder.com/800x300?text=No+Image');
                            }

                            $('#viewBannerModal').modal('show');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to load banner details.');
                    }
                });
            });

            // Edit cached - load data
            $(document).on('click', '.edit-btn', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/admin/cache-commands/' + id + '/edit',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#edit_cacheId').val(response.data.id);
                            $('#edit_cache_name').val(toTitleCase(response.data.name));
                            $('#edit_cache_command').val(response.data.command);
                            $('#edit_hide_cache_command').val(response.data.command);
                            $('#edit_cache_city').val(response.data.city);
                            $('#edit_cache_state').val(response.data.state);
                            $('#edit_zip_codes').val(response.data.zip_codes);
                            $('#edit_location').val(response.data.cache_file);
                            $('#edit_hide_location').val(response.data.cache_file);
                            $('#edit_lastSegment').val(response.data.county);

                            // Set the correct radio button based on status
                            if (response.data.status == 1) {
                                $('#editRadioPrimary1').prop('checked', true);
                                $('#editRadioPrimary2').prop('checked', false);
                            } else {
                                $('#editRadioPrimary1').prop('checked', false);
                                $('#editRadioPrimary2').prop('checked', true);
                            }
                            // $('#edit_lastSegment').val(response.data.last_segment);
                            // $('#editStatus').prop('checked', response.data.status);



                            $('#editCacheModal').modal('show');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to load cache data for editing.');
                    }
                });
            });


            // Status toggle functionality
            $(document).on('click', '.status-toggle', function() {
                var id = $(this).data('id');
                var currentStatus = $(this).data('status');
                var newStatus = currentStatus ? 0 : 1;

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You want to ${newStatus ? 'activate' : 'deactivate'} this banner?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.cache-commands.status') }}',
                            type: 'POST',
                            data: {
                                id: id,
                                status: newStatus,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    table.draw(false);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function() {
                                toastr.error('Failed to update status');
                            }
                        });
                    }
                });
            });

            // Update cache form submission
            $('#editCacheForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $('#edit_cacheId').val();
                var editUrl = "{{ route('admin.cache-commands.update', ':id') }}".replace(':id', id);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PUT');

                $.ajax({
                    url: editUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#editCacheModal').modal('hide');
                            table.draw();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('An error occurred while updating the banner.');
                        }
                    }
                });
            });
        });

        // Delete All Cache Commands
        $(document).on('click', '.delete-cache', function() {
            var button = $(this); // Store button reference
            var id = button.data('id');
            var url = '{{ route('admin.cache-commands.delete', ':id') }}'.replace(':id', id);
            var originalHtml = button.html(); // Store original button content

            if (confirm('Are you sure you want to delete this cache?')) {
                // Add loading state
                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Deleting...');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE' // This tells Laravel to treat it as DELETE
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#data-table').DataTable().draw(false);
                        } else {
                            toastr.error(response.message || 'Failed to delete cache');
                        }
                    },
                    error: function(xhr) {
                        $('#data-table').DataTable().draw(false);
                        toastr.error('Error: ' + (xhr.responseJSON?.message ||
                            'Failed to delete cache'));
                    },
                    complete: function() {
                        // Restore original button state
                        button.prop('disabled', false).html(originalHtml);
                    }
                });
            }
        });

        // Run all commands
        $('#runAllBtn').click(function(e) {
            e.preventDefault(); // Prevent default button behavior

            if (confirm('Are you sure you want to run all cache commands?')) {
                // Store original button HTML
                var originalHtml = $(this).html();

                // Add loading state
                $(this).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                $(this).prop('disabled', true);

                $.post('{{ route('admin.cache-commands.run-all') }}', {
                        _token: '{{ csrf_token() }}'
                    }, function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#data-table').DataTable().draw(false);
                        }
                    })
                    .always(function() {
                        // Restore original button state whether success or fail
                        $('#runAllBtn').html(originalHtml);
                        $('#runAllBtn').prop('disabled', false);
                    })
                    .fail(function(xhr) {
                        // Handle errors if needed
                        toastr.error(xhr.responseJSON.message || 'An error occurred');
                    });
            }
        });



        $(document).on('click', '.run-command', function() {
            var button = $(this); // Store button reference
            var id = button.data('id');
            var url = '{{ route('admin.api.cache-commands.run', ['id' => ':id']) }}'.replace(':id', id);
            var originalHtml = button.html(); // Store original HTML

            if (confirm('Are you sure you want to run this command?')) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        // Show loading indicator using stored button reference
                        button.prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Running...');
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#data-table').DataTable().draw(false);
                        } else {
                            toastr.error(response.message || 'Command execution failed');
                        }
                    },
                    error: function(xhr) {
                        $('#data-table').DataTable().draw(false);
                        toastr.error('Error: ' + (xhr.responseJSON?.message ||
                            'Command execution failed'));
                    },
                    complete: function() {
                        // Re-enable button using stored button reference
                        button.prop('disabled', false).html(originalHtml);
                    }
                });
            }
        });

        // Delete All Cache Commands
        $('#deleteAllBtn').click(function(e) {
            e.preventDefault(); // Prevent default behavior

            if (confirm('Are you sure you want to delete all cache commands?')) {
                // Store original button HTML
                var originalHtml = $(this).html();

                // Add loading state
                $(this).html('<i class="fas fa-spinner fa-spin"></i> Deleting...');
                $(this).prop('disabled', true);

                $.post('{{ route('admin.cache-commands.delete-all') }}', {
                        _token: '{{ csrf_token() }}'
                    }, function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#data-table').DataTable().draw(false);
                        } else {
                            toastr.error(response.message || 'Failed to delete cache commands');
                        }
                    })
                    .always(function() {
                        // Restore original button state
                        $('#deleteAllBtn').html(originalHtml);
                        $('#deleteAllBtn').prop('disabled', false);
                    })
                    .fail(function(xhr) {
                        toastr.error(xhr.responseJSON?.message ||
                            'An error occurred while deleting cache commands');
                    });
            }
        });
    </script>

    <script>
        function toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }
    </script>

    <script>
        $(document).on('keyup', '#cache_name', function() {
            var cacheName = $(this).val();
            var command = cacheName.toLowerCase().replace(/\s+/g, '-');
            // let lastSegment = command.split(/[\s-]+/).pop().toLowerCase();
            lastSegment = command.replace('-', '_')
            var cus_command = 'add-' + command + '-cache';

            $('#cache_command').val(cus_command);
            $('#hide_cache_command').val(cus_command);

            // var baseUrl = window.location.origin;
            // var fullPath = baseUrl + "/storage/app/travis_county.json";
            // alert(fullPath);

            var storagePathPattern = {!! json_encode(str_replace('/', '\\', storage_path('app/'))) !!};

            // var storagePathPattern = "{!! str_replace('/', '\\\\', storage_path('app/')) !!}";
            var fullPath = storagePathPattern + lastSegment + "_county.json";

            $('#lastSegment').val(lastSegment);
            $('#location').val(fullPath);
            $('#hide_location').val(fullPath);
        });

        $(document).on('keyup', '#edit_cache_name', function() {
            var cacheName = $(this).val();
            var command = cacheName.toLowerCase().replace(/\s+/g, '-');
            // let lastSegment = command.split(/[\s-]+/).pop().toLowerCase();
            lastSegment = command.replace('-', '_')
            var cus_command = 'add-' + command + '-cache';

            $('#edit_cache_command').val(cus_command);
            $('#edit_hide_cache_command').val(cus_command);

            // var baseUrl = window.location.origin;
            // var fullPath = baseUrl + "/storage/app/travis_county.json";
            // alert(fullPath);

            var storagePathPattern = {!! json_encode(str_replace('/', '\\', storage_path('app/'))) !!};

            // var storagePathPattern = "{!! str_replace('/', '\\\\', storage_path('app/')) !!}";
            var fullPath = storagePathPattern + lastSegment + "_county.json";

            $('#edit_lastSegment').val(lastSegment);
            $('#edit_location').val(fullPath);
            $('#edit_hide_location').val(fullPath);
        })
    </script>
@endpush
