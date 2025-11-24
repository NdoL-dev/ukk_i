<?php
  session_start();
  if (!isset($_SESSION['login'])) {
      header("Location: login.php");
      exit;
  }

  include("database.php");

  $id = $_GET['id'];

  $data = mysqli_query ($conn, "SELECT * FROM barang WHERE id=$id");
  $barang = mysqli_fetch_assoc ($data);

  if (!$barang) die("Barang tidak ditemukan");

  $dipinjam = $barang['jumlah'] - $barang['tersedia'];
  $error = "";

  if (isset($_POST['submit'])) {
    $peminjam = $_POST['peminjam'];
    $jumlah = $_POST['jumlah'];
    $catatan = $_POST['catatan'];

    if ($peminjam === "" || $jumlah <= 0) {
      $error = "Isi nama pengembali & jumlah yang benar";
    }
    elseif ($dipinjam <= 0){
      $error = "Tidak ada barang yang sedang dipinjam";
    }
    elseif ($jumlah > $dipinjam) {
      $error = "jumlah pengembalian melebihi barang yang dipinjam";
    }
    else {
      mysqli_query ($conn, "INSERT INTO transaksi (barang_id, peminjam, jenis, jumlah, catatan)
      VALUES ($id, '$peminjam', 'kembali', $jumlah, '$catatan')"
      );

      mysqli_query($conn, "UPDATE barang SET tersedia = LEAST(jumlah, tersedia + $jumlah) WHERE id = $id"
      );

      echo "<script>alert('Barang berhasil dikembalikan'); window.location='dashboard.php';</script>";

    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kembali Barang | Inventaris</title>
  <link rel="stylesheet" href="assets/barang.css">
</head>
<body>
  <div class="container">
    <h2>Kembalikan Barang: <?= $barang['nama'] ?></h2>
    <p><b>Stok yang dipinjam saat ini: <?= $dipinjam ?></b></p>

    <form action="" method="POST">
      
      <label for="peminjam">Nama Pengembali:</label><br>
      <input type="text" name="peminjam" id="peminjam" required><br><br>

      <label for="jumlah">Jumlah yang Dikembalikan:</label><br>
      <input type="number" name="jumlah" value="1" min="1" max="<?= $dipinjam ?>" required><br><br>

      <label for="catatan">Catatan:</label><br>
      <textarea name="catatan" id="catatan" required></textarea><br><br>

      <button type="submit" name="submit">Kembalikan</button>
      <a href="dashboard.php">Kembali</a>

    </form>
  </div>
</body>
</html>