<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/theme/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        {{-- <i class="brand-image img-circle elevation-3 fas fa-th"
            style="width: 1.6rem;margin-top: 8px;margin-left:20px"></i> --}}
        <span class="brand-text font-weight-light">APPS SPMI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/theme/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->

                {{-- <li class="nav-header">EXAMPLES</li> --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @role('staf')
                    <li class="nav-item">
                        <a href="{{ route('dokumen.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Manajemen Dokumen
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('evaluasi.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-check-square"></i>
                            <p>
                                Manajemen Evaluasi
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwalAudit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>
                                Jadwal Audit
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feedback.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>
                                Feedback
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('monitoring.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Laporan Monitoring
                            </p>
                        </a>
                    </li>
                @endrole
                @role('auditor')
                    <li class="nav-item">
                        <a href="{{ route('jadwalAudit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>
                                Jadwal Audit
                            </p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('evaluasi.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-check-square"></i>
                            <p>
                                Evaluasi
                            </p>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{ route('audit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-check-square"></i>
                            <p>
                                Audit
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('monitoring.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Laporan Monitoring
                            </p>
                        </a>
                    </li>
                @endrole
                @role('kaprodi')
                    <li class="nav-item">
                        <a href="{{ route('dokumen.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Manajemen Dokumen
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('evaluasi.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-check-square"></i>
                            <p>
                                Evaluasi
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwalAudit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>
                                Jadwal Audit
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('monitoring.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Laporan Monitoring
                            </p>
                        </a>
                    </li>
                @endrole
                @role('direktur')
                    <li class="nav-item">
                        <a href="{{ route('dokumen.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Dokumen
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('monitoring.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Laporan Monitoring
                            </p>
                        </a>
                    </li>
                @endrole
                @role('staf|kaprodi')
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                User
                            </p>
                        </a>
                    </li>
                @endrole
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block mb-2">Log Out</button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
