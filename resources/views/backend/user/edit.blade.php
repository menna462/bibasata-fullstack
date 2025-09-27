@extends('backend.dashboard')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action= {{ route('user.update') }} method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="old_id" value={{ $result->id }}>
                    <label for="">Name</label>
                    <input type="text" class="form-control" value={{ $result->name }} name="name">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Email</label>
                    <input type="text" class="form-control" value={{ $result->email }} name="email">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Phone Number</label>
                    <input type="text" class="form-control" value={{ $result->phone_number }} name="phone_number">
                    @error('phone_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Password</label>
                    <input type="text" class="form-control" value={{ $result->password }} name="password">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Role</label>
                    <select name="role" class="form-control">
                        <option value="user" {{ $result->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $result->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="editor" {{ $result->role == 'editor' ? 'selected' : '' }}>Editor</option>

                    </select>
                    @error('role')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <input type="submit" class="btn btn-success btn-block mt-5" value="Edit Product">
                </form>

            </div>
        </div>
    </div>
@endsection
