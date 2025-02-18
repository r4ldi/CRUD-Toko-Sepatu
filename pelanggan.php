<?php
session_start();
include 'db.php'; // Include your database connection file

// Handle Delete Customer
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_pelanggan'])) {
    $id_pelanggan = $_GET['id_pelanggan'];

    try {
        $stmt = $pdo->prepare("DELETE FROM pelanggan WHERE id_pelanggan = ?");
        $stmt->execute([$id_pelanggan]);
        header("Location: pelanggan.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "Terjadi kesalahan saat menghapus pelanggan. Silakan coba lagi.";
    }
}

// Fetch all data from the pelanggan table
try {
    $stmt = $pdo->query("SELECT id_pelanggan, nama, alamat, no_telp FROM pelanggan");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar Pelanggan - Ralyz">
    <title>Pelanggan - Ralyz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-rose-600 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="main.php" class="flex items-center space-x-2">
                <span class="text-white text-2xl font-bold font-serif">Ralyz</span>
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

    <!-- Content -->
    <div class="max-w-7xl mx-auto py-12">
        <h2 class="text-3xl font-bold text-center text-gray-900">Daftar Pelanggan</h2>

        <!-- Add Customer Button -->
        <div class="mt-10">
            <a href="tambah_pelanggan.php" class="block w-full text-center bg-blue-500 text-white px-4 py-2 rounded mb-4">Tambah Pelanggan Baru</a>
        </div>

        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <div class="bg-red-500 text-white px-4 py-2 rounded mt-4">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Customers Table -->
        <div class="mt-10">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pelanggan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pelanggan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($customer['id_pelanggan']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($customer['nama']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($customer['alamat']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($customer['no_telp']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <a href="edit_pelanggan.php?id_pelanggan=<?= $customer['id_pelanggan'] ?>" class="bg-green-500 text-white px-4 py-2 rounded">Edit</a>
                                <a href="pelanggan.php?action=delete&id_pelanggan=<?= $customer['id_pelanggan'] ?>" class="bg-red-500 text-white px-4 py-2 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 Ralyz - Semua Hak Dilindungi.</p>
        </div>
    </footer>

</body>
</html>