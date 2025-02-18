<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $no_telp = trim($_POST['no_telp']);

    try {
        $stmt = $pdo->prepare("INSERT INTO pemasok (nama, alamat, no_telp) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $alamat, $no_telp]);
        header("Location: pemasok.php");
        exit;
    } catch (PDOException $e) {
        die("Error adding supplier: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tambah Pemasok</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Tambah Pemasok Baru</h2>
        <form action="tambah_pemasok.php" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="alamat" id="alamat" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="no_telp" class="block text-sm font-medium text-gray-700">No Telepon</label>
                <input type="text" name="no_telp" id="no_telp" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</body>
</html>
