@extends('backend.dashboard')
@section('main')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Card -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Accounts - {{ $account->count() }}
                </h6>
                <a href="{{ route('account.create') }}" class="btn btn-success">
                    Create New Account
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
                                <th>Email</th>
                                <th>Password</th>
                                <th>Product / Bundle</th>
                                <th>Durecction-Mounth</th>
                                <th>Duration (Days)</th>
                                <th>Max Users</th>
                                <th>Current Users</th>
                                <th>Is Full</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($account as $accounts)
                                <tr>
                                    <td>{{ $accounts->id }}</td>
                                    <td>{{ $accounts->email }}</td>
                                    <td>{{ $accounts->password }}</td>
                                    <td>
                                        @if ($accounts->bundle_id)
                                            <strong>Bundle:</strong> {{ $accounts->bundle->name_en ?? 'Unnamed Bundle' }}
                                        @elseif ($accounts->product_id)
                                            <strong>Product:</strong> {{ $accounts->product->name_en }}
                                        @else
                                            Not Set
                                        @endif
                                    </td>
                                    <td>
                                        @if ($accounts->durationPrice)
                                            {{ $accounts->durationPrice->duration_in_months }}
                                            {{ $accounts->durationPrice->duration_in_months == 1 ? 'Month' : 'Months' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $accounts->duration_in_days }}</td>
                                    <td>{{ $accounts->max_users }}</td>
                                    <td>{{ $accounts->current_users }}</td>
                                    <td>{{ $accounts->is_full ? 'Yes' : 'No' }}</td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('account.edit', $accounts->id) }}"
                                                class="btn btn-primary m-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @auth
                                                @if (auth()->user()->role === 'admin')
                                                    <a href="{{ route('account.destroy', $accounts->id) }}"
                                                        onclick="return confirm('Are you sure?');" class="btn btn-danger m-1">
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
    <!-- /.container-fluid -->
@endsection
