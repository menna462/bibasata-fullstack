@extends('backend.dashboard')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action={{ route('slider.update') }} method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="old_id" value={{ $result->id }}>

                    <div class="mb-3">
                        <label class="form-label">Current Image</label><br>
                        @if ($result->image)
                            <img src="{{ asset('image/slider/' . $result->image) }}" width="100"
                                class="img-thumbnail"><br>
                        @else
                            <p>No image uploaded.</p>
                        @endif
                    </div>
                    <input type="submit" class="btn btn-success btn-block mt-5" value="Edit Product">
                </form>
            </div>
        </div>
    </div>
@endsection
