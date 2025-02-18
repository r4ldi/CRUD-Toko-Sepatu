<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $status = trim($_POST['status']);

    try {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user_count = $stmt->fetchColumn();

        if ($user_count > 0) {
            $error_message = "Username sudah terdaftar. Silakan gunakan username lain.";
        } else {
            // Insert new user into the database
            $stmt = $pdo->prepare("INSERT INTO users (username, password, status) VALUES (?, ?, ?)");
            $stmt->execute([$username, $password, $status]);
            header("Location: pengguna.php");
            exit;
        }
    } catch (PDOException $e) {
        $error_message = "Terjadi kesalahan saat menambah pengguna. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tambah Pengguna</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Tambah Pengguna Baru</h2>
        <form action="tambah_pengguna.php" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <input type="text" name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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