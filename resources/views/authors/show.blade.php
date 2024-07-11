@extends('layouts.master')

@section('title')
    Authors
@endsection

@section('navone')
   Authors
@endsection

@section('navtwo')
    list
@endsection
@section('content')
<a href="{{route('author.create')}}" class="btn btn-success mb-4">Add author</a>
<table class="table table-bordered">
    <thead>
      <tr>
        <th style="width: 10px">#</th>
        <th style="width: 20%">Name</th>
        <th style="width: 50%">Email</th> 
        <th style="width: 50%">Country</th> 
        <th style="width: 50%">Address</th> 
        <th style="width: 50%">Path File</th>               
      </tr>
    </thead>
    <tbody>
      @foreach ($authors as $author)

      <tr class="align-middle">
        <td>{{$loop->index + 1}}.</td>
        <td>{{$author->name}}</td>
        <td>{{$author->email}}</td>
        <td>{{$author->country}}</td>
        <td>{{$author->address}}</td>
        <td>{{$author->files_path}}</td>
        <td>Proccess</td>
        
        <td class="d-flex gap-2">
          <a href ="{{route('author.edit','author')}}" class="btn btn-primary">edit</a>
          <form action="{{route('author.destroy','author')}}" method="POST">
            @csrf
            @method('DELETE')
          <button type="submit" class="btn btn-danger">delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection