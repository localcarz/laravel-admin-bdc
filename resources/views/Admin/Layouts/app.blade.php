<!DOCTYPE html>
<html lang="en">
@include('Admin.Layouts.header')
<style>
    .nav-item.menu-open>.nav-link {
        background-color: rgba(255, 255, 255, .1);
    }

    .nav-link.active {
        background-color: rgba(255, 255, 255, .2);
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <script type="text/javascript" style="display:none">
                //<![CDATA[
                window.__mirage2 = {
                    petok: "4zJ_niCVMaRg4No.jBAYnNhRIP5CEhJ9XKGcdjHhpHQ-14400-0.0.1.1"
                };
                //]]>
            </script>
            <script type="text/javascript" src="{{ asset('backend/admin/dist/js/mirage2.min.js') }}"></script>
            <img class="animation__shake" alt="AdminLTELogo" height="60" width="60"
                data-cfsrc="{{ asset('backend/admin/dist/img/AdminLTELogo.png') }}"
                style="display:none;visibility:hidden;"><noscript><img class="animation__shake"
                    src="{{ asset('backend/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60"
                    width="60"></noscript>
        </div>

        <!-- Navbar -->
        @include('Admin.Layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('Admin.Layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022-2025 <a href="https://bestdreamcar.com">Best Dream Car</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @include('Admin.Layouts.footer')
    @stack('scripts')
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize nav treeview
                $('.nav-treeview').hide();
                $('.has-treeview').on('click', function(e) {
                    e.preventDefault();

                    // Close other open menus at the same level
                    $(this).siblings('.has-treeview').removeClass('menu-open');
                    $(this).siblings('.has-treeview').find('.nav-treeview').slideUp();

                    // Toggle current menu
                    $(this).toggleClass('menu-open');
                    $(this).find('> .nav-treeview').slideToggle();
                });
            });
            // Add this to your script
            $(function() {
                // Get current route
                const currentRoute = "{{ request()->route()->getName() }}";

                // Find matching nav link and expand parents
                $('.nav-link[href*="' + currentRoute + '"]').each(function() {
                    $(this).addClass('active');
                    $(this).parents('.has-treeview').addClass('menu-open');
                    $(this).parents('.nav-treeview').css('display', 'block');
                });
            });
        </script>
    @endpush
</body>

</html>
