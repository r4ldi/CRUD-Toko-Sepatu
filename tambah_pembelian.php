<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pemasok = trim($_POST['id_pemasok']);
    $tgl_nota = trim($_POST['tgl_nota']);
    $nama_user = trim($_POST['nama_user']);

    try {
        // Check if the supplier exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM pemasok WHERE id_pemasok = ?");
        $stmt->execute([$id_pemasok]);
        $countPemasok = $stmt->fetchColumn();

        if ($countPemasok == 0) {
            throw new Exception("Supplier not found.");
        }

        // Check if the user exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$nama_user]);
        $countUser = $stmt->fetchColumn();

        if ($countUser == 0) {
            throw new Exception("User not found.");
        }

        $stmt = $pdo->prepare("INSERT INTO pembelian (id_pemasok, tgl_nota, nama_user) VALUES (?, ?, ?)");
        $stmt->execute([$id_pemasok, $tgl_nota, $nama_user]);
        header("Location: pembelian.php");
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    } catch (PDOException $e) {
        $error_message = "Error adding purchase: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tambah Pembelian</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Tambah Pembelian Baru</h2>
        <form action="tambah_pembelian.php" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="id_pemasok" class="block text-sm font-medium text-gray-700">ID Pemasok</label>
                <input type="text" name="id_pemasok" id="id_pemasok" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
