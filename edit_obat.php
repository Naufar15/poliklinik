<?php
session_start();
include('koneksi.php');

// Get the ID of the medicine to be edited
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch the existing medicine details from the database
    $query = "SELECT * FROM obat WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $obat = $result->fetch_assoc();
    $stmt->close();

    // If the form is submitted, update the medicine data
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_obat'])) {
        $nama_obat = $_POST['nama_obat'];
        $stok = $_POST['stok'];
        $harga = $_POST['harga'];

        // Update the medicine data
        $updateQuery = "UPDATE obat SET nama_obat = ?, stok = ?, harga = ? WHERE id = ?";
        $stmt = $mysqli->prepare($updateQuery);
        $stmt->bind_param("sisi", $nama_obat, $stok, $harga, $id);
        $stmt->execute();
        $stmt->close();

        // Redirect back to the "Obat" page
        header("Location: index.php?page=obat");
    }
} else {
    echo "Obat tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Obat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }
        .form-container {
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Edit Obat</h2>
        <form method="POST">
            <!-- Medicine Name -->
            <div class="mb-3">
                <label for="nama_obat" class="form-label">Nama Obat</label>
                <input type="text" class="form-control" id="nama_obat" name="nama_obat" value="<?php echo htmlspecialchars($obat['nama_obat']); ?>" required>
            </div>

            <!-- Stock -->
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo htmlspecialchars($obat['stok']); ?>" required>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($obat['harga']); ?>" required>
            </div>

            <button type="submit" name="update_obat" class="btn btn-primary">Update Obat</button>
            <a href="index.php?page=obat" class="btn btn-secondary ms-3">Kembali</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
