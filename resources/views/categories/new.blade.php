@extends('layouts.content')

@section('page-title')
  New Category
@endsection

@section('page-content')
  <h1 class="display-2 mt-4 mb-4">New Category</h1>
  <form method="post" action="{{ route('categories.store') }}">
    @csrf
    <div class="form-group mb-4">
      <label for="name">Category Name</label>
      <input type="text" name="name" class="form-control">
    </div>
    
    <button type="submit" class="btn btn-success">Add Category</button>
    <a href="#" class="btn btn-secondary">Back to List</a>
  </form>
@endsection
