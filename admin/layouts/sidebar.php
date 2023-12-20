<!-- sidebar -->
<div class="sidebar">
  <div class="sidebar__header">
    <a href="./index.php" class="sidebar__brand"><img src="../assets/img/logo.png" alt="FloraFavs" /></a>
  </div>
  <nav class="sidebar__body">
    <ul class="sidebar__menu-list">
      <li class="sidebar__menu-item">
        <a href="./index.php" class="sidebar__menu-link <?= $page === 'home' ? 'sidebar__menu-link_active' : ''; ?>">
          <i class="ph ph-house"></i>
          Beranda
        </a>
      </li>
      <?php if ($_SESSION['role_name'] == 'manager') : ?>
        <li class="sidebar__menu-item">
          <a href="./manager-unpaid-transactions.php" class="sidebar__menu-link <?= $page === 'unpaid-transactions' ? 'sidebar__menu-link_active' : ''; ?>">
            <i class="ph ph-fire"></i>
            Transaksi Belum Lunas
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['role_name'] == 'administrator') : ?>
        <li class="sidebar__menu-item">
          <a href="./unpaid-transactions.php" class="sidebar__menu-link <?= $page === 'unpaid-transactions' ? 'sidebar__menu-link_active' : ''; ?>">
            <i class="ph ph-fire"></i>
            Transaksi Belum Lunas
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['role_name'] == 'manager') : ?>
        <li class="sidebar__menu-item">
          <a href="./paid-transactions.php" class="sidebar__menu-link <?= $page === 'paid-transactions' ? 'sidebar__menu-link_active' : ''; ?>">
            <i class="ph ph-receipt"></i>
            Transaksi Lunas
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['role_name'] == 'administrator') : ?>
        <li class="sidebar__menu-item">
          <a href="./products.php" class="sidebar__menu-link <?= $page === 'products' ? 'sidebar__menu-link_active' : ''; ?>">
            <i class="ph ph-package"></i>
            Tanaman
          </a>
        </li>
        <li class="sidebar__menu-item">
          <a href="./categories.php" class="sidebar__menu-link <?= $page === 'categories' ? 'sidebar__menu-link_active' : ''; ?>">
            <i class="ph ph-tag"></i>
            Kategori
          </a>
        </li>
        <li class="sidebar__menu-item">
          <a href="./suppliers.php" class="sidebar__menu-link <?= $page === 'suppliers' ? 'sidebar__menu-link_active' : ''; ?>">
            <i class="ph ph-truck"></i>
            Pemasok
          </a>
        </li>
        <li class="sidebar__menu-item">
          <a href="./customers.php" class="sidebar__menu-link <?= $page === 'customers' ? 'sidebar__menu-link_active' : ''; ?>">
            <i class="ph ph-users"></i>
            Pelanggan
          </a>
        </li>
      <?php endif; ?>
    </ul>
    <?php if ($_SESSION['role_name'] == 'manager') : ?>
      <a href="./manager-unpaid-transactions.php" class="sidebar__cta">
        Lihat transaksi belum lunas
        <i class="ph ph-arrow-right"></i>
      </a>
    <?php endif; ?>
    <?php if ($_SESSION['role_name'] == 'administrator') : ?>
      <a href="./unpaid-transactions.php" class="sidebar__cta">
        Lihat transaksi belum lunas
        <i class="ph ph-arrow-right"></i>
      </a>
    <?php endif; ?>
  </nav>
</div>
<!-- end sidebar -->