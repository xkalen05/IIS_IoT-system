@if(Auth::user()->role === 'admin')
    <ul class="nav flex-column bg-dark color-light min-vh-100 px-4 py-4 " data-bs-theme="dark">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{route('admin.dashboard')}}">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.users')}}">Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.systems')}}">Systems</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.devices')}}">Devices</a>
      </li>
    </ul>
@endif

    <ul class="nav flex-column bg-dark color-light min-vh-100 px-4 py-4 " data-bs-theme="dark">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{route('user.dashboard')}}">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="{{route('admin.users')}}">Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="{{route('admin.systems')}}">Systems</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="{{route('admin.devices')}}">Devices</a>
      </li>
    </ul>


