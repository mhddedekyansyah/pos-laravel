@include('partials.header')
        <!-- Begin page -->
        <div id="wrapper">

            
         @include('partials.navbar')

            @include('partials.sidebar')

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                @yield('content')
                          
                @include('partials.footer')
            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


       @include('partials.js')