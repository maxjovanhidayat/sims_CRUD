<!-- app/Views/sidebar.php -->
<div id="sidebar" class="bg-danger text-white p-3">
    <div class="sidebar-header row">
        <div class="col-2">
            <i class="fa fa-bag-shopping"></i>
        </div>
        <div class="col-8 text-start">
            <span class="sidebar-title">SIMS Web App</span>
        </div>
        <div class="col-2">
            <i class="fas fa-bars" id="sidebarToggleIcon"></i>
        </div>
    </div>
    <ul class="mt-4">
    <li class="<?= (current_url() == site_url('/dashboard')) ? 'active' : '' ?>">
        <a href="<?= site_url('/dashboard') ?>">
            <i class="fas fa-box"></i>
            <span class="ms-2">Produk</span>
        </a>
    </li>
    <li class="<?= (current_url() == site_url('/profil')) ? 'active' : '' ?>">
        <a href="<?= site_url('/profil') ?>">
            <i class="fa fa-user"></i>
            <span class="ms-2">Profil</span>
        </a>
    </li>
    <li class="<?= (current_url() == site_url('/logout')) ? 'active' : '' ?>">
        <a href="<?= site_url('/logout') ?>">
            <i class="fas fa-sign-out"></i>
            <span class="ms-2">Logout</span>
        </a>
    </li>
</ul>

</div>
