@extends('backend.dashboard')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <div class="card shadow p-4">
                    <h5 class="card-title text-center">Create New Coupon</h5>
                    <hr>
                    <form action="{{ route('coupons.store') }}" method="post">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="code">Coupon Code:</label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
                            @error('code')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="discount_percentage">Discount Percentage (%):</label>
                            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage') }}" required min="0" max="100">
                            @error('discount_percentage')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="usage_limit">Usage Limit (optional):</label>
                            <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}" min="1">
                            @error('usage_limit')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="expiry_date">Expiry Date (optional):</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                            @error('expiry_date')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Is Active</label>
                            @error('is_active')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success btn-block w-100 mt-4">Create New Coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
