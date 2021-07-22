<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item active ">
            <a href="/" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Home</span>
            </a>
        </li>

        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-stack"></i>
                <span>Human Resource</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item ">
                    <a href="/master/divisi">Divisi</a>
                </li>
                <li class="submenu-item ">
                    <a href="/master/jabatan">Jabatan</a>
                </li>
                <li class="submenu-item ">
                    <a href="/master/karyawan">Karyawan</a>
                </li>
                <li class="submenu-item ">
                    <a href="/master/salary">Gaji</a>
                </li>
            </ul>
        </li>

        <li class="sidebar-item">
            <a href="/attendance" class='sidebar-link'>
                <i class="bi bi-person-badge-fill"></i>
                <span>Absensi</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="/salaries" class='sidebar-link'>
                <i class="bi bi-cash"></i>
                <span>Finance</span>
            </a>
        </li>

        <li class="sidebar-item">
            {{-- <a href="/" class='sidebar-link'>
                <i class="bi bi-door-closed-fill"></i> Logout
                  <span class="float-right text-muted text-sm"></span>
            </a> --}}

            <a class='sidebar-link' href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
             {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>
