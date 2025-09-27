@extends('backend.dashboard')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto pt-5">
                <form action="{{ route('account.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="old_id" value="{{ $account->id }}">

                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $account->email }}" required>

                    <label>Password</label>
                    <input type="text" class="form-control" name="password" value="{{ $account->password }}" required>

                    <label>Choose Product or Bundle</label>
                    <select class="form-control" name="product_or_bundle">
                        <option value="">-- Select --</option>
                        @foreach ($products as $product)
                            <option value="product_{{ $product->id }}"
                                {{ $account->product_id == $product->id ? 'selected' : '' }}>
                                Product - {{ $product->name_en }}
                            </option>
                        @endforeach
                        @foreach ($bundles as $bundle)
                            <option value="bundle_{{ $bundle->id }}"
                                {{ $account->bundle_id == $bundle->id ? 'selected' : '' }}>
                                Bundle - {{ $bundle->name_en }}
                            </option>
                        @endforeach
                    </select>


                    <label for="">Duration in Days</label>
                    <input type="text" class="form-control" name="duration_in_days"
                        value="{{ $account->duration_in_days }}">
                    @error('duration_in_days')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror


                    <div class="form-group mb-3">
                        <label for="duration_price_id">Duration and Price</label>
                        <select name="duration_price_id" class="form-control" required>
                            <option value="" disabled>Select a duration and price</option>
                            @foreach ($durationPrices as $dp)
                                <option value="{{ $dp->id }}"
                                    {{ old('duration_price_id', $account->duration_price_id) == $dp->id ? 'selected' : '' }}>
                                    {{ $dp->product->name_en ?? ($dp->bundle->name_en ?? 'N/A') }}
                                    - {{ $dp->duration_in_months }} Month(s)
                                </option>
                            @endforeach
                        </select>
                        @error('duration_price_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <label>Max Users</label>
                    <input type="number" class="form-control" name="max_users" value="{{ $account->max_users }}" required>

                    <label>Current Users</label>
                    <input type="number" class="form-control" name="current_users" value="{{ $account->current_users }}"
                        required>

                    <label>Is Full</label>
                    <select class="form-control" name="is_full">
                        <option value="0" {{ !$account->is_full ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $account->is_full ? 'selected' : '' }}>Yes</option>
                    </select>


                    <input type="submit" class="btn btn-success btn-block mt-4" value="Update Account">
                </form>
            </div>
        </div>
    </div>
@endsection
