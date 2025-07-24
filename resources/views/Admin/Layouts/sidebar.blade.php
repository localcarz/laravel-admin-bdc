<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('backend/admin/dist/img/common/dashboard-logo.png') }}"
            class="brand-image img-circle elevation-6 bg-white" alt="Best Dream Car Admin dashboard brand logo"
            style="opacity: .8">
        {{-- <img alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="display:none;visibility:hidden;"
            data-cfsrc="{{ asset('backend/admin/dist/img/common/logo.png') }}" data-cfstyle="opacity: .8">
            <noscript>
                <img src="{{ asset('backend/admin/dist/img/common/logo.png') }}" alt="Best Dream Car Admin dashboard user logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            </noscript> --}}
        <span class="brand-text font-weight-light">Best Dream Car</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('backend/admin/dist/img/common/user.png') }}" class="img-circle elevation-2"
                    alt="Best Drean Car Admin User Image">
                {{-- <img class="img-circle elevation-2" alt="User Image" data-cfsrc="{{ asset('backend/admin/dist/img/user2-160x160.jpg')}}"
                    style="display:none;visibility:hidden;">
                    <noscript>
                        <img src="{{ asset('backend/admin/dist/img/user2-160x160.jpg')}}"
                        class="img-circle elevation-2" alt="User Image">
                    </noscript> --}}
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    @auth('admin')
                        {{ Auth::guard('admin')->user()->name }}
                    @else
                        Guest User
                    @endauth
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ in_array(Route::currentRouteName(), ['admin.dashboard']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Inventory Section -->
                <li
                    class="nav-item has-treeview {{ in_array(Route::currentRouteName(), ['admin.inventory.index']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ in_array(Route::currentRouteName(), ['admin.inventory.index']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-car"></i>
                        <p>
                            Inventory
                            <i class="right fas fa-angle-left"></i>
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="padding-left: 15px;">
                        <li class="nav-item">
                            <a href="{{ route('admin.inventory.index') }}"
                                class="nav-link  {{ in_array(Route::currentRouteName(), ['admin.inventory.index']) ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Inventory List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Active Inventory</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Frontend Section Header -->
                <li class="nav-header">FRONTEND</li>

                <!-- Blogs Section -->
                <li
                    class="nav-item has-treeview {{ in_array(Route::currentRouteName(), ['admin.settings.general', 'admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ in_array(Route::currentRouteName(), ['admin.autoNews', 'admin.reviews', 'admin.toolsAndAdvice', 'admin.carBuyingAdvice', 'admin.carTips', 'admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Blogs
                            <i class="right fas fa-angle-left"></i>
                            <span class="badge badge-info right">9</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"
                        style="padding-left: 15px; display: {{ in_array(Route::currentRouteName(), ['admin.autoNews', 'admin.reviews', 'admin.toolsAndAdvice', 'admin.carBuyingAdvice', 'admin.carTips', 'admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'block' : 'none' }}">

                        <!-- Research Subsection -->
                        <li
                            class="nav-item has-treeview {{ in_array(Route::currentRouteName(), ['admin.autoNews', 'admin.reviews', 'admin.toolsAndAdvice', 'admin.carBuyingAdvice', 'admin.carTips']) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ in_array(Route::currentRouteName(), ['admin.autoNews', 'admin.reviews', 'admin.toolsAndAdvice', 'admin.carBuyingAdvice', 'admin.carTips']) ? 'active' : '' }}">
                                <i class="fas fa-search nav-icon"></i>
                                <p>
                                    Research
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview"
                                style="padding-left: 25px; display: {{ in_array(Route::currentRouteName(), ['admin.autoNews', 'admin.reviews', 'admin.toolsAndAdvice', 'admin.carBuyingAdvice', 'admin.carTips']) ? 'block' : 'none' }}">
                                <li class="nav-item">
                                    <a href="{{ route('admin.autoNews') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.autoNews' ? 'active' : '' }}">
                                        <i class="fas fa-newspaper nav-icon"></i>
                                        <p>Auto News</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.reviews') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.reviews' ? 'active' : '' }}">
                                        <i class="fas fa-star nav-icon"></i>
                                        <p>Reviews</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.toolsAndAdvice') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.toolsAndAdvice' ? 'active' : '' }}">
                                        <i class="fas fa-tools nav-icon"></i>
                                        <p>Tools & Advice</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.carBuyingAdvice') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.carBuyingAdvice' ? 'active' : '' }}">
                                        <i class="fas fa-shopping-cart nav-icon"></i>
                                        <p>Car Buying Advice</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.carTips') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.carTips' ? 'active' : '' }}">
                                        <i class="fas fa-lightbulb nav-icon"></i>
                                        <p>Car Tips</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Beyond Car Subsection -->
                        <li
                            class="nav-item has-treeview {{ in_array(Route::currentRouteName(), ['admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ in_array(Route::currentRouteName(), ['admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'active' : '' }}">
                                <i class="fas fa-globe nav-icon"></i>
                                <p>
                                    Beyond Car
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview"
                                style="padding-left: 25px; display: {{ in_array(Route::currentRouteName(), ['admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'block' : 'none' }}">
                                <li class="nav-item">
                                    <a href="{{ route('admin.news') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.news' ? 'active' : '' }}">
                                        <i class="fas fa-bullhorn nav-icon"></i>
                                        <p>News</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.innovation') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.innovation' ? 'active' : '' }}">
                                        <i class="fas fa-atom nav-icon"></i>
                                        <p>Innovation</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.opinion') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.opinion' ? 'active' : '' }}">
                                        <i class="fas fa-comment nav-icon"></i>
                                        <p>Opinion</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.financial') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.financial' ? 'active' : '' }}">
                                        <i class="fas fa-chart-line nav-icon"></i>
                                        <p>Financial</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- Others Section Header -->
                <li class="nav-header">OTHERS</li>

                <!-- Blank Page -->
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.blank') }}"
                        class="nav-link  {{ in_array(Route::currentRouteName(), ['admin.blank']) ? 'active' : '' }}">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Blank
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('admin.banner') }}"
                        class="nav-link {{ in_array(Route::currentRouteName(), ['admin.banner']) ? 'active' : '' }}">
                        <i class="nav-icon far fa-images"></i>
                        <p>
                            Banner
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.lead.index') }}"
                        class="nav-link {{ in_array(Route::currentRouteName(), ['admin.lead.index']) ? 'active' : '' }}">
                        <i class="nav-icon far fa-clipboard"></i>
                        <p>
                            Lead
                        </p>
                    </a>
                </li>

                <!-- Frontend Section Header -->
                <li class="nav-header">SETTINGS MANAGEMENT</li>

                <!-- Blogs Section -->
                <li
                    class="nav-item has-treeview {{ in_array(Route::currentRouteName(), ['admin.autoNews', 'admin.reviews', 'admin.toolsAndAdvice', 'admin.carBuyingAdvice', 'admin.carTips', 'admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ in_array(Route::currentRouteName(), ['admin.autoNews', 'admin.reviews', 'admin.toolsAndAdvice', 'admin.carBuyingAdvice', 'admin.carTips', 'admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                            <span class="badge badge-info right">5</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"
                        style="padding-left: 15px; display: {{ in_array(Route::currentRouteName(), ['admin.settings.general', 'admin.cache-commands.index']) ? 'block' : 'none' }}">

                        <!-- Research Subsection -->
                        <li
                            class="nav-item has-treeview {{ in_array(Route::currentRouteName(), ['admin.settings.general', 'admin.cache-commands.index']) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ in_array(Route::currentRouteName(), ['admin.settings.general']) ? 'active' : '' }}">
                                <i class="fas fa-cog fa-spin nav-icon"></i>
                                <p>
                                    General
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview"
                                style="padding-left: 25px; display: {{ in_array(Route::currentRouteName(), ['admin.settings.general', 'admin.cache-commands.index']) ? 'block' : 'none' }}">
                                <li class="nav-item">
                                    <a href="{{ route('admin.settings.general') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.settings.general' ? 'active' : '' }}">
                                        <i class="fas fa-globe nav-icon"></i>
                                        <p>Common</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.settings.general') }}"
                                        class="nav-link {{ Route::currentRouteName() == ' ' ? 'active' : '' }}">
                                        <i class="fas fa-tags nav-icon"></i>
                                        <p>Meta Section</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.cache-commands.index') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.cache-commands.index' ? 'active' : '' }}">
                                        {{-- <i class="fas fa-tags nav-icon"></i> --}}
                                                <i class="fas fa-bolt nav-icon"></i>
                                        <p>Cache Commands</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Beyond Car Subsection -->
                        <li
                            class="nav-item has-treeview {{ in_array(Route::currentRouteName(), ['admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ in_array(Route::currentRouteName(), ['admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'active' : '' }}">
                                <i class="fas fa-sliders-h nav-icon"></i>
                                <p>
                                    Frontend
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview"
                                style="padding-left: 25px; display: {{ in_array(Route::currentRouteName(), ['admin.news', 'admin.innovation', 'admin.opinion', 'admin.financial']) ? 'block' : 'none' }}">
                                <li class="nav-item">
                                    <a href="{{ route('admin.news') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.news' ? 'active' : '' }}">
                                        <i class="fas fa-bullhorn nav-icon"></i>
                                        <p>Top Menu</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.innovation') }}"
                                        class="nav-link {{ Route::currentRouteName() == 'admin.innovation' ? 'active' : '' }}">
                                        <i class="fas fa-atom nav-icon"></i>
                                        <p>Footer Menu</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
