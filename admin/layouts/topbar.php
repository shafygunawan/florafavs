<!-- topbar -->
<div class="topbar">
  <div class="container container_admin topbar__container">
    <div class="topbar__left">
      <h1 class="topbar__title"><?= isset($title) ? $title : 'Dashboard'; ?></h1>
    </div>
    <div class="topbar__right">
      <div class="topbar__profile">
        <label for="topbar__profile-toggler" class="topbar__profile-toggler">
          <img src="../assets/img/default-profile.jpg" alt="<?= $_SESSION['staff_name'] ?>" class="topbar__profile-img" />
          <span class="topbar__profile-name"><?= $_SESSION['staff_name'] ?></span>
          <i class="ph ph-caret-right topbar__profile-dropdown-img"></i>
        </label>
        <input type="checkbox" id="topbar__profile-toggler">
        <div class="topbar__profile-menu-list">
          <a href="./logout.php" class="topbar__profile-menu-link">
            <i class="ph ph-arrow-right"></i>
            Keluar
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end topbar -->