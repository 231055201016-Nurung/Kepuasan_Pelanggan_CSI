<?php
include 'koneksi.php';

$id_responden = $_GET['id_responden'];
$atribut = mysqli_query($koneksi,"SELECT * FROM atribut");
?>

<!DOCTYPE html>
<html>
<head>
<title>Input Kuesioner CSI</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h4 class="mb-3">Kuesioner Kepuasan Pelanggan (CSI)</h4>

<p><strong>Petunjuk:</strong><br>
Berikan penilaian pada setiap pernyataan berikut menggunakan skala:
<br>
1 = Sangat Tidak Penting / Sangat Tidak Puas<br>
2 = Tidak Penting / Tidak Puas<br>
3 = Cukup Penting / Cukup Puas<br>
4 = Penting / Puas<br>
5 = Sangat Penting / Sangat Puas
</p>

<form method="post" action="simpan_kuesioner.php">
<input type="hidden" name="id_responden" value="<?= $id_responden ?>">

<!-- A. KEPENTINGAN -->
<h5 class="mt-4">A. Penilaian Tingkat Kepentingan (Importance)</h5>

<table class="table table-bordered">
<tr class="table-secondary">
<th width="5%">No</th>
<th>Atribut Pelayanan</th>
<th width="20%">Nilai (1–5)</th>
</tr>

<?php 
$no=1;
mysqli_data_seek($atribut,0);
while($a=mysqli_fetch_assoc($atribut)){ 
?>
<tr>
<td><?= $no++ ?></td>
<td><?= $a['nama_atribut'] ?></td>
<td>
<select name="kepentingan[<?= $a['id_atribut'] ?>]" class="form-control" required>
<option value="">Pilih</option>
<?php for($i=1;$i<=5;$i++) echo "<option>$i</option>"; ?>
</select>
</td>
</tr>
<?php } ?>
</table>

<!-- B. KEPUASAN -->
<h5 class="mt-4">B. Penilaian Tingkat Kepuasan (Performance)</h5>

<table class="table table-bordered">
<tr class="table-secondary">
<th width="5%">No</th>
<th>Atribut Pelayanan</th>
<th width="20%">Nilai (1–5)</th>
</tr>

<?php 
$no=1;
mysqli_data_seek($atribut,0);
while($a=mysqli_fetch_assoc($atribut)){ 
?>
<tr>
<td><?= $no++ ?></td>
<td><?= $a['nama_atribut'] ?></td>
<td>
<select name="kepuasan[<?= $a['id_atribut'] ?>]" class="form-control" required>
<option value="">Pilih</option>
<?php for($i=1;$i<=5;$i++) echo "<option>$i</option>"; ?>
</select>
</td>
</tr>
<?php } ?>
</table>

<button class="btn btn-primary">Simpan Kuesioner</button>

</form>
</body>
</html>
