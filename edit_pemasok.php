<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM pemasok WHERE id_pemasok = ?");
        $stmt->execute([$id]);
        $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$supplier) {
            die("Supplier not found!");
        }
    } catch (PDOException $e) {
        die("Error fetching supplier data: " . $e->getMessage());
    }
} else {
    die("Invalid request!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $no_telp = trim($_POST['no_telp']);

    try {
        $stmt = $pdo->prepare("UPDATE pemasok SET nama = ?, alamat = ?, no_telp = ? WHERE id_pemasok = ?");
        $stmt->execute([$nama, $alamat, $no_telp, $id]);
        header("Location: pemasok.php");
        exit;
    } catch (PDOException $e) {
        die("Error updating supplier: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Pemasok</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Edit Pemasok</h2>
        <form action="edit_pemasok.php?id=<?= $id ?>" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($supplier['nama']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="alamat" id="alamat" value="<?= htmlspecialchars($supplier['alamat']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="no_telp" class="block text-sm font-medium text-gray-700">No Telepon</label>
                <input type="text" name="no_telp" id="no_telp" value="<?= htmlspecialchars($supplier['no_telp']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</body>
</html>