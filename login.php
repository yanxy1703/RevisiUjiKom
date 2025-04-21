<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if ($password === $user['password']) { 
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "<script>alert('Login berhasil!'); window.location.href='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.location.href='login.php';</script>";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<section>
    <div class="form-box">
        <div class="form-value">
            <h2>Login</h2>

            <form action="login.php" method="POST">
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="email" required>
                    <label>Masukkan Email</label>
                </div>

                <div class="inputbox">
                    <input type="password" name="password" id="passwordInput" required>
                    <label>Masukkan Password</label>
                    <ion-icon class="toggle-password" name="eye-outline" onclick="togglePassword('passwordInput', this)"></ion-icon>
                </div>

                <button type="submit">Login</button>

                <div class="register">
                    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === "password";
    input.type = isPassword ? "text" : "password";
    icon.setAttribute("name", isPassword ? "eye-off-outline" : "eye-outline");
}
</script>
</body>
</html>
