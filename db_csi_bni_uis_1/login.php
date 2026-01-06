<?php
session_start();
include 'koneksi.php';

// Proses login admin
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $q = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($q) > 0) {
        $_SESSION['role'] = 'admin';
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width:400px;">

    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title mb-3 text-center">Login Admin</h4>

            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <!-- FORM LOGIN -->
            <form method="post">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>

            <hr>

            <!-- TOMBOL KE HALAMAN RESPONDEN -->
            <div class="d-grid">
                <a href="responden.php" class="btn btn-outline-success mt-2">Isi Survei Pelanggan </a>
            </div>
        </div>
    </div>

</div>

</body>
</html>
