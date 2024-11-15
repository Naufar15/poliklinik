<?php
session_start();
include('koneksi.php');

// Get the ID of the medicine to be deleted
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the medicine from the database
    $deleteQuery = "DELETE FROM obat WHERE id = ?";
    $stmt = $mysqli->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the "Obat" page
    header("Location: index.php?page=obat");
} else {
    echo "Obat tidak ditemukan!";
    exit;
}
