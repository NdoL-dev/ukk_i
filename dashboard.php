<?php
  session_start();

  if (!isset($_SESSION['login'])){
    header ('location: login.php');
    exit;
  }

  include ('database.php');

  $result = mysqli_query ($conn, "SELECT * FROM barang ORDER BY id DESC")

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barang | Inventaris</title>
  <link rel="stylesheet" href="assets/index.css">
</head>
<body>
<div class="dashboard-container">

  <h2>Data Barang Inventaris</h2>

  <div class="dashboard-buttons">
    <a href="add_barang.php" class="btn">Tambah Barang</a>
    <a href="transaksi.php" class="btn">Lihat Transaksi</a>
    <a href="logout.php" class="btn btn-logout">Logout</a>
  </div>
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>Kode</th>
      <th>Nama</th>
      <th>Deskripsi</th>
      <th>Jumlah</th>
      <th>Tersedia</th>
      <th>Lokasi</th>
      <th>Aksi</th>
    </tr>

    <?php while ($data = mysqli_fetch_assoc($result)): ?>

    <tr>
      <td><?= $data['kode'] ?></td>
      <td><?= $data['nama'] ?></td>
      <td><?= $data['deskripsi'] ?></td>
      <td><?= $data['jumlah'] ?></td>
      <td><?= $data['tersedia'] ?></td>
      <td><?= $data['lokasi'] ?></td>
      <td class="action-links">
            <a href="edit_barang.php?id=<?= $data['id'] ?>">Edit</a> |
            <a href="hapus_barang.php?id=<?= $data['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a> |
            <a href="pinjam_barang.php?id=<?= $data['id'] ?>">Pinjam</a> 
            <?php 
              $dipinjam = $data['jumlah'] - $data['tersedia'];
            ?>
            <?php if ($dipinjam > 0): ?>
              | <a href="kembali_barang.php?id=<?= $data['id'] ?>">Kembali</a>
            <?php endif; ?>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
  </div>
</body>
</html>