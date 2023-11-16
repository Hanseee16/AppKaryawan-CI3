<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">Apps Karyawan</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li
        class="nav-item <?php if ($this->uri->segment(1) == 'karyawan' && $this->uri->segment(2) == '') echo 'active' ?>">
        <a class="nav-link" href="<?= base_url('karyawan') ?>">
            <i class="bi bi-house-door-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        interface
    </div>

    <!-- Nav Item - Charts -->
    <li
        class="nav-item  <?php if ($this->uri->segment(2) == 'data_karyawan' && $this->uri->segment(3) == '') echo 'active' ?>">
        <a class="nav-link" href="<?= base_url('karyawan/data_karyawan') ?>">
            <i class="bi bi-person-fill"></i>
            <span>Data Karyawan</span></a>
    </li>

    <!-- Nav Item - Charts -->
    <li
        class="nav-item  <?php if ($this->uri->segment(2) == 'data_gaji' && $this->uri->segment(3) == '') echo 'active' ?>">
        <a class="nav-link" href="<?= base_url('karyawan/data_gaji') ?>">
            <i class="bi bi-person-check-fill"></i>
            <span>Data Gaji</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout') ?>" onclick="showConfirmDialog(event)">
            <i class="bi bi-box-arrow-in-left"></i>
            <span>Keluar</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->