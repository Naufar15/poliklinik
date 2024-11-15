<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Poliklinik</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <?php if (isset($_SESSION['username'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="dokter.php">Data Dokter</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pasien.php">Data Pasien</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="periksa.php">Periksa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=obat">Manajemen Obat</a>
        </li>
      <?php endif; ?>
      <?php if (!isset($_SESSION['username'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
