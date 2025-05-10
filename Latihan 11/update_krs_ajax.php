<?php
include "db_connect.php";
$conn = db_connect();

$npm = $_POST['npm'];
$old_kodemk = $_POST['old_kodemk'];
$new_kodemk = $_POST['new_kodemk'];

$stmt = $conn->prepare("UPDATE krs SET mata_kuliah_kodemk = ? WHERE mahasiswa_npm = ? AND mata_kuliah_kodemk = ?");
$stmt->bind_param("sss", $new_kodemk, $npm, $old_kodemk);
$success = $stmt->execute();
$stmt->close();

echo $success ? "OK" : "Gagal";
?>
