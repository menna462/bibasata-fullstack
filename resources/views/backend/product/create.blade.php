@extends('backend.dashboard')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">اختر قسم</option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        @error('image')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name_en" class="form-label">Name (EN)</label>
                        <input type="text" class="form-control" name="name_en" id="name_en" value="{{ old('name_en') }}">
                        @error('name_en')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name_ar" class="form-label">Name (AR)</label>
                        <input type="text" class="form-control" name="name_ar" id="name_ar" value="{{ old('name_ar') }}">
                        @error('name_ar')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description_en" class="form-label">Short Description / Features (EN)</label>

                        <textarea name="description_en" id="description_en" rows="5" class="form-control">{{ old('description_en') }}</textarea>
                        <small class="form-text text-muted">Enter each feature on a new line.</small>
                        @error('description_en')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description_ar" class="form-label">Short Description / Features (AR)</label>
                        {{-- تم تغيير هذا الحقل إلى textarea --}}
                        <textarea name="description_ar" id="description_ar" rows="5" class="form-control">{{ old('description_ar') }}</textarea>
                        <small class="form-text text-muted">ادخل كل ميزة في سطر جديد.</small>
                        @error('description_ar')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="long_description_en" class="form-label">Long Description (EN)</label>
                        {{-- تم تغيير هذا الحقل إلى textarea --}}
                        <textarea name="long_description_en" id="long_description_en" rows="8" class="form-control">{{ old('long_description_en') }}</textarea>
                        @error('long_description_en')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="long_description_ar" class="form-label">Long Description (AR)</label>
                        {{-- تم تغيير هذا الحقل إلى textarea --}}
                        <textarea name="long_description_ar" id="long_description_ar" rows="8" class="form-control">{{ old('long_description_ar') }}</textarea>
                        @error('long_description_ar')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="submit" class="btn btn-success btn-block mt-4" value="Create Product">
                </form>
            </div>
        </div>
    </div>
@endsection
