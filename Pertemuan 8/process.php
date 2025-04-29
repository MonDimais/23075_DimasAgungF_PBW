<?php
// Array list data pajak bandara
$bandara = [
    "Ngurah Rai (DPS)" => 80000,
    "Soekarno-Hatta (CGK)" => 100000,
    "Juanda (SUB)" => 90000,
    "Hasanuddin (UPG)" => 85000,
    "Sultan Iskandar Muda (BTJ)" => 75000
];

// Inisialisasi variabel
$namaMaskapai = htmlspecialchars($_POST["nama_maskapai"] ?? "");
$bandaraAsal = $_POST["bandara_asal"] ?? "";
$bandaraTujuan = $_POST["bandara_tujuan"] ?? "";
$hargaTiket = (int)($_POST["harga_tiket"] ?? 0);

// Menghitung pajak berdasarkan bandara asal dan tujuan
$pajakAsal = $bandara[$bandaraAsal] ?? 0;
$pajakTujuan = $bandara[$bandaraTujuan] ?? 0;
$totalPajak = $pajakAsal + $pajakTujuan;
$totalHarga = $hargaTiket + $totalPajak;

// Format function untuk format angka ke dalam format Rupiah
function formatRupiah($angka) {
    return number_format($angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pendaftaran Rute Penerbangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Hasil Pendaftaran Rute Penerbangan</h1>
        
        <h2 class="text-xl font-semibold mb-4">Detail Penerbangan</h2>
        <div class="mb-6">
            <p class="text-lg font-semibold"><?php echo $namaMaskapai; ?></p>
            <table class="w-full border-collapse mb-6">
                <tr class="border">
                    <th class="border p-2 bg-gray-100 text-left">Asal Penerbangan</th>
                    <td class="border p-2"><?php echo $bandaraAsal; ?></td>
                </tr>
                <tr class="border">
                    <th class="border p-2 bg-gray-100 text-left">Tujuan Penerbangan</th>
                    <td class="border p-2"><?php echo $bandaraTujuan; ?></td>
                </tr>
                <tr class="border">
                    <th class="border p-2 bg-gray-100 text-left">Harga Tiket</th>
                    <td class="border p-2">Rp <?php echo formatRupiah($hargaTiket); ?></td>
                </tr>
                <tr class="border">
                    <th class="border p-2 bg-gray-100 text-left">Pajak</th>
                    <td class="border p-2">Rp <?php echo formatRupiah($totalPajak); ?></td>
                </tr>
                <tr class="border">
                    <th class="border p-2 bg-gray-100 text-left">Total Harga Tiket</th>
                    <td class="border p-2">Rp <?php echo formatRupiah($totalHarga); ?></td>
                </tr>
            </table>
        </div>
        
        <h2 class="text-xl font-semibold mb-4">Detail Pajak</h2>
        <table class="w-full border-collapse mb-6">
            <tr class="border">
                <th class="border p-2 bg-gray-100">Bandara</th>
                <th class="border p-2 bg-gray-100">Pajak</th>
            </tr>
            <tr class="border">
                <td class="border p-2"><?php echo $bandaraAsal; ?></td>
                <td class="border p-2">Rp <?php echo formatRupiah($pajakAsal); ?></td>
            </tr>
            <tr class="border">
                <td class="border p-2"><?php echo $bandaraTujuan; ?></td>
                <td class="border p-2">Rp <?php echo formatRupiah($pajakTujuan); ?></td>
            </tr>
            <tr class="border">
                <td class="border p-2 font-bold">Total Pajak</td>
                <td class="border p-2 font-bold">Rp <?php echo formatRupiah($totalPajak); ?></td>
            </tr>
        </table>
        
        <p class="mb-6">Tanggal pendaftaran: <?php echo date("d-m-Y H:i:s"); ?></p>
        
        <div class="flex gap-2">
            <a href="index.html" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded inline-block">Kembali ke Form Pendaftaran</a>
            <a href="process.php" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded inline-block">Bersihkan Data</a>
        </div>
    </div>
</body>
</html>