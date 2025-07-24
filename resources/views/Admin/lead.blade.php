@extends('Admin.Layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lead</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Lead</li>
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
                            <h3 class="card-title">Banner List</h3>
                            {{-- <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                data-target="#createBannerModal">
                                <i class="fas fa-plus"></i> Add New Banner
                            </button> --}}
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover" id="data-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Title</th>
                                        <th>Make</th>
                                        <th>Dealer</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Customer Phone</th>
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

    <!-- Create Banner Modal -->
    <div class="modal fade" id="createBannerModal" tabindex="-1" role="dialog" aria-labelledby="createBannerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBannerModalLabel">Create New Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createBannerForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Banner Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <select class="form-control" id="position" name="position" required>
                                <option value="">Select Position</option>
                                <option value="top">Top</option>
                                <option value="middle">Middle</option>
                                <option value="bottom">Bottom</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Banner Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image"
                                    accept="image/*" required>
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            <small class="form-text text-muted">Recommended size: 1920x600 pixels</small>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <!-- Edit Banner Modal -->
    <div class="modal fade" id="editBannerModal" tabindex="-1" role="dialog" aria-labelledby="editBannerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBannerModalLabel">Edit Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editBannerForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editBannerId" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editName">Banner Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                            <input type="hidden" name="old_image" class="form-control" id="oldEditImageInput">
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="hiddenEditPosition" name="position">
                            <label for="editPosition">Position</label>
                            <select class="form-control" id="editPosition" name="positionDisabled" disabled>
                                <option value="">Select Position</option>
                                {{-- @foreach ($banners as $position => $positionId)
                                    <option value="{{ $position }}">{{ ucwords($position) }}</option>
                                @endforeach --}}

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Current Image</label>
                            <img id="currentBannerImage" src="" class="img-fluid rounded mb-2"
                                style="max-height: 150px;">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="editImage" name="image"
                                    accept="image/*">
                                <label class="custom-file-label" for="editImage">Change image (optional)</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="editStatus" name="status">
                                <label class="custom-control-label" for="editStatus">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- url Banner Modal -->
    <div class="modal fade" id="linkBannerModal" tabindex="-1" role="dialog" aria-labelledby="linkBannerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="linkBannerModalLabel">Edit Banner URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="linkBannerForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="linkBannerId" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editName">URL</label>
                            <input type="text" class="form-control" id="editUrl" name="editUrl" required>
                        </div>
                        <div class="form-group">
                            <label>Open in New Window</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="linkNewWindow" name="NewWindow">
                                <label class="custom-control-label" for="linkNewWindow">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Banner URL</button>
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
                ajax: '{{ route('admin.lead.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'main_inventories.title' // Map to actual table.column
                    },
                    {
                        data: 'make',
                        name: 'main_inventories.make'
                    },
                    {
                        data: 'dealer_name',
                        name: 'dealers.name'
                    },
                    {
                        data: 'dealer_city',
                        name: 'dealers.city'
                    },
                    {
                        data: 'dealer_state',
                        name: 'dealers.state'
                    },
                    {
                        data: 'user_name',
                        name: 'users.name'
                    },
                    {
                        data: 'user_email',
                        name: 'users.email'
                    },
                    {
                        data: 'user_phone',
                        name: 'users.phone'
                    },
                    {
                        data: 'status',
                        name: 'leads.status',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '15%',
                        orderable: false,
                        searchable: false
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

            // Initialize custom file input
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Create banner form submission
            $('#createBannerForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.banner.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#createBannerModal').modal('hide');
                            table.draw();
                            $('#createBannerForm')[0].reset();
                            $('.custom-file-label').html('Choose file');
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
                            toastr.error('An error occurred while creating the banner.');
                        }
                    }
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

            // link banner - load data
            $(document).on('click', '.link-btn', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route('admin.banner.link') }}',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#linkBannerId').val(response.data.id);
                            $('#editUrl').val(response.data.url);
                            $('#linkNewWindow').prop('checked', response.data.new_window);

                            $('#linkBannerModal').modal('show');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to load banner data for editing.');
                    }
                });
            });

            // link banner form submission
            $('#linkBannerForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $('#linkBannerId').val();
                formData.set('status', $('#linkNewWindow').is(':checked') ? 1 : 0);

                $.ajax({
                    url: '{{ route('admin.banner.link.update') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#linkBannerModal').modal('hide');
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
                            toastr.error('An error occurred while updating the URL.');
                        }
                    }
                });
            });

            // Edit banner - load data
            $(document).on('click', '.edit-btn', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.banner.edit') }}',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#editBannerId').val(response.data.id);
                            $('#editName').val(toTitleCase(response.data.name));
                            $('#editPosition').val(response.data.position);
                            $('#hiddenEditPosition').val(response.data.position);
                            $('#oldEditImageInput').val(response.data.image);
                            $('#editStatus').prop('checked', response.data.status);

                            if (response.data.image) {
                                $('#currentBannerImage').attr('src',
                                    window.frontendConfig.url +
                                    '/dashboard/images/banners/' +
                                    response.data.image);
                            } else {
                                $('#currentBannerImage').attr('src',
                                    'https://via.placeholder.com/800x300?text=No+Image');
                            }

                            $('#editBannerModal').modal('show');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to load banner data for editing.');
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
                            url: '{{ route('admin.banner.status') }}',
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

            // Update banner form submission
            $('#editBannerForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $('#editBannerId').val();
                formData.set('status', $('#editStatus').is(':checked') ? 1 : 0);

                $.ajax({
                    url: '{{ route('admin.banner.update') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#editBannerModal').modal('hide');
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



            // Delete banner
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.banner.destroy') }}',
                            type: 'DELETE',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    table.draw();
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function() {
                                toastr.error('Failed to delete the banner.');
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }
    </script>
@endpush
