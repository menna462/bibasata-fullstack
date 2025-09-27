@extends('backend.dashboard')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form action={{route('user.store')}} method="post" enctype="multipart/form-data">

                    @csrf

                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Email</label>
                    <input type="email" class="form-control" name="email">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Phone Number</label>
                    <input type="text" class="form-control" value={{ $result->phone_number }} name="phone_number">
                    @error('phone_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Password</label>
                    <input type="text" class="form-control" name="password">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="">Role</label>
                    <select name="role" class="form-control">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>

                    </select>
                    @error('role')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <input type="submit" class="btn btn-success btn-block mt-5" value="Create New User">
                </form>

            </div>
        </div>
    </div>
@endsection

