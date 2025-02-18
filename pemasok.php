<?php
session_start();
include 'db.php'; // Include your database connection file

// Fetch all data from the pemasok table
try {
    $stmt = $pdo->query("SELECT * FROM pemasok");
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Handle Delete Action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Check if the supplier is referenced in the barang table
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM barang WHERE id_pemasok = ?");
        $stmt->execute([$id]);
        $countBarang = $stmt->fetchColumn();

        // Check if the supplier is referenced in the pembelian table
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM pembelian WHERE id_pemasok = ?");
        $stmt->execute([$id]);
        $countPembelian = $stmt->fetchColumn();

        if ($countBarang > 0 || $countPembelian > 0) {
            throw new Exception("Cannot delete supplier: Supplier is referenced in other tables.");
        }

        $stmt = $pdo->prepare("DELETE FROM pemasok WHERE id_pemasok = ?");
        $stmt->execute([$id]);
        header("Location: pemasok.php"); // Refresh the page after deletion
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    } catch (PDOException $e) {
        $error_message = "Error deleting supplier: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar Pemasok - Ralyz">
    <title>Pemasok - Ralyz</title>
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
        <h2 class="text-3xl font-bold text-center text-gray-900">Daftar Pemasok</h2>
        <a href="tambah_pemasok.php" class="block w-full text-center bg-blue-500 text-white px-4 py-2 rounded mb-4">Tambah Pemasok Baru</a>
        <?php if (isset($error_message)): ?>
            <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <div class="mt-10">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <?php
                        // Dynamically generate table headers based on column names
                        if (!empty($suppliers)) {
                            foreach (array_keys($suppliers[0]) as $column) {
                                echo "<th scope='col' class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>$column</th>";
                            }
                            echo "<th scope='col' class='px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>Aksi</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    // Dynamically generate table rows with data
                    foreach ($suppliers as $supplier) {
                        echo "<tr>";
                        foreach ($supplier as $value) {
                            echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>$value</td>";
                        }
                        echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>
                                <a href='edit_pemasok.php?id={$supplier['id_pemasok']}' class='bg-green-500 text-white px-4 py-2 rounded'>Edit</a>
                                <a href='pemasok.php?action=delete&id={$supplier['id_pemasok']}' class='bg-red-500 text-white px-4 py-2 rounded' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pemasok ini?\")'>Hapus</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
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