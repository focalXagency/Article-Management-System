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
        <div class="d-flex gap-3 mb-2 px-0">
            @foreach ($article->authors as $author)
            <div class="bg-primary p-3 py-2 rounded-3 text-white">
                {{$author->userData->name}}
            </div>
        @endforeach
        </div>
    <div class="card">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-5">
                    <div class="w-100 h-100">
                        <img src="{{ asset('storage/images/' . $article->image) }}" alt="article photo"
                            class="w-100 object-fit-cover" style="max-height: 200px">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold fs-3">
                            {{ $article->title }}
                        </span>
                        <p class="badge text-bg-primary mb-0">{{$article->category->name}}</p>
                    </div>
                    <p class="mb-0">
                        {{ $article->body }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection