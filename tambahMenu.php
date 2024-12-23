<?php
// Hubungkan ke database
include 'config.php';

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaRestoran = $_POST['namaRestoran'];
    $alamatRestoran = $_POST['alamatRestoran'];
    $namaMakanan = $_POST['namaMakanan'];
    $jumlahKalori = $_POST['jumlahKalori'];
    $deskripsiMakanan = $_POST['deskripsiMakanan'];

    // Proses upload file
    $targetDir = "uploads/";
    $fotoMakanan = $targetDir . basename($_FILES["fotoMakanan"]["name"]);
    move_uploaded_file($_FILES["fotoMakanan"]["tmp_name"], $fotoMakanan);

    // Simpan ke database
    $sql = "INSERT INTO makanan (nama_restoran, alamat_restoran, nama_makanan, jumlah_kalori, foto_makanan, deskripsi_makanan) 
            VALUES ('$namaRestoran', '$alamatRestoran', '$namaMakanan', '$jumlahKalori', '$fotoMakanan', '$deskripsiMakanan')";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil disimpan!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healty Bites</title>
    <link rel="stylesheet" href="css\tambahMenu.css">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>HealthyBites</h1>
            <h3>tambah menu</h3>
        </div>

        <!-- Kembali -->
        <div class="back-button">
            <a href="restoran.php" class="back-link">⮌ kembali</a>
        </div>

        <!-- Pesan -->
        <?php if (!empty($message)): ?>
            <div class="message">
                <p><?= $message; ?></p>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form class="form-container" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="namaRestoran">Nama Restoran</label>
                <input type="text" id="namaRestoran" name="namaRestoran" placeholder="Masukkan nama restoran" required>
            </div>
            <div class="form-group">
                <label for="alamatRestoran">Alamat Restoran</label>
                <input type="text" id="alamatRestoran" name="alamatRestoran" placeholder="Masukkan alamat restoran">
            </div>
            <div class="form-group">
                <label for="namaMakanan">Nama Makanan</label>
                <input type="text" id="namaMakanan" name="namaMakanan" placeholder="Masukkan nama makanan" required>
            </div>
            <div class="form-group">
                <label for="jumlahKalori">Jumlah Kalori</label>
                <input type="number" id="jumlahKalori" name="jumlahKalori" placeholder="Masukkan jumlah kalori">
            </div>
            <div class="form-group foto-makanan">
                <label for="fotoMakanan">Foto Makanan</label>
                <input type="file" id="fotoMakanan" name="fotoMakanan">
            </div>
            <div class="form-group deskripsi">
                <label for="deskripsiMakanan">Deskripsi Makanan</label>
                <textarea id="deskripsiMakanan" name="deskripsiMakanan" rows="5" placeholder="Masukkan deskripsi makanan"></textarea>
            </div>

            <button type="submit" class="submit-button">Tambahkan</button>
        </form>
    </div>

    <div id="notification" class="notification" style="display: none;">
    Data berhasil ditambahkan!
</div>

</body>
</html>
