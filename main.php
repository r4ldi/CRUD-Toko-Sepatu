<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Ambil daftar pengguna dari database
try {
    $stmt = $pdo->query("SELECT username FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Toko Sepatu Terpercaya dengan berbagai pilihan sepatu kualitas terbaik">
    <title>Ralyz - Pilih Sepatumu Sekarang!</title>
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
            <li><a href="pembelian.php" class="hover:text-gray-300">Pemasok</a></li>
            <li><a href="pembelian.php" class="hover:text-gray-300">Pembelian</a></li>
            <li><a href="penjualan.php" class="hover:text-gray-300">Penjualan</a></li>
            <li><a href="pengguna.php" class="hover:text-gray-300">Pengguna</a></li>
            <li><a href="pelanggan.php" class="hover:text-gray-300">Pelanggan</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

    <!-- Hero Section -->
    <section class="bg-cover bg-center h-96" style="background-image: url('images/hero-image.jpg');">
        <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <h1 class="text-5xl text-white font-extrabold text-center">Ekstrakulikuler Merdeka Basketball</h1>
        </div>
    </section>

    <!-- Konten Tambahan -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-semibold">Selamat Datang</h2>
            <p class="mt-4 text-gray-600">Di website Ekstrakulikuler Merdeka Basketball</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 SMK Merdeka - Semua Hak Dilindungi.</p>
        </div>
    </footer>

</body>
</html>