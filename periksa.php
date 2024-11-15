<?php
include("koneksi.php");

// Menyimpan data periksa
if (isset($_POST['save'])) {
    $id_dokter = $_POST['id_dokter'];
    $id_pasien = $_POST['id_pasien'];
    $tgl_periksa = $_POST['tgl_periksa'];
    $catatan = $_POST['catatan'];
    $obat = $_POST['obat'];  // Menambahkan obat

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Jika ID ada, lakukan update
        $id = $_POST['id'];
        $stmt = $mysqli->prepare("UPDATE periksa SET id_dokter=?, id_pasien=?, tgl_periksa=?, catatan=?, obat=? WHERE id=?");
        $stmt->bind_param("iisssi", $id_dokter, $id_pasien, $tgl_periksa, $catatan, $obat, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Jika tidak, lakukan insert
        $stmt = $mysqli->prepare("INSERT INTO periksa (id_dokter, id_pasien, tgl_periksa, catatan, obat) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $id_dokter, $id_pasien, $tgl_periksa, $catatan, $obat);
        $stmt->execute();
        $stmt->close();
    }
}

// Hapus data periksa
if (isset($_GET['id']) && isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];
    $stmt = $mysqli->prepare("DELETE FROM periksa WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Mengambil data periksa dengan join ke tabel dokter dan pasien
$result = $mysqli->query("SELECT pr.*, d.nama as nama_dokter, p.nama as nama_pasien FROM periksa pr LEFT JOIN dokter d ON pr.id_dokter = d.id LEFT JOIN pasien p ON pr.id_pasien = p.id ORDER BY pr.tgl_periksa DESC");

// Mengambil data dokter dan pasien untuk dropdown
$dokter = $mysqli->query("SELECT * FROM dokter");
$pasien = $mysqli->query("SELECT * FROM pasien");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemeriksaan - Sistem Informasi Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <h2>Data Pemeriksaan</h2>

    <form method="POST" class="card p-4 shadow-sm mb-5">
        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

        <div class="mb-3">
            <label for="id_dokter" class="form-label">Dokter</label>
            <select name="id_dokter" class="form-control" required>
                <option value="">Pilih Dokter</option>
                <?php while ($row = $dokter->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo (isset($_GET['id']) && $row['id'] == $editRow['id_dokter']) ? 'selected' : ''; ?>><?php echo $row['nama']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_pasien" class="form-label">Pasien</label>
            <select name="id_pasien" class="form-control" required>
                <option value="">Pilih Pasien</option>
                <?php while ($row = $pasien->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo (isset($_GET['id']) && $row['id'] == $editRow['id_pasien']) ? 'selected' : ''; ?>><?php echo $row['nama']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tgl_periksa" class="form-label">Tanggal Periksa</label>
            <input type="datetime-local" name="tgl_periksa" class="form-control" required value="<?php echo isset($editRow['tgl_periksa']) ? date('Y-m-d\TH:i', strtotime($editRow['tgl_periksa'])) : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea name="catatan" class="form-control" rows="3"><?php echo isset($editRow['catatan']) ? $editRow['catatan'] : ''; ?></textarea>
        </div>

        <!-- Menambahkan input obat -->
        <div class="mb-3">
            <label for="obat" class="form-label">Obat</label>
            <textarea name="obat" class="form-control" rows="3"><?php echo isset($editRow['obat']) ? $editRow['obat'] : ''; ?></textarea>
        </div>

        <button type="submit" name="save" class="btn btn-primary">Simpan</button>
    </form>

    <h4>Daftar Pemeriksaan</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Periksa</th>
                <th>Catatan</th>
                <th>Obat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama_pasien']; ?></td>
                    <td><?php echo $row['nama_dokter']; ?></td>
                    <td><?php echo $row['tgl_periksa']; ?></td>
                    <td><?php echo $row['catatan']; ?></td>
                    <td><?php echo $row['obat']; ?></td> <!-- Menambahkan kolom obat -->
                    <td>
                        <a href="index.php?page=periksa&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Ubah</a>
                        <a href="index.php?page=periksa&id=<?php echo $row['id']; ?>&aksi=hapus" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
