<?php
include "db_connect.php";
$conn = db_connect();

$query = "
    SELECT 
        m.npm, 
        m.nama AS nama_mahasiswa, 
        mk.nama AS nama_mk, 
        mk.jumlah_sks AS sks, 
        mk.kode_mk AS kodemk
    FROM krs k
    JOIN mahasiswa m ON k.mahasiswa_npm = m.npm
    JOIN mata_kuliah mk ON k.mata_kuliah_kodemk = mk.kode_mk
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar KRS Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<script>
function openUpdateModal(npm, kodemk) {
  document.getElementById('updateNPM').value = npm;
  document.getElementById('updateOldKodeMK').value = kodemk;
  document.getElementById('modalUpdate').classList.remove('hidden');
}

function openDeleteModal(npm, kodemk) {
  document.getElementById('deleteNPM').value = npm;
  document.getElementById('deleteKodeMK').value = kodemk;
  document.getElementById('modalDelete').classList.remove('hidden');
}

function closeModal() {
  document.getElementById('modalUpdate').classList.add('hidden');
  document.getElementById('modalDelete').classList.add('hidden');
}

function submitUpdate() {
  const npm = document.getElementById('updateNPM').value;
  const oldMK = document.getElementById('updateOldKodeMK').value;
  const newMK = document.getElementById('newMK').value;

  fetch('update_krs_ajax.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `npm=${npm}&old_kodemk=${oldMK}&new_kodemk=${newMK}`
  })
  .then(res => res.text())
  .then(response => {
    if (response.trim() === "OK") {
      location.reload();
    } else {
      alert("Update gagal!");
    }
  });
}

function submitDelete() {
  const npm = document.getElementById('deleteNPM').value;
  const kodemk = document.getElementById('deleteKodeMK').value;

  fetch('delete_krs_ajax.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `npm=${npm}&kodemk=${kodemk}`
  })
  .then(res => res.text())
  .then(response => {
    if (response.trim() === "OK") {
      location.reload();
    } else {
      alert("Gagal menghapus data.");
    }
  });
}
</script>

<body class="bg-gray-100 p-6">

    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Daftar Mahasiswa yang Mengambil KRS</h1>
        <div>
            <a href="add_mahasiswa.php" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Tambah Mahasiswa</a>
            <a href="add_krs.php" class="bg-green-500 text-white px-4 py-2 rounded">Tambah KRS</a>
        </div>
    </div>

    <table class="table-auto w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 border">No</th>
                <th class="px-4 py-2 border">Nama Lengkap</th>
                <th class="px-4 py-2 border">Mata Kuliah</th>
                <th class="px-4 py-2 border">Keterangan</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = $result->fetch_assoc()):
                $keterangan = "{$row['nama_mahasiswa']} Mengambil Mata Kuliah {$row['nama_mk']} ({$row['sks']} SKS)";
            ?>
            <tr class="<?= $no % 2 == 0 ? 'bg-gray-100' : '' ?>">
                <td class="border px-4 py-2"><?= $no++ ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_mk']) ?></td>
                <td class="border px-4 py-2 text-pink-700"><?= htmlspecialchars($keterangan) ?></td>
                <td class="border px-4 py-2">
                <button onclick="openUpdateModal('<?= $row['npm'] ?>', '<?= $row['kodemk'] ?>')" class="text-blue-500 hover:underline mr-2">Update</button>
                <button onclick="openDeleteModal('<?= $row['npm'] ?>', '<?= $row['kodemk'] ?>')" class="text-red-500 hover:underline">Delete</button>
                </td>
            </tr>
            <!-- Modal Update -->
            <div id="modalUpdate" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4">Update Mata Kuliah</h2>
                <input type="hidden" id="updateNPM">
                <input type="hidden" id="updateOldKodeMK">
                <label class="block mb-2 font-semibold">Pilih Mata Kuliah Baru</label>
                <select id="newMK" class="w-full border px-3 py-2 rounded mb-4">
                <option value="">-- Pilih Mata Kuliah --</option>
                <?php
                $matkul_result = $conn->query("SELECT kode_mk, nama FROM mata_kuliah");
                while ($m = $matkul_result->fetch_assoc()):
                ?>
                    <option value="<?= $m['kode_mk'] ?>"><?= htmlspecialchars($m['nama']) ?></option>
                <?php endwhile; ?>
                </select>
                <div class="flex justify-end">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded mr-2">Batal</button>
                <button onclick="submitUpdate()" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                </div>
            </div>
            </div>

            <!-- Modal Delete -->
            <div id="modalDelete" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4">Yakin ingin menghapus data KRS ini?</h2>
                <input type="hidden" id="deleteNPM">
                <input type="hidden" id="deleteKodeMK">
                <div class="flex justify-end">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded mr-2">Batal</button>
                <button onclick="submitDelete()" class="px-4 py-2 bg-red-500 text-white rounded">Hapus</button>
                </div>
            </div>
            </div>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
