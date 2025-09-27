@extends('backend.dashboard')
@section('main')
  <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto pt-5">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Duration Price</h4>
                    </div>
                    <div class="card-body">
                        {{-- الفورم هنا هتبعت بـ POST --}}
                        <form action="{{ route('durationprice.update') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $duration->id }}">

                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select name="product_id" id="product_id" class="form-control">
                                    <option value="">اختر منتج</option>
                                    @foreach ($product as $prod)
                                        <option value="{{ $prod->id }}" {{ ($duration->product_id == $prod->id) ? 'selected' : '' }}>
                                            {{ $prod->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="bundle_id" class="form-label">Bundle</label>
                                <select name="bundle_id" id="bundle_id" class="form-control">
                                    <option value="">اختر باقة</option>
                                    @foreach ($bundles as $bundleItem)
                                        <option value="{{ $bundleItem->id }}" {{ ($duration->bundle_id == $bundleItem->id) ? 'selected' : '' }}>
                                            {{ $bundleItem->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bundle_id')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="duration_in_months" class="form-label">Duration (in months)</label>
                                <input type="number" class="form-control" name="duration_in_months" id="duration_in_months"
                                    value="{{ old('duration_in_months', $duration->duration_in_months) }}" min="1">
                                @error('duration_in_months')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price_usd" class="form-label">Price (USD)</label>
                                <input type="number" step="0.01" class="form-control" name="price_usd" id="price_usd"
                                    value="{{ old('price_usd', $duration->price_usd) }}" min="0">
                                @error('price_usd')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price_egp" class="form-label">Price (EGP)</label>
                                <input type="number" step="0.01" class="form-control" name="price_egp" id="price_egp"
                                    value="{{ old('price_egp', $duration->price_egp) }}" min="0">
                                @error('price_egp')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="submit" class="btn btn-success btn-block mt-4" value="Update Duration Price">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

