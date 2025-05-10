<?php
include "db_connect.php";
$conn = db_connect();

$npm = $_POST['npm'];
$kodemk = $_POST['kodemk'];

$stmt = $conn->prepare("DELETE FROM krs WHERE mahasiswa_npm = ? AND mata_kuliah_kodemk = ?");
$stmt->bind_param("ss", $npm, $kodemk);
$success = $stmt->execute();
$stmt->close();

echo $success ? "OK" : "Gagal";
?>
