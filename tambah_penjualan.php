<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_nota = trim($_POST['no_nota']);
    $id_pelanggan = trim($_POST['id_pelanggan']);
    $tgl_nota = trim($_POST['tgl_nota']);
    $nama_user = trim($_POST['nama_user']);

    try {
        $stmt = $pdo->prepare("INSERT INTO penjualan (no_nota, id_pelanggan, tgl_nota, nama_user) VALUES (?, ?, ?, ?)");
        $stmt->execute([$no_nota, $id_pelanggan, $tgl_nota, $nama_user]);
        header("Location: penjualan.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "Terjadi kesalahan saat menambah penjualan. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tambah Penjualan</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Tambah Penjualan Baru</h2>
        <form action="tambah_penjualan.php" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="no_nota" class="block text-sm font-medium text-gray-700">No Nota</label>
                <input type="text" name="no_nota" id="no_nota" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="id_pelanggan" class="block text-sm font-medium text-gray-700">ID Pelanggan</label>
                <input type="text" name="id_pelanggan" id="id_pelanggan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="tgl_nota" class="block text-sm font-medium text-gray-700">Tanggal Nota</label>
                <input type="date" name="tgl_nota" id="tgl_nota" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="nama_user" class="block text-sm font-medium text-gray-700">Nama User</label>
                <input type="text" name="nama_user" id="nama_user" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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