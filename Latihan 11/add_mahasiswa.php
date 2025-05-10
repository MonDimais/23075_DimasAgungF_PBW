<?php
session_start();
include "db_connect.php";
$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];

    $stmt = $conn->prepare("INSERT INTO mahasiswa (npm, nama, jurusan, alamat) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $npm, $nama, $jurusan, $alamat);

    if ($stmt->execute()) {
        $success = "Data mahasiswa berhasil ditambahkan!";
        header("Location: index.php"); // Redirect ke halaman utama setelah berhasil
        exit;
    } else {
        $error = "Gagal menambahkan data: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6">Tambah Data Mahasiswa</h2>
        <?php if (isset($success)): ?>
            <div class="bg-green-100 text-green-700 p-2 mb-4 rounded"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-4">
                <label class="block mb-1 font-semibold">NPM</label>
                <input type="text" name="npm" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nama</label>
                <input type="text" name="nama" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Jurusan</label>
                <select name="jurusan" required class="w-full border px-3 py-2 rounded">
                    <option value="">-- Pilih Jurusan --</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Alamat</label>
                <textarea name="alamat" required class="w-full border px-3 py-2 rounded"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>