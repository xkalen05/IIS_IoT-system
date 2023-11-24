@if(Auth::user()->role === 'admin')
    <ul class="nav flex-column bg-dark color-light min-vh-100 px-4 py-4 " data-bs-theme="dark">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('admin.dashboard')}}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('profile.index')}}">Profile</a>
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
@else
    <ul class="nav flex-column bg-dark color-light min-vh-100 px-4 py-4 " data-bs-theme="dark">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('user.dashboard')}}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('profile.index')}}">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#systemsCollapse">
                Systems
            </a>
            <div class="collapse" id="systemsCollapse">
                <ul class="nav flex-column pl-4">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.systems') }}">My Systems</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.systems.shared') }}">Shared with Me</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.systems.others') }}">Other Systems</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Devices</a>
        </li>
    </ul>
@endif

