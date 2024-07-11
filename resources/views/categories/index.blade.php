@extends('layouts.master')

@section('title')
    Categories
@endsection

@section('navone')
    Categories
@endsection

@section('navtwo')
    List
@endsection

@section('content')
<div class="card">
    <div class="card-header">Manage Categories</div>
    <div class="card-body">
      <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add Category</a>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                <th scope="col">#NO</th>
                <th scope="col">Name</th>
                <th scope="col" style="width: 250px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $category->name }}</td>
                    <td>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this category?');"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="3">
                        <span class="text-danger">
                            <strong>No Category Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection