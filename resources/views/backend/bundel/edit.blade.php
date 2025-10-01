@extends('backend.dashboard')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action="{{ route('bundel.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="old_id" value="{{ $result->id }}">


                    <label>Current Images</label><br>
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        @if (is_array($result->image) && count($result->image) > 0)
                            @foreach ($result->image as $imageName)
                                <div class="image-preview position-relative">
                                    <img src="{{ asset('image/products/' . $imageName) }}" width="100" style="border: 1px solid #ddd;">
                                    {{-- ملاحظة: تنفيذ حذف صورة فردية يتطلب endpoint إضافي في الكنترولر --}}
                                    {{-- <a href="#" class="btn btn-sm btn-danger position-absolute top-0 end-0" style="z-index: 1;">X</a> --}}
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No images currently uploaded.</p>
                        @endif
                    </div>

                    <label>Change Image</label>
                    <input type="file" class="form-control" name="image">

                    <label>Name (EN)</label>
                    <input type="text" class="form-control" name="name_en" value="{{ $result->name_en }}">

                    <label>Name (AR)</label>
                    <input type="text" class="form-control" name="name_ar" value="{{ $result->name_ar }}">

                    <label>Short Description(en)</label>
                    <input type="text" class="form-control" name="short_description_en" value="{{ $result->short_description_en }}">

                    <label>Short Description(ar)</label>
                    <input type="text" class="form-control" name="short_description_ar" value="{{ $result->short_description_ar }}">

                    <label>Long description(En)</label>
                    <input type="text" class="form-control" name="long_description_en" value="{{ $result->long_description_en}}">

                    <label>Long description (AR)</label>
                    <input type="text" class="form-control" name="long_description_ar" value="{{ $result->long_description_ar}}">

                    <label>Discount</label>
                    <input type="text" class="form-control" name="discount_percentage" value="{{ $result->discount_percentage }}">

                    <input type="submit" class="btn btn-success btn-block mt-4" value="Update Product">
                </form>
            </div>
        </div>
    </div>
@endsection
