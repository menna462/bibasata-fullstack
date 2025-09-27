@extends('backend.dashboard')

@section('main')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Order #{{ $order->id }}</h6>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h5>Order Details</h5>
                        <ul class="list-group mb-3">
                            <li class="list-group-item"><strong>User:</strong> {{ $order->user->name ?? 'N/A' }}</li>
                            <li class="list-group-item">
                                <strong>Item:</strong>
                                @if ($order->product)
                                    {{ $order->product->name_en }} (Product)
                                @elseif ($order->bundle)
                                    {{ $order->bundle->name_en }} (Bundle)
                                @else
                                    N/A
                                @endif
                            </li>
                            <li class="list-group-item"><strong>Duration:</strong> {{ $order->duration_in_days }} Days</li>
                            <li class="list-group-item"><strong>Status:</strong> {{ $order->is_paid ? 'Paid' : 'Pending' }}</li>
                        </ul>
                    </div>
                </div>

                <hr>

                <h5>Assign Account</h5>
                @if ($availableAccounts->count() > 0)
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="account_id">Select an available account:</label>
                            <select name="account_id" id="account_id" class="form-control">
                                <option value="">-- Choose an Account --</option>
                                @foreach ($availableAccounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->email }} (Current Users: {{ $account->current_users }} / Max Users: {{ $account->max_users }})
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Assign Account</button>
                    </form>
                @else
                    <div class="alert alert-info">
                        No available accounts found for this item and duration.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
