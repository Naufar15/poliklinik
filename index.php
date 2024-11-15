<?php
session_start();
include('koneksi.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistem Informasi Poliklinik</a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Data Master
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?page=dokter">Dokter</a></li>
                            <li><a class="dropdown-item" href="index.php?page=pasien">Pasien</a></li>
                            <li><a class="dropdown-item" href="index.php?page=obat">Obat</a></li> <!-- New Obat link -->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=periksa">Periksa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<main role="main" class="container">
    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if (file_exists($page . '.php')) {
            include($page . '.php');
        } else {
            echo "<h2>Halaman tidak ditemukan</h2>";
        }
    } else {
        if (isset($_SESSION['username'])) {
            echo "<h2>Selamat datang, " . $_SESSION['username'] . "!</h2>";
            echo "<p>Anda dapat mengakses Data Dokter, Data Pasien, dan halaman Periksa sekarang.</p>";
        } else {
            echo "<h2>Selamat Datang di Sistem Informasi Poliklinik</h2>";
            echo "<p>Silakan login untuk mengakses data poliklinik.</p>";
        }
    }
    ?>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
