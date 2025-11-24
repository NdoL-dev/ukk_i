<?php
  session_start();
  if (!isset($_SESSION['login'])) {
      header("Location: login.php");
      exit;
  }

  include("database.php");

  $id = $_GET['id'];

  $data = mysqli_query($conn, "SELECT * FROM barang WHERE id=$id");
  $barang = mysqli_fetch_assoc($data);

  if (isset($_POST['update'])) {

    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $jumlah = $_POST['jumlah'];
    $lokasi = $_POST['lokasi'];
    $kode = $_POST['kode'];

    $tersedia = $jumlah;

    mysqli_query($conn, "UPDATE barang SET
    
        nama='$nama',
        deskripsi='$deskripsi',
        jumlah='$jumlah',
        tersedia='$tersedia',
        lokasi='$lokasi',
        kode='$kode'
        WHERE id=$id
    ");

    echo "<script>alert('Barang berhasil diperbarui!'); window.location='dashboard.php';</script>";

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pinjam Barang | Inventaris</title>
  <link rel="stylesheet" href="assets/barang.css">
</head>
<body>
  <div class="container">
    <h2>Edit Barang</h2>

    <form method="post">
    
      <label for="nama">Nama Barang:</label><br>
      <input type="text" name="nama" id="nama" value="<?= $barang['nama'] ?>" required><br><br>

      <label for="kode">Kode Barang:</label><br>
      <input type="text" name="kode" id="kode" value="<?= $barang['kode'] ?>" required><br><br>

      <label for="deskripsi">Deskripsi:</label><br>
      <textarea name="deskripsi" id="deskripsi" required><?= $barang['deskripsi'] ?></textarea><br><br>

      <label for="jumlah">Jumlah:</label><br>
      <input type="number" name="jumlah" id="jumlah" value="<?= $barang['jumlah'] ?>" required><br><br>

      <label for="lokasi">Lokasi:</label><br>
      <input type="text" name="lokasi" id="lokasi" value="<?= $barang['lokasi'] ?>" required><br><br>

      <button type="submit" name="update">Update</button>
      <a href="dashboard.php">Kembali</a>
      
  </form>
  </div>
</body>
</html>