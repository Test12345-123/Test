<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    @if (Auth::user()->id_level == 1 || Auth::user()->id_level == 2)
    <li class="nav-item">
      <a class="nav-link " href="{{ url('/dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    @endif

    <li class="nav-heading">Pages</li>

    @if (Auth::user()->id_level == 1 || Auth::user()->id_level == 4)
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('list-menu') }}">
        <i class="bi bi-book-half"></i>
        <span>Menu</span>
      </a>
    </li>
    @endif

    @if (Auth::user()->id_level == 2)
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('list-user') }}">
        <i class="bi bi-person"></i>
        <span>User</span>
      </a>
    </li>
    @endif

    @if (Auth::user()->id_level == 2 || Auth::user()->id_level == 3 || Auth::user()->id_level == 4)
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('order') }}">
        <i class="bi bi-pencil-square"></i>
        <span>Order</span>
      </a>
    </li>
    @endif

    @if (Auth::user()->id_level == 1 || Auth::user()->id_level == 2)
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('log') }}">
        <i class="bi bi-clock-history"></i>
        <span>Log Activity</span>
      </a>
    </li>
    @endif

    @if (Auth::user()->id_level == 1)
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('list-table') }}">
        <i class="bi bi-file-fill"></i>
        <span>Table</span>
      </a>
    </li>
    @endif

  </ul>

</aside><!-- End Sidebar-->