@extends('Admin.Layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>General Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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
                            <h3 class="card-title">Settings List</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover" id="data-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Site Title</th>
                                        <th>Logo</th>
                                        <th>Slider</th>
                                        <th>Favicon</th>
                                        <th>Language</th>
                                        <th>TimeZone</th>
                                        <th>Date Format</th>
                                        <th>Time Format</th>
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

    <!-- Edit Settings Modal -->
    <div class="modal fade" id="editSettingsModal" tabindex="-1" role="dialog" aria-labelledby="editSettingsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSettingsModalLabel">Edit Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editSettingsForm" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="editSettingsId" name="id">
                    <div class="modal-body">
                        <!-- Form fields remain the same as your original code -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Site Title</label>
                                    <input type="text" class="form-control" id="site_title" name="site_title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Slider Title</label>
                                    <input type="text" class="form-control" id="slider_title" name="slider_title"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editName">Slider Sub Title</label>
                            {{-- <textarea name="" id="" cols="30" rows="3" class="form-control" id="slider_subtitle" name="slider_subtitle"></textarea> --}}
                            <input type="text" class="form-control" id="slider_subtitle" name="slider_subtitle" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Pagination</label>
                                    <input type="text" class="form-control" id="pagination" name="pagination" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Sitemap</label>
                                    <input type="text" class="form-control" id="site_map" name="site_map" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Language</label>
                                    <input type="text" class="form-control" id="language" name="language" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Seperator</label>
                                    <input type="text" class="form-control" id="separator" name="separator" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Timezone</label>
                                    <input type="text" class="form-control" id="timezone" name="timezone" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Time Formator</label>
                                    <input type="text" class="form-control" id="time_formate" name="time_formate"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editName">Date Formator</label>
                                    <input type="text" class="form-control" id="date_formate" name="date_formate"
                                        required>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="editName">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>

                        <div class="form-group">
                            <label>Current Slider Image</label>
                            <img id="currentSliderImage" src="" class="img-fluid rounded mb-2"
                                style="max-height: 150px;">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="slider_image" name="slider_image"
                                    accept="image/*">
                                <input type="hidden" name="old_slider_image" id="old_slider_image" class="form-control"
                                    id="oldSliderEditImageInput">
                                <label class="custom-file-label" for="editImage">Change Slider Image</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Logo Image</label>
                                    <img id="currentLogoImage" src="" class="img-fluid rounded mb-2"
                                        style="max-height: 150px;  border: 1px solid black">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image"
                                            accept="image/*">
                                        <input type="hidden" name="old_logo_image" id="old_logo_image"
                                            class="form-control" id="oldLogoEditImageInput">
                                        <label class="custom-file-label" for="editImage">Change Logo Image</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Favicon Image</label>
                                    <img id="currentFaviconImage" src="" class="img-fluid rounded mb-2"
                                        style="max-height: 150px; border: 1px solid black">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="fav_image" name="fav_image"
                                            accept="image/*">
                                        <input type="hidden" name="old_favicon_image" id="old_favicon_image"
                                            class="form-control" id="oldfaviconEditImageInput">
                                        <label class="custom-file-label" for="editImage">Change Favicon image</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ... -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Set frontend URL from config
            window.frontendConfig = {
                url: '{{ config('frontend.url') }}',
                logoPath: '/frontend/assets/images/logos/'
            };

            // Initialize DataTable
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.settings.general') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'site_title',
                        name: 'site_title'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            return data ?
                                `<img src="${window.frontendConfig.url}${window.frontendConfig.logoPath}${data}" style="max-height: 50px; border: 1px solid #ddd;">` :
                                'No Image';
                        }
                    },
                    {
                        data: 'slider_image',
                        name: 'slider_image',
                        render: function(data, type, full, meta) {
                            return data ?
                                `<img src="${window.frontendConfig.url}${window.frontendConfig.logoPath}${data}" style="max-height: 50px; border: 1px solid #ddd;">` :
                                'No Image';
                        }
                    },
                    {
                        data: 'fav_image',
                        name: 'fav_image',
                        render: function(data, type, full, meta) {
                            return data ?
                                `<img src="${window.frontendConfig.url}${window.frontendConfig.logoPath}${data}" style="max-height: 50px; border: 1px solid #ddd;">` :
                                'No Image';
                        }
                    },
                    {
                        data: 'language',
                        name: 'language'
                    },
                    {
                        data: 'timezone',
                        name: 'timezone'
                    },
                    {
                        data: 'date_formate',
                        name: 'date_formate'
                    },
                    {
                        data: 'time_formate',
                        name: 'time_formate'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return `
                                <button class="btn btn-info btn-sm edit-btn" data-id="${full.id}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            `;
                        }
                    }
                ],
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']
                ]
            });

            // Edit settings - load data
            $(document).on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                var $modal = $('#editSettingsModal');

                $.ajax({
                    url: '{{ route('admin.settings.edit') }}',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            // Fill form fields
                            $('#editSettingsId').val(response.data.id);
                            $('#site_title').val(response.data.site_title);
                            $('#slider_title').val(response.data.slider_title);
                            $('#slider_subtitle').val(response.data.slider_subtitle);
                            $('#pagination').val(response.data.pagination);
                            $('#language').val(response.data.language);
                            $('#separator').val(response.data.separator);
                            $('#timezone').val(response.data.timezone);
                            $('#time_formate').val(response.data.time_formate);
                            $('#date_formate').val(response.data.date_formate);
                            $('#site_map').val(response.data.site_map);
                            $('#email').val(response.data.email);
                            $('#phone').val(response.data.phone);

                            // Set hidden fields for old images
                            $('#old_slider_image').val(response.data.slider_image);
                            $('#old_logo_image').val(response.data.image);
                            $('#old_favicon_image').val(response.data.fav_image);

                            // Set current images with proper paths
                            setImagePreview('currentLogoImage', response.data.image);
                            setImagePreview('currentFaviconImage', response.data.fav_image);
                            setImagePreview('currentSliderImage', response.data.slider_image);

                            // Reset file inputs
                            $('.custom-file-input').val('');
                            $('.custom-file-label').removeClass("selected").html('Choose file');

                            $modal.modal('show');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to load settings data.');
                    }
                });
            });

            // Helper function to set image previews
            function setImagePreview(elementId, imageName) {
                var $element = $('#' + elementId);
                if (imageName) {
                    $element.attr('src', window.frontendConfig.url + window.frontendConfig.logoPath + imageName)
                        .css('display', 'block');
                } else {
                    $element.attr('src', 'https://via.placeholder.com/150?text=No+Image')
                        .css('display', 'block');
                }
            }

            // Update settings form submission
            $('#editSettingsForm').submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                var $submitBtn = $form.find('button[type="submit"]');

                // Show loading state
                $submitBtn.prop('disabled', true).html(
                '<i class="fas fa-spinner fa-spin"></i> Updating...');

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.settings.update') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#editSettingsModal').modal('hide');
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
                            toastr.error('An error occurred while updating the settings.');
                            console.error(xhr.responseText);
                        }
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html('Update Settings');
                    }
                });
            });

            // File input handling
            $('.custom-file-input').on('change', function() {
                var $input = $(this);
                var fileName = $input.val().split('\\').pop();
                $input.next('.custom-file-label').addClass("selected").html(fileName);

                // Preview image
                var previewId = $input.closest('.form-group').find('img').attr('id');
                readURL(this, previewId);
            });

            // Image preview function
            function readURL(input, previewId) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#' + previewId).attr('src', e.target.result).css('display', 'block');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Reset form when modal closes
            $('#editSettingsModal').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
                $('.custom-file-label').removeClass("selected").html('Choose file');
            });
        });
    </script>
@endpush
