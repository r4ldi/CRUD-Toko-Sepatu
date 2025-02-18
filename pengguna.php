<?php
session_start();
include 'db.php'; // Include your database connection file

// Fetch all data from the users table
try {
    $stmt = $pdo->query("SELECT username, status FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar Pengguna - Ralyz">
    <title>Pengguna - Ralyz</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Content -->
    <div class="max-w-7xl mx-auto py-12">
        <h2 class="text-3xl font-bold text-center text-gray-900">Daftar Pengguna</h2>
        <div class="mt-10">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($user['status']) ?></td>
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