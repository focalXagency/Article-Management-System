@extends('layouts.master')

@section('title')
    Authors
@endsection

@section('navone')
    author
@endsection

@section('navtwo')
    create
@endsection

@section('content')
<div class="card card-primary card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">Horizontal Form</div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form method="post" action="{{route('author.store')}}" enctype="multipart/form-data">
        @csrf
        <!--begin::Body-->
        <div class="card-body">
            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" />
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" />
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" />
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control"
                        id="confirm_password" name="password_confirmation" />
                </div>
            </div>
            <div class="row mb-3">
                <label for="country" class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"
                        id="country" name="country" value="{{ old('country') }}" />
                        @error('country')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"
                        id="address" name="address" value="{{ old('address') }}" />
                        @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="file" class="col-sm-2 col-form-label">File</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control"
                        id="file" name="file" />
                        @error('file')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                </div>
            </div>
        </div>
        <!--end::Body-->
        <!--begin::Footer-->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
        <!--end::Footer-->
    </form>
    <!--end::Form-->
</div>
@endsection