<!DOCTYPE html>
<html>
<head>
    <title>Form Responden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <!-- TOMBOL LOGIN ADMIN -->
    <div class="d-flex justify-content-end mb-3">
        <a href="login.php" class="btn btn-outline-primary btn-sm">
            Login Admin
        </a>
    </div>

    <h3>Form Infromasi Pelanggan</h3>

    <!-- FORM RESPONDEN -->
    <form method="post" action="simpan_responden.php">
        <h4> </h4>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Lanjut Isi Kuesioner</button>
    </form>

</div>

</body>
</html>
