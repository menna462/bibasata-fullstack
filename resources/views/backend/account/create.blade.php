@extends('backend.dashboard')
@section('main')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4>Create New Account</h4>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('account.store') }}" method="POST">
                            @csrf

                            {{-- Email --}}
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required
                                    value="{{ old('email') }}">
                            </div>

                            {{-- Password --}}
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="text" name="password" class="form-control" required
                                    value="{{ old('password') }}">
                            </div>

                            {{-- Product or Bundle --}}
                            <div class="form-group mb-3">
                                <label for="product_or_bundle">Product or Bundle</label>
                                <select name="product_or_bundle" class="form-control" required>
                                    <option value="" disabled selected>Select a product or bundle</option>

                                    {{-- Products --}}
                                    @foreach ($products as $product)
                                        <option value="product_{{ $product->id }}">
                                            Product: {{ $product->name_en }}
                                        </option>
                                    @endforeach

                                    {{-- Bundles --}}
                                    @foreach ($bundles as $bundle)
                                        <option value="bundle_{{ $bundle->id }}">
                                            Bundle: {{ $bundle->name_en ?? 'Unnamed Bundle' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Duration and Price  --}}
                            <div class="form-group mb-3">
                                <label for="duration_price_id">Duration and Price</label>
                                <select name="duration_price_id" class="form-control" required> {{-- جعلها required إذا كان يجب اختيار مدة لكل حساب --}}
                                    <option value="" disabled selected>Select a duration and price</option>
                                    @foreach ($durationPrices as $dp)
                                        <option value="{{ $dp->id }}"
                                            {{ old('duration_price_id') == $dp->id ? 'selected' : '' }}>
                                            {{ $dp->product->name_en ?? ($dp->bundle->name_en ?? 'N/A') }}
                                            - {{ $dp->duration_in_months }} Month(s)
                                        </option>
                                    @endforeach
                                </select>
                                @error('duration_price_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="duration_in_days">Duration (in days)</label>
                                <input type="number" class="form-control" name="duration_in_days" id="duration_in_days"
                                    value="{{ old('duration_in_days') }}" required>
                                @error('duration_in_days')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Max Users --}}
                            <div class="form-group mb-3">
                                <label for="max_users">Max Users</label>
                                <input type="number" name="max_users" class="form-control" value="1" required>
                            </div>

                            {{-- Current Users --}}
                            <div class="form-group mb-3">
                                <label for="current_users">Current Users</label>
                                <input type="number" name="current_users" class="form-control" value="0" required>
                            </div>

                            {{-- Is Full --}}
                            <div class="form-group mb-3">
                                <label for="is_full">Is Full?</label>
                                <select name="is_full" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary">Create Account</button>
                                <a href="{{ route('account') }}" class="btn btn-secondary">Back</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
