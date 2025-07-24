@extends('Admin.Layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Inventory</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.inventory.index') }}">Inventories</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h3 class="card-title">Edit Inventory #{{ $inventory->id }}</h3>
                        </div>
                        <form action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="deal_id">Dealer *</label>
                                            <select class="form-control select2 @error('deal_id') is-invalid @enderror"
                                                id="deal_id" name="deal_id" required>
                                                <option value="">Select Dealer</option>
                                                @foreach ($dealers as $dealer)
                                                    <option value="{{ $dealer->id }}"
                                                        {{ old('deal_id', $inventory->deal_id) == $dealer->id ? 'selected' : '' }}>
                                                        {{ $dealer->name }} ({{ $dealer->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('deal_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="stock">Stock # *</label>
                                            <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                                id="stock" name="stock" value="{{ old('stock', $inventory->stock) }}"
                                                required>
                                            @error('stock')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="vin">VIN *</label>
                                            <input type="text" class="form-control @error('vin') is-invalid @enderror"
                                                id="vin" name="vin" value="{{ old('vin', $inventory->vin) }}"
                                                required>
                                            @error('vin')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="year">Year *</label>
                                            <input type="number" class="form-control @error('year') is-invalid @enderror"
                                                id="year" name="year" value="{{ old('year', $inventory->year) }}"
                                                min="1900" max="{{ date('Y') + 1 }}" required>
                                            @error('year')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="make">Make *</label>
                                            <input type="text" class="form-control @error('make') is-invalid @enderror"
                                                id="make" name="make" value="{{ old('make', $inventory->make) }}"
                                                required>
                                            @error('make')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="model">Model *</label>
                                            <input type="text" class="form-control @error('model') is-invalid @enderror"
                                                id="model" name="model" value="{{ old('model', $inventory->model) }}"
                                                required>
                                            @error('model')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="package">Package</label>
                                            <input type="text"
                                                class="form-control @error('package') is-invalid @enderror" id="package"
                                                name="package" value="{{ old('package', $inventory->package) }}">
                                            @error('package')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inventory_status">Inventory Status *</label>
                                            <select class="form-control @error('inventory_status') is-invalid @enderror"
                                                id="inventory_status" name="inventory_status" required>
                                                <option value="active"
                                                    {{ old('inventory_status', $inventory->inventory_status) == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('inventory_status', $inventory->inventory_status) == 'inactive' ? 'selected' : '' }}>
                                                    Inactive</option>
                                                <option value="sold"
                                                    {{ old('inventory_status', $inventory->inventory_status) == 'sold' ? 'selected' : '' }}>
                                                    Sold</option>
                                            </select>
                                            @error('inventory_status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="is_visibility">Visibility *</label>
                                            <select class="form-control @error('is_visibility') is-invalid @enderror"
                                                id="is_visibility" name="is_visibility" required>
                                                <option value="1"
                                                    {{ old('is_visibility', $inventory->is_visibility) == '1' ? 'selected' : '' }}>
                                                    Visible</option>
                                                <option value="0"
                                                    {{ old('is_visibility', $inventory->is_visibility) == '0' ? 'selected' : '' }}>
                                                    Hidden</option>
                                            </select>
                                            @error('is_visibility')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="created_date">Listing Date *</label>
                                            <input type="date"
                                                class="form-control @error('created_date') is-invalid @enderror"
                                                id="created_date" name="created_date"
                                                value="{{ old('created_date', $inventory->created_date ? date('Y-m-d', strtotime($inventory->created_date)) : date('Y-m-d')) }}"
                                                required>
                                            @error('created_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="active_till">Active Till *</label>
                                            <input type="date"
                                                class="form-control @error('active_till') is-invalid @enderror"
                                                id="active_till" name="active_till"
                                                value="{{ old('active_till', $inventory->active_till ? date('Y-m-d', strtotime($inventory->active_till)) : date('Y-m-d', strtotime('+30 days'))) }}"
                                                required>
                                            @error('active_till')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.inventory.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endpush


{{-- @extends('Admin.Layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Inventory #{{ $inventory->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.inventory.index') }}">Inventory</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h3 class="card-title">Inventory Details</h3>
                        </div>
                        <form action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Stock #</label>
                                            <input type="text" class="form-control" name="stock" value="{{ $inventory->stock }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>VIN</label>
                                            <input type="text" class="form-control" name="vin" value="{{ $inventory->vin }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Year</label>
                                            <input type="text" class="form-control" name="year" value="{{ $inventory->year }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Make</label>
                                            <input type="text" class="form-control" name="make" value="{{ $inventory->make }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Model</label>
                                            <input type="text" class="form-control" name="model" value="{{ $inventory->model }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Dealer</label>
                                            <select class="form-control" name="deal_id" required>
                                                <option value="{{ $inventory->deal_id }}">{{ $inventory->dealer->name }}</option>
                                                <!-- Add other dealer options if needed -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add more fields as needed -->

                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="inventory_status" required>
                                        <option value="active" {{ $inventory->inventory_status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $inventory->inventory_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="sold" {{ $inventory->inventory_status == 'sold' ? 'selected' : '' }}>Sold</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="visibilitySwitch" name="is_visibility" {{ $inventory->is_visibility ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="visibilitySwitch">Visible to customers</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Inventory</button>
                                <a href="{{ route('admin.inventory.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection --}}
