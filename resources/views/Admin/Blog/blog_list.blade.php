@extends('Admin.Layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $type }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $type }}</li>
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
                            <h3 class="card-title">{{ $type }} List</h3>
                            <a href="#" class="float-right btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#blogCreateModal">
                                <i class="fas fa-plus-circle"></i> Add {{ $type }}
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover" id="data-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Create Date</th>
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

    {{-- Create Modal --}}
    <div class="modal fade" id="blogCreateModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create {{ $type }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createBlogForm" enctype="multipart/form-data">
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control select2bs4" name="category_id" style="width: 100%;"
                                        required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Category</label>
                                    <select class="form-control select2bs4" name="sub_category_id" style="width: 100%;"
                                        required>
                                        <option value="">Select Sub-Category</option>
                                        @foreach ($sub_categories as $subCategory)
                                            <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" style="width: 100%;" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sub Title</label>
                                    <textarea name="sub_title" class="form-control" style="width: 100%;" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control summernote" style="width: 100%;" cols="30" rows="5"
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>SEO Description</label>
                                    <input type="text" name="seo_description" class="form-control" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>SEO Keywords</label>
                                    <input type="text" name="seo_keywords" class="form-control" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Hash Keywords</label>
                                    <input type="text" name="hashKeyword" class="form-control" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Status</label>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="createRadioPrimary1" name="status" checked
                                            value="1">
                                        <label for="createRadioPrimary1">Active</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="createRadioPrimary2" name="status" value="0">
                                        <label for="createRadioPrimary2">Inactive</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="createImageInput">Blog Image</label>
                                <input type="file" name="image" class="form-control" id="createImageInput">
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
    <div class="modal fade" id="blogEditModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit {{ $type }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editBlogForm" enctype="multipart/form-data">
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <input type="hidden" name="id" id="editBlogId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control select2bs4" name="category_id" id="editCategoryId"
                                        style="width: 100%;" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Category</label>
                                    <select class="form-control select2bs4" name="sub_category_id" id="editSubCategoryId"
                                        style="width: 100%;" required>
                                        <option value="">Select Sub-Category</option>
                                        @foreach ($sub_categories as $subCategory)
                                            <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" id="editTitle" class="form-control"
                                        style="width: 100%;" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sub Title</label>
                                    <textarea name="sub_title" id="editSubTitle" class="form-control" style="width: 100%;" cols="30"
                                        rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" id="editDescription" class="form-control summernote" style="width: 100%;"
                                        cols="30" rows="5" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>SEO Description</label>
                                    <input type="text" name="seo_description" id="editSeoDescription"
                                        class="form-control" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>SEO Keywords</label>
                                    <input type="text" name="seo_keywords" id="editSeoKeywords" class="form-control"
                                        style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Hash Keywords</label>
                                    <input type="text" name="hashKeyword" id="editHashKeyword" class="form-control"
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
                            <div class="col-md-6">
                                <label>Current Image</label>
                                <div id="currentImageContainer" class="mb-2"></div>
                                <label for="editImageInput">Change Image</label>
                                <input type="hidden" name="old_image" class="form-control" id="oldEditImageInput">
                                <input type="file" name="image" class="form-control" id="editImageInput">
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
        window.frontendConfig = {
            url: '{{ config('frontend.url') }}'
        };

        $(function() {
            // Initialize summernote
            // $('.summernote').summernote({
            //     height: 200,
            //     toolbar: [
            //         ['style', ['style']],
            //         ['font', ['bold', 'italic', 'underline', 'clear']],
            //         ['fontname', ['fontname']],
            //         ['color', ['color']],
            //         ['para', ['ul', 'ol', 'paragraph']],
            //         ['height', ['height']],
            //         ['table', ['table']],
            //         ['insert', ['link', 'picture', 'hr']],
            //         ['view', ['fullscreen', 'codeview']],
            //         ['help', ['help']]
            //     ]
            // });

            // // Initialize select2
            // $('.select2bs4').select2({
            //     theme: 'bootstrap4'
            // });
            $('.summernote').summernote();
            var type = "{{ $type }}";

            // DataTable initialization
            var dataTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route($route) }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'img',
                        name: 'blogs.img',
                        // render: function(data) {
                        //     return data ?
                        //         '<img src="https://bestdreamcar.com/frontend/assets/images/blog/' +
                        //         data + '" width="50">' :
                        //         'No Image';
                        // }
                    },
                    {
                        data: 'title',
                        name: 'blogs.title'
                    },
                    {
                        data: 'created_at',
                        name: 'blogs.created_at',
                        render: function(data) {
                            return moment(data).format('MM-DD-YYYY');
                        }
                    },
                    {
                        data: 'status',
                        name: 'blogs.status',
                        // render: function(data) {
                        //     return data ?
                        //         '<span class="badge bg-success">Active</span>' :
                        //         '<span class="badge bg-danger">Inactive</span>';
                        // }
                    },
                    {
                        data: 'action',
                        name: 'action',
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

            // Create blog form submission
            $('#createBlogForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('admin.blog.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === "success") {
                            toastr.success(response.message);
                            $('#blogCreateModal').modal('hide');
                            dataTable.draw(false);
                            $('#createBlogForm')[0].reset();
                            $('.summernote').summernote('reset');
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
                            toastr.error('An error occurred');
                        }
                    }
                });
            });

            // Edit blog - open modal
            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.blog.edit') }}',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $('#editBlogId').val(response.id);
                        $('#editCategoryId').val(response.category_id).trigger('change');
                        $('#editSubCategoryId').val(response.sub_category_id).trigger('change');
                        $('#editTitle').val(response.title);
                        $('#editSubTitle').val(response.sub_title);
                        $('#editDescription').summernote('code', response.description);
                        $('#editSeoDescription').val(response.seo_description);
                        $('#editSeoKeywords').val(response.seo_keyword);
                        $('#editHashKeyword').val(response.hash_keyword);
                        $('#oldEditImageInput').val(response.img);

                        // Set status radio buttons
                        if (response.status == 1) {
                            $('#editRadioPrimary1').prop('checked', true);
                        } else {
                            $('#editRadioPrimary2').prop('checked', true);
                        }

                        // Display current image
                        var imageHtml = response.img ?
                            '<img src="' + window.frontendConfig.url +
                            '/frontend/assets/images/blog/' +
                            response.img + '" width="100" class="img-thumbnail mb-2">' :
                            '<p>No image</p>';
                        $('#currentImageContainer').html(imageHtml);

                        $('#blogEditModal').modal('show');
                    },
                    error: function() {
                        toastr.error('Failed to load blog data');
                    }
                });
            });

            // Update blog form submission
            $('#editBlogForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PUT');

                $.ajax({
                    url: '{{ route('admin.blog.update') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === "success") {
                            toastr.success(response.message);
                            $('#blogEditModal').modal('hide');
                            dataTable.draw(false);
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
                            toastr.error('An error occurred');
                        }
                    }
                });
            });

            // View blog details
            $(document).on('click', '.view', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.blog.show') }}',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var imageUrl = response.img ?
                            `${window.frontendConfig.url}/frontend/assets/images/blog/${response.img}` :
                            `${window.frontendConfig.url}/frontend/assets/images/blog/default.jpg`;
                        var modalHtml = `
                            <div class="modal fade" id="viewBlogModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">${type} Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="${imageUrl}" class="img-fluid" alt="Blog Image">
                                                </div>
                                                <div class="col-md-8">
                                                    <h3>${response.title}</h3>
                                                    <p><strong>Category:</strong> ${response.category_name}</p>
                                                    <p><strong>Sub Category:</strong> ${response.sub_category_name}</p>
                                                    <p><strong>Status:</strong> ${response.status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'}</p>
                                                    <p><strong>Created At:</strong> ${moment(response.created_at).format('MMMM Do YYYY, h:mm a')}</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <h4>Description</h4>
                                                    <div class="border p-2">${response.description}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        $('body').append(modalHtml);
                        $('#viewBlogModal').modal('show');

                        $('#viewBlogModal').on('hidden.bs.modal', function() {
                            $(this).remove();
                        });
                    },
                    error: function() {
                        toastr.error('Failed to load blog details');
                    }
                });
            });

            // Toggle status
            $(document).on('click', '.status-toggle', function() {
                var id = $(this).data('id');
                var currentStatus = $(this).data('status');
                var newStatus = currentStatus ? 0 : 1;

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You want to ${newStatus ? 'activate' : 'deactivate'} this blog?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.blog.status') }}',
                            type: 'POST',
                            data: {
                                id: id,
                                status: newStatus,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === "success") {
                                    toastr.success(response.message);
                                    dataTable.draw(false);
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

            // Delete blog
            $(document).on('click', '.delete', function() {
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
                            url: '{{ route('admin.blog.destroy') }}',
                            type: 'DELETE',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === "success") {
                                    toastr.success(response.message);
                                    dataTable.draw(false);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function() {
                                toastr.error('Failed to delete blog');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
