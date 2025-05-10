<?php
session_start();
include "db_connect.php";
$conn = db_connect();

// Ambil daftar mata kuliah
$matkul_options = [];
$result = $conn->query("SELECT nama FROM mata_kuliah");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $matkul_options[] = $row['nama'];
    }
}

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $matkul = $_POST['matkul'];

    // Ambil NPM berdasarkan nama mahasiswa
    $stmt1 = $conn->prepare("SELECT npm FROM mahasiswa WHERE nama = ?");
    $stmt1->bind_param("s", $nama);
    $stmt1->execute();
    $stmt1->bind_result($npm);
    $stmt1->fetch();
    $stmt1->close();

    // Ambil kode MK berdasarkan nama mata kuliah
    $stmt2 = $conn->prepare("SELECT kode_mk FROM mata_kuliah WHERE nama = ?");
    $stmt2->bind_param("s", $matkul);
    $stmt2->execute();
    $stmt2->bind_result($kodemk);
    $stmt2->fetch();
    $stmt2->close();

    if ($npm && $kodemk) {
        // Cek apakah data sudah ada
        $check = $conn->prepare("SELECT * FROM krs WHERE mahasiswa_npm = ? AND mata_kuliah_kodemk = ?");
        $check->bind_param("ss", $npm, $kodemk);
        $check->execute();
        $result_check = $check->get_result();
        if ($result_check->num_rows > 0) {
            $error = "Data KRS sudah ada.";
        } else {
            // Masukkan ke tabel KRS
            $stmt3 = $conn->prepare("INSERT INTO krs (mahasiswa_npm, mata_kuliah_kodemk) VALUES (?, ?)");
            $stmt3->bind_param("ss", $npm, $kodemk);

            if ($stmt3->execute()) {
                $success = "Data KRS berhasil ditambahkan!";
                header("Location: index.php"); // Redirect ke halaman utama setelah berhasil
                exit;
            } else {
                $error = "Gagal menambahkan data KRS: " . $conn->error;
            }

            $stmt3->close();
        }
        $check->close();
    } else {
        $error = "Mahasiswa atau mata kuliah tidak ditemukan.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah KRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md mt-8">
        <h2 class="text-2xl font-bold mb-6">Tambah KRS</h2>

        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nama Mahasiswa</label>
                <input type="text" name="nama" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Mata Kuliah</label>
                <select name="matkul" required class="w-full border px-3 py-2 rounded">
                    <option value="">-- Pilih Mata Kuliah --</option>
                    <?php foreach ($matkul_options as $matkul): ?>
                        <option value="<?= htmlspecialchars($matkul) ?>"><?= htmlspecialchars($matkul) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Simpan KRS</button>
        </form>
    </div>
</body>
</html>
