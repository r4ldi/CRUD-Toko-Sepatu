<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the id is set in the URL
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Fetch the product data based on the id
    try {
        $stmt = $pdo->prepare("SELECT * FROM barang WHERE id_sepatu = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            die("Product not found!");
        }
    } catch (PDOException $e) {
        die("Error fetching product data: " . $e->getMessage());
    }
} else {
    die("Invalid request!");
}

// Handle form submission for updating the product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $merk_sepatu = trim($_POST['merk_sepatu']);
    $jenis_sepatu = trim($_POST['jenis_sepatu']);
    $no_sepatu = (int)$_POST['no_sepatu'];
    $stok = (int)$_POST['stok'];
    $id_pemasok = (int)$_POST['id_pemasok'];

    try {
        $stmt = $pdo->prepare("UPDATE barang SET merk_sepatu = ?, jenis_sepatu = ?, no_sepatu = ?, stok = ?, id_pemasok = ? WHERE id_sepatu = ?");
        $stmt->execute([$merk_sepatu, $jenis_sepatu, $no_sepatu, $stok, $id_pemasok, $id]);
        header("Location: barang.php");
        exit;
    } catch (PDOException $e) {
        die("Error updating product: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Produk</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Edit Produk</h2>
        <form action="edit_barang.php?id=<?= $id ?>" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="merk_sepatu" class="block text-sm font-medium text-gray-700">Merk Sepatu</label>
                <input type="text" name="merk_sepatu" id="merk_sepatu" value="<?= htmlspecialchars($product['merk_sepatu']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="jenis_sepatu" class="block text-sm font-medium text-gray-700">Jenis Sepatu</label>
                <input type="text" name="jenis_sepatu" id="jenis_sepatu" value="<?= htmlspecialchars($product['jenis_sepatu']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="no_sepatu" class="block text-sm font-medium text-gray-700">No Sepatu</label>
                <input type="number" name="no_sepatu" id="no_sepatu" value="<?= htmlspecialchars($product['no_sepatu']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stok" id="stok" value="<?= htmlspecialchars($product['stok']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="id_pemasok" class="block text-sm font-medium text-gray-700">ID Pemasok</label>
                <input type="number" name="id_pemasok" id="id_pemasok" value="<?= htmlspecialchars($product['id_pemasok']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</body>
</html>