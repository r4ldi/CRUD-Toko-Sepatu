<?php
session_start();
include 'db.php';

if (isset($_GET['id_pelanggan'])) {
    $id_pelanggan = $_GET['id_pelanggan'];

    try {
        $stmt = $pdo->prepare("SELECT id_pelanggan, nama, alamat, no_telp FROM pelanggan WHERE id_pelanggan = ?");
        $stmt->execute([$id_pelanggan]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            die("Customer not found!");
        }
    } catch (PDOException $e) {
        die("Error fetching customer data: " . $e->getMessage());
    }
} else {
    die("Invalid request!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $no_telp = trim($_POST['no_telp']);

    try {
        $stmt = $pdo->prepare("UPDATE pelanggan SET nama = ?, alamat = ?, no_telp = ? WHERE id_pelanggan = ?");
        $stmt->execute([$nama, $alamat, $no_telp, $id_pelanggan]);
        header("Location: pelanggan.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "Error updating customer: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Pelanggan</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Edit Pelanggan</h2>
        <form action="edit_pelanggan.php?id_pelanggan=<?= $id_pelanggan ?>" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
                <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($customer['nama']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="alamat" id="alamat" value="<?= htmlspecialchars($customer['alamat']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="no_telp" class="block text-sm font-medium text-gray-700">Telepon</label>
                <input type="text" name="no_telp" id="no_telp" value="<?= htmlspecialchars($customer['no_telp']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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