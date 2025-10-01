@extends('backend.dashboard')

@section('main')
    <style>
        .description-box {
            max-width: 300px;
            height: 150px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
        }

        td,
        th {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-3">Bundle Details</h3>

                <div class="table-responsive">
                    <table class="table table-dark table-striped text-center">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Name (English)</th>
                                <th>Name (Arabic)</th>
                                <th>Short Description (English)</th>
                                <th>Short Description (Arabic)</th>
                                <th>Long description(English)</th>
                                <th>Long description(Arabic)</th>
                                <th>Discount Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td>{{ $bundel->category_id ?? 'N/A' }}</td>
                                <td>
                                    @if (is_array($bundel->image) && count($bundel->image) > 0)
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            @foreach ($bundel->image as $imageName)
                                                <img src="{{ asset('image/products/' . $imageName) }}" width="80"
                                                    alt="Bundle Image" style="border: 1px solid #fff; margin-bottom: 5px;">
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-warning">No Image Found</span>
                                    @endif
                                </td>
                                <td>{{ $bundel->name_en }}</td>
                                <td>{{ $bundel->name_ar }}</td>
                                <td>
                                    <div class="description-box">{{ $bundel->short_description_en }}</div>
                                </td>
                                <td>
                                    <div class="description-box">{{ $bundel->short_description_ar }}</div>
                                </td>
                                <td>
                                    <div class="description-box">{{ $bundel->long_description_en }}</div>
                                </td>
                                <td>
                                    <div class="description-box">{{ $bundel->long_description_ar }}</div>
                                </td>
                                <td>{{ $bundel->discount_percentage }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('bundel') }}" class="btn btn-primary mt-3">Back to Bundles List</a>
            </div>
        </div>
    </div>
@endsection
