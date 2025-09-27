@extends('backend.dashboard')
@section('main')
    <style>
        .alert-custom {
            background-color: rgba(255, 0, 0, 0.1);
            /* أحمر شفاف */
            border: 1px solid #f5c2c7;
            color: #842029;
            padding: 10px 15px;
            margin-top: 5px;
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action="{{ route('bundel.store') }}" method="post" enctype="multipart/form-data">
                    @csrf


                    <label>Image</label>
                    <input type="file" class="form-control" name="images">
                    @error('images')
                        <div class="alert-custom">{{ $message }}</div>
                    @enderror

                    <label>Name (EN)</label>
                    <input type="text" class="form-control" name="name_en">
                    @error('name_en')
                        <div class="alert-custom">{{ $message }}</div>
                    @enderror
                    <label>Name (AR)</label>
                    <input type="text" class="form-control" name="name_ar">
                    @error('name_ar')
                        <div class="alert-custom">{{ $message }}</div>
                    @enderror
                    <label>Short Description(EN)</label>
                    <input type="text" class="form-control" name="short_description_en">
                    @error('short_description_en')
                        <div class="alert-custom">{{ $message }}</div>
                    @enderror
                    <label>Short Description(AR)</label>
                    <input type="text" class="form-control" name="short_description_ar">
                    @error('short_description_ar')
                        <div class="alert-custom">{{ $message }}</div>
                    @enderror
                    <label>Long description(En)</label>
                    <input type="text" class="form-control" name="long_description_en">
                    @error('long_description_en')
                        <div class="alert-custom">{{ $message }}</div>
                    @enderror
                    <label>Long description (AR)</label>
                    <input type="text" class="form-control" name="long_description_ar">
                    @error('long_description_ar')
                        <div class="alert-custom">{{ $message }}</div>
                    @enderror
                    <label>Discount</label>
                    <input type="number" class="form-control" name="discount_percentage">
                    @error('discount_percentage')
                        <div class="alert-custom">{{ $message }}</div>
                    @enderror
                    <input type="submit" class="btn btn-success btn-block mt-4" value="Create Product">
                </form>
            </div>
        </div>
    </div>
@endsection
