
<nav id="sidebar" class="p-4 d-md-block sidebar collapse">
<div class="position-sticky">
                <ul class="nav flex-column">
                    <!-- Dashboard Button -->
                    <li class="nav-link">
                        <a class="btn w-100 btn-sidebar fw-bold fs-5 {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" 
                           href="{{ route('customer.dashboard') }}">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                    </li>
                    <!-- Profile Button -->
                    <li class="nav-link">
                        <a class="btn w-100 btn-sidebar fw-bold fs-5 {{ request()->routeIs('customer.address') ? 'active' : '' }}" 
                           href="{{ route('customer.address') }}">
                            <i class="fas fa-cog me-2"></i> Adresses
                        </a>
                    </li>
                    <!-- Orders Button -->
                    <li class="nav-link">
                        <a class="btn w-100 btn-sidebar fw-bold fs-5 {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" 
                           href="{{ route('customer.dashboard') }}">
                            <i class="fas fa-box me-2"></i> My Orders
                        </a>
                    </li>
                    <!-- Settings Button -->
                    <li class="nav-link">
                        <a class="btn w-100 btn-sidebar fw-bold fs-5 {{ request()->routeIs('customer.settings') ? 'active' : '' }}" 
                           href="{{ route('customer.settings') }}">
                            <i class="fas fa-user me-2"></i> Account Settings
                        </a>
                    </li>
                    <li class="nav-link">
                        <a class="btn w-100 btn-sidebar fw-bold fs-5 {{ request()->routeIs('customer.logout') ? 'active' : '' }}" 
                           href="{{ route('customer.logout') }}">
                           <i class="fa me-2 fa-power-off"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>