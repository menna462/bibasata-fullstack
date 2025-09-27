@extends('backend.dashboard')
@section('main')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Card -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Orders - {{ $orders->count() }}
                </h6>

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
                                <th>User</th>
                                <th>Number</th>
                                <th>Product / Bundle</th>
                                <th>Account</th>
                                <th>Duration (Days)</th>
                                <th>Order Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Payment Status / Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>{{ $order->user->phone_number ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $itemName = 'N/A';
                                            $locale = App::getLocale();

                                            if ($order->product) {
                                                $itemName =
                                                    $order->product->{'name_' . $locale} ?? $order->product->name_en;
                                                $itemName .= ' (Product)';
                                            } elseif ($order->bundle) {
                                                $itemName =
                                                    $order->bundle->{'name_' . $locale} ?? $order->bundle->name_en;
                                                $itemName .= ' (Bundle)';
                                            }
                                        @endphp
                                        {{ $itemName }}
                                    </td>
                                    <td>
                                        @if ($order->account)
                                            {{ $order->account->email }}
                                        @else
                                            N/A
                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-plus"></i> Add Account
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $order->duration_in_days }}</td>
                                    <td>{{ $order->order_date->format('Y-m-d H:i') }}</td>
                                    <td>{{ $order->start_date ? $order->start_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $order->end_date ? $order->end_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        @if ($order->is_paid)
                                            <span class="badge bg-success text-white">Paid</span>
                                            <button class="btn btn-sm btn-info" disabled>
                                                <i class="fa fa-check-circle"></i> Sent
                                            </button>
                                            <form action="{{ route('orders.resendEmail', $order->id) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من أنك تريد إعادة إرسال تفاصيل الحساب لهذا الطلب؟')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-secondary mt-2">
                                                    <i class="fa fa-redo"></i> Re-send Email
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            <form action="{{ route('orders.markPaid', $order->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to mark this order as paid and send account details?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fa fa-dollar-sign"></i> Mark Paid & Send
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
