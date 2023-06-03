<!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="h-100" data-simplebar>


                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul id="side-menu">

                            <li class="menu-title">Dashboard</li>
                
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    <span> Dashboard </span>
                                </a>
                                
                            </li>

                            <li class="menu-title mt-2">Master</li>

                           <li>
                            
                                <a href="{{ route('category.index') }}">
                                    <i class="mdi mdi-shopping-search"></i>
                                    <span> Category </span>
                                </a>
                                
                            </li>

                           <li>
                                <a href="{{ route('product.index') }}">
                                    <i class="mdi mdi-shopping"></i>
                                    <span> Product </span>
                                </a>
                                
                            </li>
                           <li>
                                <a href="{{ route('stock.index') }}">
                                    <i class="mdi mdi-mail"></i>
                                    <span> Stock Manage </span>
                                </a>
                                
                            </li>
                           <li>
                                <a href="{{ route('customer.index') }}">
                                    <i class="mdi mdi-card-account-details"></i>
                                    <span> Customer </span>
                                </a>
                                
                            </li>
                           <li>
                                <a href="{{ route('supplier.index') }}">
                                    <i class="mdi mdi-account"></i>
                                    <span> Supplier </span>
                                </a>
                                
                            </li>
                            <li>
                                <a href="#sidebarAuth" data-bs-toggle="collapse">
                                    <i class="mdi mdi-account-circle-outline"></i>
                                    <span> Role and Permission </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarAuth">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="auth-login.html">Role</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('permission.index') }}">Permission</a>
                                        </li>
                                        <li>
                                            <a href="auth-register.html">Role and Permission</a>
                                        </li>
                                             </ul>
                                </div>
                            </li>

                            <li class="menu-title mt-2">Custom</li>
                            <li>
                                <a href="#sidebarLayouts" data-bs-toggle="collapse">
                                    <i class="mdi mdi-cellphone-link"></i>
                                    <span class="badge bg-blue float-end">New</span>
                                    <span> Layouts </span>
                                </a>
                                <div class="collapse" id="sidebarLayouts">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="layouts-horizontal.html">Horizontal</a>
                                        </li>
                                        <li>
                                            <a href="layouts-detached.html">Detached</a>
                                        </li>
                                        <li>
                                            <a href="layouts-two-column.html">Two Column Menu</a>
                                        </li>
                                        <li>
                                            <a href="layouts-two-tone-icons.html">Two Tones Icons</a>
                                        </li>
                                        <li>
                                            <a href="layouts-preloader.html">Preloader</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->