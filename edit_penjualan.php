<?php
session_start();
include 'db.php';

if (isset($_GET['no_nota'])) {
    $no_nota = $_GET['no_nota'];

    try {
        $stmt = $pdo->prepare("SELECT no_nota, id_pelanggan, tgl_nota, nama_user FROM penjualan WHERE no_nota = ?");
        $stmt->execute([$no_nota]);
        $sale = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sale) {
            die("Sale not found!");
        }
    } catch (PDOException $e) {
        die("Error fetching sale data: " . $e->getMessage());
    }
} else {
    die("Invalid request!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = trim($_POST['id_pelanggan']);
    $tgl_nota = trim($_POST['tgl_nota']);
    $nama_user = trim($_POST['nama_user']);

    try {
        $stmt = $pdo->prepare("UPDATE penjualan SET id_pelanggan = ?, tgl_nota = ?, nama_user = ? WHERE no_nota = ?");
        $stmt->execute([$id_pelanggan, $tgl_nota, $nama_user, $no_nota]);
        header("Location: penjualan.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "Error updating sale: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Penjualan</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Edit Penjualan</h2>
        <form action="edit_penjualan.php?no_nota=<?= $no_nota ?>" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="id_pelanggan" class="block text-sm font-medium text-gray-700">ID Pelanggan</label>
                <input type="text" name="id_pelanggan" id="id_pelanggan" value="<?= htmlspecialchars($sale['id_pelanggan']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="tgl_nota" class="block text-sm font-medium text-gray-700">Tanggal Nota</label>
                <input type="date" name="tgl_nota" id="tgl_nota" value="<?= htmlspecialchars($sale['tgl_nota']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="nama_user" class="block text-sm font-medium text-gray-700">Nama User</label>
                <input type="text" name="nama_user" id="nama_user" value="<?= htmlspecialchars($sale['nama_user']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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