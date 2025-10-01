@extends('backend.dashboard')
@section('main')
    @php use Illuminate\Support\Str; @endphp

    <style>
        .description {
            white-space: normal;
            word-wrap: break-word;
            word-break: break-word;
        }
    </style>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Card -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Bundel - {{ $bundel->count() }}
                </h6>
                <a href="{{ route('bundel.create') }}" class="btn btn-success">
                    Create New Product
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
                                <th>Name_en</th>
                                <th>Name_ar</th>
                                <th>Short Description(en)</th>
                                <th>Short Description(ar)</th>
                                <th>Long description(en)</th>
                                <th>Long description(ar)</th>
                                <th>discount</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bundel as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                 <td>
                                        @php
                                        $firstImage = is_array($item->image) && count($item->image) > 0 ? $item->image[0] : null;
                                    @endphp

                                    @if ($firstImage)
                                        <img src="{{ asset('image/products/' . $firstImage) }}" width="100"
                                            alt="Product Image">
                                    @else
                                        <span class="text-danger">No Image</span>
                                    @endif
                                </td>
                                    <td>{{ $item->name_en }}</td>
                                    <td>{{ $item->name_ar }}</td>
                                    <td class="description">{{ Str::limit($item->short_description_en, 20) }}</td>
                                    <td class="description">{{ Str::limit($item->short_description_ar, 20) }}</td>
                                    <td class="description">{{ Str::limit($item->long_description_en, 20) }}</td>
                                    <td class="description">{{ Str::limit($item->long_description_ar, 20) }}</td>
                                    <td>{{ $item->discount_percentage }}</td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('bundel.show', $item->id) }}" class="btn btn-success">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('bundel.edit', $item->id) }}" class="btn btn-primary m-2">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @auth
                                                @if (auth()->user()->role === 'admin')
                                                    <a href="{{ route('bundel.delete', $item->id) }}" class="btn btn-danger">
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
