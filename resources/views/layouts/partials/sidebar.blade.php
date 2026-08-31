<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <div class="nav_list">

                @can('employees.read')
                <a href="{{ route('employees.index') }}" class="nav_link {{ Request::is('employees*') ? 'active' : '' }}">
                    <i class='bx bx-user nav_icon'></i>
                    <span class="nav_name">
                        @can('employees.manage')
                        Employee Directory
                        @else
                        My Details
                        @endcan
                    </span>
                </a>
                @endcan

                @can('payroll.read')
                <a href="{{ route('payslips.index') }}" class="nav_link {{ Request::is('payslips*') ? 'active' : '' }}">
                    <i class='bx bx-calendar nav_icon'></i>
                    <span class="nav_name">Leave Balance</span>
                </a>
                @else
                <a href="{{ route('leaves.my-leaves') }}" class="nav_link {{ Request::is('my-leaves*') ? 'active' : '' }}">
                    <i class='bx bx-calendar nav_icon'></i>
                    <span class="nav_name">My Leaves</span>
                </a>
                @endcan

                @can('field-pay.read')
                <a href="{{ route('field-pay.index') }}" class="nav_link {{ request()->routeIs('field-pay.*') ? 'active' : '' }}">
                    <i class='bx bx-wallet nav_icon'></i>
                    <span class="nav_name">Field Pay</span>
                </a>
                @endcan

            </div>
        </div>

        {{-- Logout Form --}}
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav_link">
            <i class='bx bx-log-out nav_icon'></i>
            <span class="nav_name">Sign Out</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </nav>
</div>