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
                Product - {{ $product->count() }}
            </h6>
            <a href="{{ route('product.create') }}" class="btn btn-success">Create New Product</a>
        </div>

        @if (session('message'))
            <h4 class="alert alert-success text-center m-3">{{ session('message') }}</h4>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Name_en</th>
                            <th>Name_ar</th>
                            <th>Description_en</th>
                            <th>Description_ar</th>
                            <th>Long description(en)</th>
                            <th>Long description(ar)</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->category->name ?? 'N/A' }}</td>
                                <td>
                                    <img src="{{ asset('image/products/' . $item->image) }}" width="100" alt="Product Image">
                                </td>
                                <td>{{ $item->name_en }}</td>
                                <td>{{ $item->name_ar }}</td>
                                <td class="description">{{ Str::limit($item->description_en, 20) }}</td>
                                <td class="description">{{ Str::limit($item->description_ar, 20) }}</td>
                                <td class="description">{{ Str::limit($item->long_description_en, 20) }}</td>
                                <td class="description">{{ Str::limit($item->long_description_ar, 20) }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('product.show', $item->id) }}" class="btn btn-success">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('product.edit', $item->id) }}" class="btn btn-primary m-2">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @auth
                                            @if(auth()->user()->role === 'admin')
                                                <a href="{{ route('product.delete', $item->id) }}" class="btn btn-danger">
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

