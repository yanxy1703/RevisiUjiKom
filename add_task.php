<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi ini mendefinisikan variabel $con

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Tampilkan error PHP jika ada
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Pastikan request berasal dari metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = htmlspecialchars($_POST['task_name']);
    $deadline = $_POST['deadline'];
    $priority = $_POST['priority'];
    $user_id = $_SESSION['user_id'];

    // Validasi data
    if (empty($task_name) || empty($deadline) || empty($priority)) {
        die("Error: Data tidak lengkap.");
    }

    // Gunakan koneksi dari $con (bukan $conn)
    $stmt = $conn->prepare("INSERT INTO tasks (task_name, deadline, priority, user_id) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Error SQL: " . $con->error);
    }

    $stmt->bind_param("sssi", $task_name, $deadline, $priority, $user_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Tugas berhasil ditambahkan!');
                window.location.href = 'index.php';
              </script>";
    } else {
        die("Gagal menambahkan tugas: " . $stmt->error);
    }

    $stmt->close();
    $con->close();
}
?>
