@extends('layouts.master')

@section('title')
    roles
@endsection

@section('navone')
    roles
@endsection

@section('navtwo')
    edit
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Edit Role
                </div>
                <div class="float-end">
                    <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="post">
                    @csrf
                    @method("PUT")

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $role->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="permissions" class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
                        <div class="col-md-6"> 
                      @forelse ($permissions as $permission)
                         <input type="checkbox" id="permissions" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                         {{ $permission->name }}
                          @empty
                      @endforelse
                            @if ($errors->has('permissions'))
                                <span class="text-danger">{{ $errors->first('permissions') }}</span>
                            @endif
                    </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Role">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>

<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection