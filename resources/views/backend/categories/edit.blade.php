@extends('backend.dashboard')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action={{ route('categories.update') }} method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="old_id" value={{ $result->id }}>

                    <div class="mb-3">
                        <label class="form-label">Current Image</label><br>
                        @if ($result->image)
                            <img src="{{ asset('image/category/' . $result->image) }}" width="100"
                                class="img-thumbnail"><br>
                        @else
                            <p>No image uploaded.</p>
                        @endif
                    </div>

                    <label for="">Name-En</label>
                    <input type="text" class="form-control" name="name_en" value="{{ $result->name_en }}">
                    @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Name-Ar</label>
                    <input type="text" class="form-control" name="name_ar" value="{{ $result->name_ar }}">
                    @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <input type="submit" class="btn btn-success btn-block mt-5" value="Edit Product">
                </form>
            </div>
        </div>
    </div>
@endsection
