

    @extends('layouts.content')

    @section('page-title')
      Categories List
    @endsection
    
    @section('page-content')
        <h1 class="display-2 mt-4 mb-4">Categories List</h1>
        <table class="table">
          <tr>
            <th>Name</th>
            <th>Nu. of Properties</th>
            <th>Actions</th>
          </tr>
          @foreach($categories as $category)
          <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->properties->count() }}</td>
            <td>
              <a class="btn btn-secondary" href="">View</a>
              <a class="btn btn-primary" href="#">Edit</a>
            </td>
          </tr>
          @endforeach
        </table>
    @endsection
    