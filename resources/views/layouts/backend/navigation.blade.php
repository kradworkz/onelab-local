<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/home" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboards">Dashboards</span> 
                        </a>
                    </li>

                    @if(Auth::user()->type == 'Administrator')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/staffs" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboards">Staffs</span> 
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/dropdownlists" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboards">Dropdown Lists</span> 
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-customize mr-2"></i><span key="t-apps">Apps</span> <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                            <a href="/agencies" class="dropdown-item" key="t-calendar">Agencies</a>
                            <a href="/testservices" class="dropdown-item" key="t-chat">Test Services</a>
                            <a href="/packages" class="dropdown-item" key="t-file-manager">Packages</a>
                            <a href="/addons" class="dropdown-item" key="t-file-addon">Addons</a>
                        </div>
                    </li>

                    @elseif(Auth::user()->type == 'Customer Relations Officer')

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/customers" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboards">Customers</span> 
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/requests" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboards">Requests</span> 
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/reports" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboards">Reports</span> 
                        </a>
                    </li>
                    @elseif(Auth::user()->type == 'Cashier')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/orderofpayments" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboards">Order of Payment</span> 
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/orseries" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboards">OR Series</span> 
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/types" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboards">Types</span> 
                        </a>
                    </li>
                    @elseif(Auth::user()->type == 'Lab Analyst')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/samples" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i><span key="t-dashboardss">Samples</span> 
                        </a>
                    </li>
                    @else 

                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>