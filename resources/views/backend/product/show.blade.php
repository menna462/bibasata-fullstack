@extends('backend.dashboard')

@section('main')
    <style>
        .description-box {
            /* تحديد عرض أقصى للـ div لضمان الالتفاف */
            max-width: 300px;
            height: 150px;
            overflow-y: auto; /* هذا يجعل شريط التمرير يظهر عند الحاجة */
            border: 1px solid #ccc;
            padding: 10px;
        }

        /* تنسيق لتوسيط المحتوى داخل الخلايا */
        td,
        th {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-3">Product Details</h3>

                {{-- 🚨 هذا هو التعديل الأساسي: ضع الجدول داخل div بكلاس table-responsive --}}
                <div class="table-responsive">
                    <table class="table table-dark table-striped text-center">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Name (English)</th>
                                <th>Name (Arabic)</th>
                                <th>Description (English)</th>
                                <th>Description (Arabic)</th>
                                <th>Long description(English)</th>
                                <th>Long description(Arabic)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $product->category_id }}</td>
                                <td><img src="{{ asset('image/products/' . $product->image) }}" width="100" alt="Product Image">
                                </td>
                                <td>{{ $product->name_en }}</td>
                                <td>{{ $product->name_ar }}</td>
                                <td>
                                    <div class="description-box">{{ $product->description_en }}</div>
                                </td>
                                <td>
                                    <div class="description-box">{{ $product->description_ar }}</div>
                                </td>
                                <td>
                                    <div class="description-box">{{ $product->long_description_en }}</div>
                                </td>
                                <td>
                                    <div class="description-box">{{ $product->long_description_ar }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('product') }}" class="btn btn-primary mt-3">Back to Product List</a>
            </div>
        </div>
    </div>
@endsection
