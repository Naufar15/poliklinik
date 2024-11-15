<?php
session_start();
include('koneksi.php');

// Pengecekan registrasi
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Cek jika username sudah terdaftar
    $query = "SELECT * FROM user WHERE username='$username'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $error_message = "Username sudah terdaftar!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Hash password dan simpan data
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $mysqli->query("INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')");
        $success_message = "Akun berhasil dibuat! Silakan login.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Informasi Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Registrasi Akun</h3>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php elseif (isset($success_message)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" name="register" class="btn btn-primary w-100">Daftar</button>
            </form>
            <div class="mt-3 text-center">
                <p>Sudah punya akun? <a href="login.php">Login sekarang</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
