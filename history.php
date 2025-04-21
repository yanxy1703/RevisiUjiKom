<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM history WHERE user_id = $user_id ORDER BY completed_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="history.css"> 
    <title>Histori Tugas</title>
</head>
<body>
    <div class="container">
        <h2>ðŸ“œ Histori Tugas</h2>
        <a href="index.php" class="logout-btn">â¬… Kembali</a>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Tugas</th>
                        <th>Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['task_name']) ?: '&nbsp;' ?></td>
                            <td><?= $row['completed_at'] ?: '&nbsp;' ?></td>
                            <td>  </td>
                            
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>