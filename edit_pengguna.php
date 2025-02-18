<?php
session_start();
include 'db.php';

if (isset($_GET['id_user'])) {
    $id_user = (int)$_GET['id_user'];

    try {
        $stmt = $pdo->prepare("SELECT id_user, username, status FROM users WHERE id_user = ?");
        $stmt->execute([$id_user]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("User not found!");
        }
    } catch (PDOException $e) {
        die("Error fetching user data: " . $e->getMessage());
    }
} else {
    die("Invalid request!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $status = trim($_POST['status']);

    try {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, status = ? WHERE id_user = ?");
        $stmt->execute([$username, $status, $id_user]);
        header("Location: pengguna.php");
        exit;
    } catch (PDOException $e) {
        $error_message = "Error updating user: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Pengguna</title>
</head>
<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="text-center text-2xl font-bold">Edit Pengguna</h2>
        <form action="edit_pengguna.php?id_user=<?= $id_user ?>" method="POST" class="mt-6 space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <input type="text" name="status" id="status" value="<?= htmlspecialchars($user['status']) ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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