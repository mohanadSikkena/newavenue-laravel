<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    {{-- <a class="navbar-brand" href="{{ route('dashboard') }}"><img id="app-logo" src="{{ asset('img/logo.png') }}"></a> --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Agents
          </a>
          <ul class="dropdown-menu">
            {{-- <li><a class="dropdown-item" href="{{ route('agents.index') }}">Agents List</a></li> --}}
            {{-- <li><a class="dropdown-item" href="{{ route('customers.new') }}">New Customer</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('customers.search_by_phone') }}">Search By Phone</a></li>
            <li><a class="dropdown-item" href="{{ route('customers.search_by_name') }}">Search By Name</a></li>
            <li><a class="dropdown-item" href="{{ route('customers.search_dynamically') }}">Dynamic Search</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('customers.trash') }}">Customers Trash</a></li> --}}
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            properties
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="">properties List</a></li>
            <li><a class="dropdown-item" href="">New Category</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">properties Trash</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="">Categories List</a></li>
            <li><a class="dropdown-item" href="">New Category</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Categories Trash</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            features
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="">features List</a></li>
            <li><a class="dropdown-item" href="">New feature</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Categories Trash</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            sell types
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="">types List</a></li>
            <li><a class="dropdown-item" href="">New type</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Categories Trash</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            sub categories
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="">categoreis List</a></li>
            <li><a class="dropdown-item" href="">New category</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Categories Trash</a></li>
          </ul>
        </li>
      </ul>
      <form action="" method="POST">
        @csrf
        <button class="btn btn-primary" type="submit">Logout</button>
    </form>
    </div>
  </div>
</nav>
