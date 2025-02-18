<?php
session_start();
include 'db.php'; // Include your database connection file

// Fetch all data from the penjualan table
try {
    $stmt = $pdo->query("SELECT no_nota, id_pelanggan, tgl_nota, nama_user FROM penjualan");
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Penjualan - Ralyz</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-4xl">
            <img class="mx-auto" src="merdek.png?color=indigo&shade=600" alt="Your Company" style="height: 100px; width: 100px;">
            <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-gray-900">Daftar Penjualan</h2>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-4xl">
            <!-- Navigation Bar -->
            <nav class="flex justify-center space-x-4 mb-6">
                <a href="#" class="text-indigo-600 hover:text-indigo-500">Home</a>
                <a href="barang.php" class="text-indigo-600 hover:text-indigo-500">Barang</a>
                <a href="pemasok.php" class="text-indigo-600 hover:text-indigo-500">Pemasok</a>
                <a href="pembelian.php" class="text-indigo-600 hover:text-indigo-500">Pembelian</a>
                <a href="penjualan.php" class="text-indigo-600 hover:text-indigo-500">Penjualan</a>
                <a href="pengguna.php" class="text-indigo-600 hover:text-indigo-500">Pengguna</a>
                <a href="pelanggan.php" class="text-indigo-600 hover:text-indigo-500">Pelanggan</a>
                <a href="logout.php" class="text-indigo-600 hover:text-indigo-500">Logout</a>
            </nav>

            <!-- Sales Table -->
            <h3 class="text-lg font-bold text-gray-900 mt-10">Daftar Penjualan</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Nota</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pelanggan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Nota</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama User</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($sale['no_nota']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($sale['id_pelanggan'] ?? '-') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($sale['tgl_nota'] ?? '-') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($sale['nama_user'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Footer -->
            <footer class="mt-10 text-center text-gray-500">
                © 2024 Ralyz - Semua Hak Dilindungi.
            </footer>
        </div>
    </div>
</body>
</html>