@extends('backend.dashboard')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action="{{ route('bundel.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="old_id" value="{{ $result->id }}">


                    <label>Current Image</label><br>
                    <img src="{{ asset('image/products/' . $result->image) }}" width="100"><br><br>

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
