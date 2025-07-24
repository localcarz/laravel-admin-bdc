@extends('Admin.Layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inventories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Inventories</li>
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
                            <h3 class="card-title">Inventory List</h3>
                            <a href="{{ route('admin.inventory.create') }}" class="float-right btn btn-primary btn-sm">
                                <i class="fas fa-plus-circle"></i> Add Inventory
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover table-responsive]" id="data-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Stock</th>
                                        <th>VIN</th>
                                        <th>Year</th>
                                        <th>Make</th>
                                        <th>Model</th>
                                        <th>Dealer</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Listing Date</th>
                                        <th>Active Start</th>
                                        <th>Active Till</th>
                                        <th>Package</th>
                                        <th>Visibility</th>
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

    <!-- View Inventory Modal -->
    <div class="modal fade" id="viewInventoryModal" tabindex="-1" role="dialog" aria-labelledby="viewInventoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewInventoryModalLabel">Inventory Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Basic Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Stock #:</th>
                                    <td id="viewStock"></td>
                                </tr>
                                <tr>
                                    <th>VIN:</th>
                                    <td id="viewVin"></td>
                                </tr>
                                <tr>
                                    <th>Year:</th>
                                    <td id="viewYear"></td>
                                </tr>
                                <tr>
                                    <th>Make:</th>
                                    <td id="viewMake"></td>
                                </tr>
                                <tr>
                                    <th>Model:</th>
                                    <td id="viewModel"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Dealer Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Dealer Name:</th>
                                    <td id="viewDealerName"></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td id="viewDealerEmail"></td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td id="viewDealerPhone"></td>
                                </tr>
                                <tr>
                                    <th>City:</th>
                                    <td id="viewDealerCity"></td>
                                </tr>
                                <tr>
                                    <th>State:</th>
                                    <td id="viewDealerState"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h4>Dates</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Listing Date:</th>
                                    <td id="viewCreatedDate"></td>
                                </tr>
                                <tr>
                                    <th>Active Start:</th>
                                    <td id="viewCreatedAt"></td>
                                </tr>
                                <tr>
                                    <th>Active End:</th>
                                    <td id="viewActiveTill"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Status</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Package:</th>
                                    <td id="viewPackage"></td>
                                </tr>
                                <tr>
                                    <th>Inventory Status:</th>
                                    <td id="viewInventoryStatus"></td>
                                </tr>
                                <tr>
                                    <th>Visibility:</th>
                                    <td id="viewVisibility"></td>
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
@endsection

@push('scripts')
    <script>
        $(function() {
            // Initialize DataTable
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.inventory.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'main_inventories.id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'stock',
                        name: 'main_inventories.stock'
                    },
                    {
                        data: 'vin',
                        name: 'main_inventories.vin'
                    },
                    {
                        data: 'year',
                        name: 'main_inventories.year'
                    },
                    {
                        data: 'make',
                        name: 'main_inventories.make'
                    },
                    {
                        data: 'model',
                        name: 'main_inventories.model'
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
                        data: 'date',
                        name: 'main_inventories.created_date'
                    },
                    {
                        data: 'payment_date',
                        name: 'main_inventories.payment_date'
                    },
                    {
                        data: 'active_till',
                        name: 'main_inventories.active_till'
                    },
                    {
                        data: 'package',
                        name: 'main_inventories.package'
                    },
                    {
                        data: 'is_visibility',
                        name: 'main_inventories.is_visibility',
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

            // View inventory details
            $(document).on('click', '.view-btn', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/admin/inventory/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Basic Information
                            $('#viewStock').text(response.data.stock || 'N/A');
                            $('#viewVin').text(response.data.vin || 'N/A');
                            $('#viewYear').text(response.data.year || 'N/A');
                            $('#viewMake').text(response.data.make || 'N/A');
                            $('#viewModel').text(response.data.model || 'N/A');

                            // Dealer Information
                            $('#viewDealerName').text(response.data.dealer_name || 'N/A');
                            $('#viewDealerEmail').text(response.data.dealer_email || 'N/A');
                            $('#viewDealerPhone').text(formatPhoneUS(response.data
                                .dealer_phone) || 'N/A');
                            $('#viewDealerCity').text(response.data.dealer_city || 'N/A');
                            $('#viewDealerState').text(response.data.dealer_state || 'N/A');

                            // Dates
                            $('#viewCreatedDate').text(response.data.created_date || 'N/A');
                            $('#viewCreatedAt').text(response.data.created_at || 'N/A');
                            $('#viewActiveTill').text(response.data.active_till || 'N/A');

                            // Status
                            $('#viewPackage').text(response.data.package || 'N/A');
                            $('#viewInventoryStatus').text(response.data.inventory_status ||
                                'N/A');
                            $('#viewVisibility').html(
                                response.data.is_visibility ?
                                '<span class="badge bg-success">Active</span>' :
                                '<span class="badge bg-danger">Inactive</span>'
                            );

                            $('#viewInventoryModal').modal('show');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Failed to load inventory details');
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
                    text: `You want to ${newStatus ? 'activate' : 'deactivate'} this inventory?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/inventory/' + id + '/status',
                            type: 'POST',
                            data: {
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

            // Delete inventory
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
                            url: '/admin/inventory/' + id,
                            type: 'DELETE',
                            data: {
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
                                toastr.error('Failed to delete inventory');
                            }
                        });
                    }
                });
            });
        });

        function formatPhoneUS(phone) {
            phone = phone.toString().replace(/\D/g, ''); // Remove all non-digit characters
            if (phone.length === 10) {
                return '(' + phone.substr(0, 3) + ') ' + phone.substr(3, 3) + '-' + phone.substr(6);
            }
            return phone; // fallback if it's not 10 digits
        }
    </script>
@endpush
