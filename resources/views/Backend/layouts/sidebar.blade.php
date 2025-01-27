<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        @if (Auth::check())
            @php
                $userRole = Auth::user()->role->role_name;

            @endphp

            @php
                $routes = [
                    'Super Admin' => 'super.admin.dashboard',
                    'Admin' => 'admin.dashboard',
                    'User' => 'user.dashboard',
                ];
                $logoUrl =
                    'https://storage.googleapis.com/a1aa/image/enphJxBPaMWWaiVGW65XhTEEsArCFfIRkcZfzUFhSKginlnnA.jpg';
            @endphp

            @if (array_key_exists($userRole, $routes))
                <a href="{{ route($routes[$userRole]) }}" class="app-brand-link">
                    <span class="app-brand-logo demo m-auto align-middle d-block">
                        <img src="{{ asset($logoUrl) }}" alt="Logo" style="width: 100px; height: 100px">
                    </span>
                    {{-- Optional text rendering here --}}
                </a>
            @endif
        @endif
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    @if (Auth::check() && Auth::user()->role->role_name == 'Super Admin')
        <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item {{ request()->routeIs('super.admin.dashboard') ? 'active open' : '' }}">
                <a href="{{ route('super.admin.dashboard') }}" class="menu-link text-wrap">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboards">Dashboard</div>

                </a>
            </li>
            <li class="menu-item {{ request()->is('superAdmin/users*') ? 'active open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Layouts">Users Management</div>
                </a>
                <ul class="menu-sub {{ request()->is('superAdmin/users*') ? 'show' : '' }}">
                    <li class="menu-item {{ request()->type === 'Super Admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'Super Admin']) }}" class="menu-link">
                            Super Admin Lists
                        </a>
                    </li>
                    <li class="menu-item {{ request()->type === 'admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'admin']) }}" class="menu-link">
                            Admin Lists
                        </a>
                    </li>
                    <li class="menu-item {{ request()->type === 'user' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'user']) }}" class="menu-link">
                            User Lists
                        </a>
                    </li>
                </ul>
            </li>
            <li
                class="menu-item {{ request()->routeIs('RequestOwnerLists.*') || request()->routeIs('tenants-agreements.*') ? 'active open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Layouts">Application and Agreements</div>
                </a>

                <ul
                    class="menu-sub {{ request()->routeIs('RequestOwnerLists.*') || request()->routeIs('tenants-agreements.*') ? 'show' : '' }}">
                    <!-- Request Application -->
                    <li
                        class="menu-item {{ request()->routeIs('RequestOwnerLists.index') || request()->routeIs('RequestOwnerLists.trash*') ? 'active' : '' }}">
                        <a href="{{ route('RequestOwnerLists.index') }}" class="menu-link">
                            Request Application
                        </a>
                    </li>
                    <!-- Tenant Agreements -->
                    <li
                        class="menu-item {{ request()->routeIs('tenants-agreements.index') || request()->routeIs('tenants-agreements.trash*') ? 'active' : '' }}">
                        <a href="{{ route('tenants-agreements.index') }}" class="menu-link">
                            Tenant Agreements
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item {{ request()->is('superadmin.companies.index*') ? 'active open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Layouts">Property/Product Management</div>
                </a>
                <ul class="menu-sub {{ request()->is('superadmin.companies.index*') ? 'show' : '' }}">
                    <li class="menu-item {{ request()->type === 'super-admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'super-admin']) }}" class="menu-link">
                            Product Category
                        </a>
                    </li>

                    <li class="menu-item {{ request()->type === 'admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'admin']) }}" class="menu-link">
                            Product Lists
                        </a>
                    </li>


                </ul>
            </li>
            <li class="menu-item {{ request()->is('superadmin.companies.index*') ? 'active open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Layouts">Maintenance and Support</div>
                </a>
                <ul class="menu-sub {{ request()->is('superadmin.companies.index*') ? 'show' : '' }}">
                    <li class="menu-item {{ request()->type === 'super-admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'super-admin']) }}" class="menu-link">
                            Maintainance Application
                        </a>
                    </li>
                    <li class="menu-item {{ request()->type === 'admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'admin']) }}" class="menu-link">
                            Chat Support
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item {{ request()->is('superadmin.companies.index*') ? 'active open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Layouts">Analytical and Reports</div>
                </a>
                <ul class="menu-sub {{ request()->is('superadmin.companies.index*') ? 'show' : '' }}">
                    <li class="menu-item {{ request()->type === 'super-admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'super-admin']) }}" class="menu-link">
                            User Activity Report
                        </a>
                    </li>
                    <li class="menu-item {{ request()->type === 'admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'admin']) }}" class="menu-link">
                            Tenant Activity Report
                        </a>
                    </li>
                    <li class="menu-item {{ request()->type === 'admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'admin']) }}" class="menu-link">
                            Maintainance Activity Report
                        </a>
                    </li>
                    <li class="menu-item {{ request()->type === 'admin' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.users.index', ['type' => 'admin']) }}" class="menu-link">
                            Property Activity Report
                        </a>
                    </li>
                </ul>
            </li>
            <li
                class="menu-item {{ request()->routeIs('blogs.index') || request()->routeIs('teams.index') || request()->routeIs('testimonials.index') || request()->routeIs('faqs.index') || request()->routeIs('abouts.index') || request()->routeIs('sites.index') || request()->routeIs('sliders.index') || request()->routeIs('galleries.index') ? 'active open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Layouts">Content Management</div>
                </a>
                <ul class="menu-sub {{ request()->is('superAdmin/*') ? 'show' : '' }}">
                    <li class="menu-item {{ request()->is('superAdmin/sliders') ? 'active' : '' }}">
                        <a href="{{ route('sliders.index') }}" class="menu-link">
                            Slider
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('superAdmin/galleries') ? 'active' : '' }}">
                        <a href="{{ route('galleries.index') }}" class="menu-link">
                            Gallery
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('blogs.index') ? 'active' : '' }}">
                        <a href="{{ route('blogs.index') }}" class="menu-link">
                            Blogs
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('teams.index') ? 'active' : '' }}">
                        <a href="{{ route('teams.index') }}" class="menu-link">
                            Teams
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('testimonials.index') ? 'active' : '' }}">
                        <a href="{{ route('testimonials.index') }}" class="menu-link">
                            Testimonials
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('abouts.index') ? 'active' : '' }}">
                        <a href="{{ route('abouts.index') }}" class="menu-link">
                            About Us
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('faqs.index') ? 'active' : '' }}">
                        <a href="{{ route('faqs.index') }}" class="menu-link">
                            FAQ Lists
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('sites.index') ? 'active' : '' }}">
                        <a href="{{ route('sites.index') }}" class="menu-link">
                            Site Management
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    @elseif(Auth::check() && Auth::user()->role->role_name == 'Admin')
        <ul class="menu-inner py-1">
            <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active open' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="menu-link text-wrap">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboards">Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('admin.users.index*') ? 'active open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Layouts">Users Management</div>
                </a>
                <ul class="menu-sub {{ request()->is('admin.users.index*') ? 'show' : '' }}">

                    <li class="menu-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}	 ">
                        <a href="{{ route('admin.users.index', ['type' => 'admin']) }}" class="menu-link">
                            User Lists
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.agreement.index*') ? 'active open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Layouts">Agreements</div>
                </a>
                <ul class="menu-sub {{ request()->routeIs('admin.agreement.index*') ? 'show' : '' }}">
                    <!-- Request Application -->
                    <li class="menu-item {{ request()->routeIs('admin.agreement.index*') ? 'active' : '' }}">
                        <a href="{{ route('admin.agreement.index') }}" class="menu-link">
                            Your agreement Lists
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="#" class="menu-link">
                            Customer Agreements
                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="menu-item 
    {{ request()->routeIs('categories.index*') ||
    request()->routeIs('subCategories.index*') ||
    request()->routeIs('subCategory.trash-view*') ||
    request()->routeIs('category.trash-view*') ||
    request()->routeIs('products.index*') ||
    request()->routeIs('product.trash-view*')
        ? 'active open'
        : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon bx bx-user"></i>
                    <div data-i18n="Layouts">Property / Product Management</div>
                </a>
                <ul
                    class="menu-sub 
        {{ request()->routeIs('categories.index*') ||
        request()->routeIs('subCategories.index*') ||
        request()->routeIs('subCategory.trash-view*') ||
        request()->routeIs('category.trash-view*') ||
        request()->routeIs('products.index*') ||
        request()->routeIs('product.trash-view*')
            ? 'show'
            : '' }}">
                    <li
                        class="menu-item 
            {{ request()->routeIs('categories.index*') || request()->routeIs('category.trash-view*') ? 'active' : '' }}">
                        <a href="{{ route('categories.index') }}" class="menu-link">
                            Product Category
                        </a>
                    </li>
                    <li
                        class="menu-item 
            {{ request()->routeIs('subCategories.index*') || request()->routeIs('subCategory.trash-view*') ? 'active' : '' }}">
                        <a href="{{ route('subCategories.index') }}" class="menu-link">
                            Product Sub Category
                        </a>
                    </li>
                    <li
                        class="menu-item 
            {{ request()->routeIs('products.index*') || request()->routeIs('product.trash-view*') ? 'active' : '' }}">
                        <a href="{{ route('products.index') }}" class="menu-link">
                            Product Lists
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    @elseif(Auth::check() && Auth::user()->role->role_name == 'User')
    @endif


</aside>
<!-- END: Main Menu-->
