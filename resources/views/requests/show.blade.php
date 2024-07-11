@extends('layouts.master')

@section('title')
    Request
@endsection

@section('navone')
    Request
@endsection

@section('navtwo')
    show
@endsection

@section('content')
    {{-- {{ $request->created_at->format('Y-m-d H:i:s') }} --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon text-bg-primary shadow-sm">
                    <i class="bi bi-people-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">User</span>
                    <span class="info-box-number">
                        {{ $request->user->name }}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon text-bg-success shadow-sm">
                    <i class="bi bi-geo-alt-fill"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Location</span>
                    <span class="info-box-number">{{ $request->request_data->country }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <!-- <div class="clearfix hidden-md-up"></div> -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon text-bg-success shadow-sm">
                    <i class="bi bi-calendar-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Requested At</span>
                    <span class="info-box-number">{{ $request->created_at->format('Y-m-d  H:i') }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span
                    class="info-box-icon 
                            @switch($request->status)
                                @case('rejected')
                                text-bg-danger
                                @case('pending')
                                text-bg-warning
                                @case('accepted')
                                text-bg-success
                            @endswitch shadow-sm">
                    <i
                        class="
                            @switch($request->status)
                                @case('rejected')
                                bi bi-x
                                @case('pending')
                                bi bi-clock-fill
                                @case('accepted')
                                bi bi-check
                            @endswitch shadow-sm"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Request Status</span>
                    <span class="info-box-number">{{ $request->status }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="info-box mx-2 d-block">
            <div class="row">
                <div class="col-md-6 d-flex mb-3">
                    <p class="mb-0 info-box-number col-md-3 mt-0">User</p>
                    <p class="mb-0 info-box-text col-md-9">{{ $request->user->name }}</p>
                </div>
                <div class="col-md-6 d-flex">
                    <p class="mb-0 info-box-number col-md-3 mt-0">Email</p>
                    <p class="mb-0 info-box-text col-md-9">{{ $request->user->email }}</p>
                </div>
                <div class="col-md-6 d-flex mb-3">
                    <p class="mb-0 info-box-number col-md-3 mt-0">Country</p>
                    <p class="mb-0 info-box-text col-md-9">{{ $request->request_data->country }}</p>
                </div>
                <div class="col-md-6 d-flex">
                    <p class="mb-0 info-box-number col-md-3 mt-0">Address</p>
                    <p class="mb-0 info-box-text col-md-9">{{ $request->request_data->address }}</p>
                </div>
                @if ($request->status != 'pending')
                    <div class="col-md-6 d-flex">
                        <p class="mb-0 info-box-number col-md-3 mt-0">{{ $request->status }} At</p>
                        <p class="mb-0 info-box-text col-md-9">{{ $request->updated_at }}</p>
                    </div>
                @endif
            
                <div class="col-md-12 d-flex gap-2 justify-content-end align-items-center mt-4">
                    <a href="{{ asset($request->request_data->files_path) }}" download 
                        class="btn btn-primary">Download File</a>

                    @if ($request->status == 'pending')
                        <a href="{{ route('requests.accept', $request->id) }}" class="btn btn-success">Accept</a>
                        <a href="{{ url('requests/reject/' . $request->id) }}" class="btn btn-danger">Reject</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
