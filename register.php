<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (strlen($password) < 8) {
        echo "<script>alert('Password harus minimal 8 karakter!'); window.location.href='register.php';</script>";
        exit();
    }

    $checkQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username atau Email sudah digunakan!'); window.location.href='register.php';</script>";
        exit();
    }

    $insertQuery = "INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $fullname, $username, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal, coba lagi!'); window.location.href='index.php';</script>";
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
    <title>Register</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="register.css">
</head>
<body>
<section>
    <div class="form-box">
        <div class="form-value">
            <h2>Register</h2>
            <form action="register.php" method="POST">
                <div class="inputbox">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" name="fullname" required>
                    <label>Masukan Nama Lengkap</label>
                </div>
                
                <div class="inputbox">
                    <ion-icon name="at-outline"></ion-icon>
                    <input type="text" name="username" required>
                    <label>Masukan Username</label>
                </div>
                
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="email" required>
                    <label>Masukan Email</label>
                </div>

                <div class="inputbox">
                    <input type="password" name="password" id="registerPassword" required>
                    <label>Masukan Password</label>
                    <ion-icon name="eye-outline" class="toggle-password" onclick="togglePassword('registerPassword', this)"></ion-icon>
                </div>

                <button type="submit">Register</button>

                <div class="register">
                    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
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
