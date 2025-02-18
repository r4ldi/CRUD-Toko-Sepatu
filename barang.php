<?php
session_start();
include 'db.php'; // Include your database connection file

// Fetch all data from the barang table
try {
    $stmt = $pdo->query("SELECT id_sepatu, merk_sepatu, jenis_sepatu, no_sepatu, stok, id_pemasok FROM barang");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Handle Delete Action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM barang WHERE id_sepatu = ?");
        $stmt->execute([$id]);
        header("Location: barang.php"); // Refresh the page after deletion
        exit;
    } catch (PDOException $e) {
        die("Error deleting product: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Produk - Ralyz</title>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-rose-600 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="main.php" class="flex items-center space-x-2">
                <span class="text-white text-2xl font-bold font-serif">Merdeka Basketball</span>
            </a>
            <ul class="flex space-x-6 text-white">
                <li><a href="main.php" class="hover:text-gray-300">Home</a></li>
                <li><a href="barang.php" class="hover:text-gray-300">Barang</a></li>
                <li><a href="pemasok.php" class="hover:text-gray-300">Pemasok</a></li>
                <li><a href="pembelian.php" class="hover:text-gray-300">Pembelian</a></li>
                <li><a href="penjualan.php" class="hover:text-gray-300">Penjualan</a></li>
                <li><a href="pengguna.php" class="hover:text-gray-300">Pengguna</a></li>
                <li><a href="pelanggan.php" class="hover:text-gray-300">Pelanggan</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-12">
        <div class="text-center">
            
            <h2 class="mt-10 text-2xl font-bold tracking-tight text-gray-900">Produk Sepatu Terbaru</h2>
        </div>
        <div class="mt-10">
            <!-- Add Button -->
            <a href="tambah_barang.php" class="block w-full text-center bg-blue-500 text-white px-4 py-2 rounded mb-4">Tambah Produk Baru</a>

            <!-- Regular Products Section -->
            <h3 class="text-lg font-bold text-gray-900 mt-10">Produk Sepatu Terbaru</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                <?php foreach ($products as $product): ?>
                    <div class="border rounded-lg p-4 shadow-md bg-white">
                        <h3 class="text-lg font-bold"><?= htmlspecialchars($product['merk_sepatu']) ?></h3>
                        <p><?= htmlspecialchars($product['jenis_sepatu']) ?></p>
                        <p>No Sepatu: <?= htmlspecialchars($product['no_sepatu']) ?></p>
                        <p>Stok: <?= htmlspecialchars($product['stok']) ?></p>
                        <div class="flex justify-between mt-4">
                            <a href="edit_barang.php?id=<?= $product['id_sepatu'] ?>" class="bg-green-500 text-white px-4 py-2 rounded">Edit</a>
                            <a href="barang.php?action=delete&id=<?= $product['id_sepatu'] ?>" class="bg-red-500 text-white px-4 py-2 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 SMK Merdeka - Semua Hak Dilindungi.</p>
        </div>
    </footer>

</body>
</html>