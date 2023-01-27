

    @extends('layouts.content')

    @section('page-title')
      Features List
    @endsection
    
    @section('page-content')
        <h1 class="display-2 mt-4 mb-4">Features List</h1>
        <table class="table">
          <tr>
            <th>Name</th>
            <th>Actions</th>
          </tr>
          @foreach($features as $feature)
          <tr>
            <td>{{ $feature->name }}</td>
            <td>
              <a class="btn btn-secondary" href="">View</a>
              <a class="btn btn-primary" href="#">Edit</a>
            </td>
          </tr>
          @endforeach
        </table>
    @endsection
    