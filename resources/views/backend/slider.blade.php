@extends('backend.dashboard')
@section('main')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Card -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Slider - {{ $slider->count() }}
                </h6>
                <a href="{{ route('slider.create') }}" class="btn btn-success">
                    Create New Slider
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
                                <th>Image</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($slider as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('image/slider/' . $item->image) }}" width="100"
                                            alt="Product Image">
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('slider.edit', $item->id) }}" class="btn btn-primary m-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @auth
                                                @if (auth()->user()->role === 'admin')
                                                    <a href="{{ route('slider.destroy', $item->id) }}"
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
    <!-- /.container-fluid -->
@endsection
