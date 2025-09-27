@extends('backend.dashboard')

@section('main')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Card -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Duration Prices - {{ $durations->count() }}
                </h6>
                <a href="{{ route('durationprice.create') }}" class="btn btn-success">
                    Create New Duration
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
                                <th>Product/Bundle Name</th>
                                <th>Duration (months)</th>
                                <th>Price USD</th>
                                <th>Price EGP</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($durations as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>

                                    <td>
                                        @if ($item->product)
                                            {{ $item->product->name_en ?? 'Unnamed Product' }}
                                        @elseif ($item->bundle)
                                            {{ $item->bundle->name_en ?? 'Unnamed Bundle' }}
                                        @else
                                            Not Set
                                        @endif
                                    </td>

                                    <td>{{ $item->duration_in_months }} month(s)</td>
                                    <td>${{ $item->price_usd }}</td>
                                    <td>EGP {{ $item->price_egp }}</td>

                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('durationprice.edit', $item->id) }}"
                                                class="btn btn-primary m-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @auth
                                                @if (auth()->user()->role === 'admin')
                                                    <a href="{{ route('durationprice.delete', $item->id) }}"
                                                        class="btn btn-danger m-1" onclick="return confirm('Are you sure?');">
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
