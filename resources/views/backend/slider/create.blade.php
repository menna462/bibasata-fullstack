@extends('backend.dashboard')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action={{ route('slider.store') }} method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="images" class="form-label">Image</label>
                        <input type="file" class="form-control" name="images" id="images">
                        @error('images')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-success btn-block mt-5" value="Create New Category">
                </form>

            </div>
        </div>
    </div>
@endsection
