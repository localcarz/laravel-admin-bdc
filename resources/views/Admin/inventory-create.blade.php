@extends('Admin.Layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Inventory</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.inventory.index') }}">Inventories</a></li>
                        <li class="breadcrumb-item active">Add New</li>
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
                        <form action="{{ route('admin.inventory.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="deal_id">Dealer *</label>
                                            <select class="form-control select2 @error('deal_id') is-invalid @enderror" id="deal_id" name="deal_id" required>
                                                <option value="">Select Dealer</option>
                                                @foreach($dealers as $dealer)
                                                    <option value="{{ $dealer->id }}" {{ old('deal_id') == $dealer->id ? 'selected' : '' }}>
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
                                            <input type="text" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" required>
                                            @error('stock')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="vin">VIN *</label>
                                            <input type="text" class="form-control @error('vin') is-invalid @enderror" id="vin" name="vin" value="{{ old('vin') }}" required>
                                            @error('vin')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="year">Year *</label>
                                            <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') + 1 }}" required>
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
                                            <input type="text" class="form-control @error('make') is-invalid @enderror" id="make" name="make" value="{{ old('make') }}" required>
                                            @error('make')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="model">Model *</label>
                                            <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model') }}" required>
                                            @error('model')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="package">Package</label>
                                            <input type="text" class="form-control @error('package') is-invalid @enderror" id="package" name="package" value="{{ old('package') }}">
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
                                            <select class="form-control @error('inventory_status') is-invalid @enderror" id="inventory_status" name="inventory_status" required>
                                                <option value="active" {{ old('inventory_status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('inventory_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="sold" {{ old('inventory_status') == 'sold' ? 'selected' : '' }}>Sold</option>
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
                                            <select class="form-control @error('is_visibility') is-invalid @enderror" id="is_visibility" name="is_visibility" required>
                                                <option value="1" {{ old('is_visibility') == '1' ? 'selected' : '' }}>Visible</option>
                                                <option value="0" {{ old('is_visibility') == '0' ? 'selected' : '' }}>Hidden</option>
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
                                            <input type="date" class="form-control @error('created_date') is-invalid @enderror" id="created_date" name="created_date" value="{{ old('created_date', date('Y-m-d')) }}" required>
                                            @error('created_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="active_till">Active Till </label>
                                            <input type="date" class="form-control @error('active_till') is-invalid @enderror" id="active_till" name="active_till" >
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
                                <button type="submit" class="btn btn-primary">Submit</button>
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

            // Set default dates if not set
            if (!$('#created_date').val()) {
                $('#created_date').val(new Date().toISOString().split('T')[0]);
            }
            if (!$('#active_till').val()) {
                var futureDate = new Date();
                futureDate.setDate(futureDate.getDate() + 30);
                $('#active_till').val(futureDate.toISOString().split('T')[0]);
            }
        });
    </script>
@endpush

