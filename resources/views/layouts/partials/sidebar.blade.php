<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <div class="nav_list">
                <a href="/employees" class="nav_link {{ Request::is('employees*') ? 'active' : '' }}">
                    <i class='bx bx-user nav_icon'></i>
                    <span class="nav_name">Employee Details</span>
                </a>
                <a href="/payslips" class="nav_link {{ Request::is('payslips*') ? 'active' : '' }}">
                    <i class='bx bx-calendar nav_icon'></i>
                    <span class="nav_name">Pay Slips</span>
                </a>
                <a href="{{ route('field-pay.index') }}" class="nav_link {{ request()->routeIs('field-pay.*') ? 'active' : '' }}">
                    <i class='bx bx-wallet nav_icon'></i>
                    <span class="nav_name">Field Pay</span>
                </a>
            </div>
        </div>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav_link">
            <i class='bx bx-log-out nav_icon'></i>
            <span class="nav_name">Sign Out</span>
        </a>
        <form id="logout-form" action="/logout" method="POST" class="d-none">
            @csrf
        </form>
    </nav>
</div>