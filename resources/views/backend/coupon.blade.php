@extends('backend.dashboard')
@section('main')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Coupons - {{ $coupons->count() }}
                </h6>
                <a href="{{ route('coupons.create') }}" class="btn btn-success">
                    Create New Coupon
                </a>
            </div>

            @if (session('message'))
                <h4 class="alert alert-success text-center m-3">{{ session('message') }}</h4>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center" id="dataTable" width="100%"
                        cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Discount %</th>
                                <th>Active</th>
                                <th>Usage Limit</th>
                                <th>Expiry Date</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->id }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_percentage }}%</td>
                                    <td>
                                        @if ($coupon->is_active)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                    <td>{{ $coupon->usage_limit ?? 'Unlimited' }}</td>
                                    <td>{{ $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : 'No Expiry' }}</td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-primary m-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @auth
                                                @if (auth()->user()->role === 'admin')
                                                    <a href="{{ route('coupons.destroy', $coupon->id) }}"
                                                        class="btn btn-danger m-1">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                @endif
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
