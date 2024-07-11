@extends('layouts.master')

@section('title')
    Articles
@endsection

@section('navone')
    Articles
@endsection

@section('navtwo')
    show
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Manage Articles</div>
        <div class="card-body">
            <a href="{{ route('articles.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i>
                Add Article</a>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#NO</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col" style="width: 250px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $article)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $article->title }}</td>
                            <td><p class="badge text-bg-primary mb-0">{{ $article->Category->name }}</p></td>
                            <td>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('articles.show', $article->id) }}"
                                        class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                                    <a href="{{ route('articles.edit', $article->id) }}"
                                        class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Do you want to delete this category?');"><i
                                            class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="4" class="text-center">
                            <span class="text-danger">
                                <strong>No Articles Found!</strong>
                            </span>
                        </td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
