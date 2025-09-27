@extends('backend.dashboard')
@section('main')
 <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action="{{ route('durationprice.store') }}" method="POST">
                    @csrf

                    <label>Choose Product (optional)</label>
                    <select name="product_id" class="form-control">
                        <option value="">-- اختر منتج --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name_en }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label>Choose Bundle (optional)</label>
                    <select name="bundle_id" class="form-control">
                        <option value="">-- اختر باندل --</option>
                        @foreach ($bundles as $bundle)
                            <option value="{{ $bundle->id }}">{{ $bundle->name_en }}</option>
                        @endforeach
                    </select>
                    @error('bundle_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label>مدة الاشتراك (بالشهور)</label>
                    <input type="number" name="duration_in_months" class="form-control" min="1" required>
                    @error('duration_in_months')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label>السعر بالدولار</label>
                    <input type="number" name="price_usd" class="form-control" step="0.01" required>
                    @error('price_usd')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label>السعر بالجنيه المصري</label>
                    <input type="number" name="price_egp" class="form-control" step="0.01" required>
                    @error('price_egp')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-success btn-block mt-4">إضافة مدة اشتراك</button>
                </form>
            </div>
        </div>
    </div>
@endsection
