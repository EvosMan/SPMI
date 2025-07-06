<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/theme/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
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
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @role('staf')
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Manajemen Dokumen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dokumen.type.index', 'kebijakan') }}"
                                    class="nav-link {{ request()->is('dokumen/kebijakan*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kebijakan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokumen.type.index', 'standar') }}"
                                    class="nav-link {{ request()->is('dokumen/standar*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Standar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokumen.type.index', 'manual') }}"
                                    class="nav-link {{ request()->is('dokumen/manual*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manual</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokumen.type.index', 'formulir') }}"
                                    class="nav-link {{ request()->is('dokumen/formulir*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Formulir</p>
                                </a>
                            </li>
                        </ul>
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
                        <a href="{{ route('validasiAudit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-check"></i>
                            <p>
                                Validasi Audit
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
                    <li class="nav-item">
                        <a href="{{ route('audit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-check-square"></i>
                            <p>
                                Audit
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('validasiAudit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-check"></i>
                            <p>
                                Pelaksanaan Audit
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
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Manajemen Dokumen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dokumen.type.index', 'kebijakan') }}"
                                    class="nav-link {{ request()->is('dokumen/kebijakan*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kebijakan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokumen.type.index', 'standar') }}"
                                    class="nav-link {{ request()->is('dokumen/standar*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Standar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokumen.type.index', 'manual') }}"
                                    class="nav-link {{ request()->is('dokumen/manual*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manual</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokumen.type.index', 'formulir') }}"
                                    class="nav-link {{ request()->is('dokumen/formulir*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Formulir</p>
                                </a>
                            </li>
                        </ul>
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
                        <a href="{{ route('validasiAudit.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-check"></i>
                            <p>
                                Validasi Audit
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
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Dokumen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dokumen.index', ['type' => 'kebijakan']) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dokumen Kebijakan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokumen.index', ['type' => 'manual']) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dokumen Manual</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokumen.index', ['type' => 'standart']) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dokumen Standart</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokumen.index', ['type' => 'formulir']) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dokumen Formulir</p>
                                </a>
                            </li>
                        </ul>
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
