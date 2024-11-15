<?php
include('koneksi.php');

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Insert or update patient data
if (isset($_POST['save'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $mysqli->query("UPDATE pasien SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id=$id");
    } else {
        $mysqli->query("INSERT INTO pasien (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')");
    }
}

// Delete patient record
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];
    $mysqli->query("DELETE FROM pasien WHERE id=$id");
}

// Fetch patient data
$result = $mysqli->query("SELECT * FROM pasien");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 30px;
        }
        .form-container {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        table th, table td {
            text-align: center;
        }
        .btn-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Data Pasien</h2>

    <!-- Patient Input Form -->
    <div class="form-container">
        <h4>Tambah / Edit Pasien</h4>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pasien</label>
                <input type="text" name="nama" class="form-control" required value="<?php echo isset($row['nama']) ? $row['nama'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" required value="<?php echo isset($row['alamat']) ? $row['alamat'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" required value="<?php echo isset($row['no_hp']) ? $row['no_hp'] : ''; ?>">
            </div>
            <button type="submit" name="save" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <!-- Patient Data Table -->
    <h4>Daftar Pasien</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                    <td class="btn-actions">
                        <a href="pasien.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="pasien.php?id=<?php echo $row['id']; ?>&aksi=hapus" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
