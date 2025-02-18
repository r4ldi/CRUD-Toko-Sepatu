<?php
session_start();
include 'db.php';

if (isset($_GET['no_nota'])) {
    $no_nota = $_GET['no_nota'];

    try {
        $stmt = $pdo->prepare("DELETE FROM pembelian WHERE no_nota = ?");
        $stmt->execute([$no_nota]);
        header("Location: pembelian.php");
        exit;
    } catch (PDOException $e) {
        die("Error deleting purchase: " . $e->getMessage());
    }
} else {
    die("Invalid request!");
}
?>