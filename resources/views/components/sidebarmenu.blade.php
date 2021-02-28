<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('dashboard.account.add') }}" class="nav-link{{ (request()->routeIs('dashboard.account.add')) ? ' active' : '' }}">
              <p>Tambahkan akun</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link{{ (request()->routeIs('dashboard')) ? ' active' : '' }}">
              <p>Semua</p>
            </a>
          </li>
          @foreach(\App\Http\Controllers\Controller::getServices() as $result)
          <li class="nav-item">
            <a href="{{ route('dashboard.account', strtolower($result->name)) }}" class="nav-link">
              <p>{{ $result->name }}</p>
            </a>
          </li>
          @endforeach
        </ul>
    </li>
    <li class="nav-item">
      <a href="{{ route('dashboard.logs') }}" class="nav-link{{ (request()->routeIs('dashboard.logs')) ? ' active' : '' }}">
        <i class="nav-icon fas fa-clock"></i>
        <p>
          Logs
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link logout">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>
          Logout
        </p>
      </a>
    </li>
    <form action="{{ route('logout.custom') }}" method="post" id="logout">
      @csrf
    </form>
  </ul>
</nav>