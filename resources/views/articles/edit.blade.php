@extends('layouts.master')

@section('title')
    Articles
@endsection

@section('navone')
    Articles
@endsection

@section('navtwo')
    edit
@endsection

@section('content')
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <div class="card-title">Edit Article</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form method="post" action="{{ route('articles.update', $article->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!--begin::Body-->
            <div class="card-body">
                <div class="row mb-3">
                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ $article->title }}" />
                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="body" class="col-sm-2 col-form-label">Body</label>
                    <div class="col-sm-10">
                        <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body">{{ $article->body }}</textarea>
                        @error('body')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="image" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="title"
                            name="image" />
                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="category" class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="validationCustom04" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $article->category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label for="image" class="col-sm-2 col-form-label">Authors</label>
                        <div class="col-sm-10">

                            @php
                                $article_authors = [];
                                foreach ($article->authors as $author) {
                                    array_push($article_authors, $author->id);
                                };
                            @endphp
                            @forelse ($Authors as $Author)
                                <!-- <optgroup label="authors"> -->
                                <input type="checkbox" id="author" name="authors_id[]" value="{{ $Author->id }}"
                                    {{ in_array($Author->id, $article_authors) ? 'checked' : '' }}>
                                {{ $Author->userData->name }}

                            @empty
                                <!-- </optgroup> -->
                            @endforelse

                            @error('authors_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">
                                Please select a valid state.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>
    </div>
    </div>
    <!--end::Body-->
    <!--begin::Footer-->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
    <!--end::Footer-->
    </form>
    <!--end::Form-->
    </div>
@endsection
