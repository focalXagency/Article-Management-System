@extends('layouts.master')

@section('title')
    Be Author Requests
@endsection

@section('navone')
    Requests
@endsection

@section('navtwo')
    List
@endsection

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">Username</th>
                <th style="width: 20%">Country</th>
                <th style="width: 40%">Address</th>
                <th>Details</th>
                <th style="width: 20%">Process</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $request)
                <tr class="align-middle">
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->request_data->country }}</td>
                    <td>{{ $request->request_data->address }}</td>
                    <td>
                        <a href="{{ url('requests/' . $request->id) }}" class="btn btn-warning btn-sm">Show</a>
                    </td>
                    @if ($request->status == 'pending')
                        <td>
                            <a href="{{ route('requests.accept', $request->id) }}" class="btn btn-success btn-sm">Accept</a>
                            <a href="{{ url('requests/reject/' . $request->id) }}" class="btn btn-danger btn-sm">Reject</a>
                        </td>
                    @else
                        <td>
                            <span
                                class="badge 
                                    @switch($request->status)
                                        @case('rejected')
                                        text-bg-danger
                                        @break
                                        @case('pending')
                                        text-bg-warning
                                        @break
                                        @case('accepted')
                                        text-bg-success
                                    @endswitch
                                    ">
                                {{ $request->status }}
                            </span>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center opacity-75">No Requests Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
