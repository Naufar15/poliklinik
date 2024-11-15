<?php
include('koneksi.php');

// Fetch medicine data from the database
$obatQuery = "SELECT * FROM obat";
$obatResult = $mysqli->query($obatQuery);

// Add medicine data to the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_obat'])) {
    $nama_obat = $_POST['nama_obat'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    // Insert new medicine data into the database
    $stmt = $mysqli->prepare("INSERT INTO obat (nama_obat, stok, harga) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nama_obat, $stok, $harga);
    $stmt->execute();
    $stmt->close();

    // Redirect to refresh the page
    header("Location: index.php?page=obat");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Obat</title>
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
        .table thead {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manajemen Obat</h2>

    <!-- Add Medicine Form -->
    <div class="form-container">
        <h4>Tambah Obat</h4>
        <form method="POST">
            <div class="mb-3">
                <label for="nama_obat" class="form-label">Nama Obat</label>
                <input type="text" name="nama_obat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <button type="submit" name="add_obat" class="btn btn-primary">Tambah Obat</button>
        </form>
    </div>

    <!-- Display Medicine Data -->
    <h3>Daftar Obat</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Aksi</th> <!-- Add action column -->
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $obatResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_obat']); ?></td>
                    <td><?php echo $row['stok']; ?></td>
                    <td><?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td class="btn-actions">
                        <a href="edit_obat.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_obat.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
