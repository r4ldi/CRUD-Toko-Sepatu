<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = trim($_POST['id_pelanggan']);
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $no_telp = trim($_POST['no_telp']);

    try {
        $stmt = $pdo->prepare("INSERT INTO pelanggan (id_pelanggan, nama, alamat, no_telp) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_pelanggan, $nama, $alamat, $no_telp]);
        header("Location: pelanggan.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "Terjadi kesalahan saat menambah pelanggan. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tambah Pelanggan</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Tambah Pelanggan Baru</h2>
        <form action="tambah_pelanggan.php" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="id_pelanggan" class="block text-sm font-medium text-gray-700">ID Pelanggan</label>
                <input type="text" name="id_pelanggan" id="id_pelanggan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                <input type="text" name="nama" id="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="alamat" id="alamat" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="no_telp" class="block text-sm font-medium text-gray-700">Telepon</label>
                <input type="text" name="no_telp" id="no_telp" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>

        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <div class="bg-red-500 text-white px-4 py-2 rounded mt-4">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>