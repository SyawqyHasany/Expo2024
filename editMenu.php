<?php
// Hubungkan ke database
include 'config.php';

// Periksa apakah ada ID yang dikirim melalui parameter URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = intval($_GET['id']); // Sanitasi input ID

// Ambil data berdasarkan ID
$sql = "SELECT * FROM makanan WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    die("Data tidak ditemukan.");
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaRestoran = $_POST['namaRestoran'];
    $alamatRestoran = $_POST['alamatRestoran'];
    $namaMakanan = $_POST['namaMakanan'];
    $jumlahKalori = $_POST['jumlahKalori'];
    $deskripsiMakanan = $_POST['deskripsiMakanan'];
    $fotoMakananLama = $data['foto_makanan'];

    // Proses upload file baru jika ada
    if (!empty($_FILES["fotoMakanan"]["name"])) {
        $targetDir = "uploads/";
        $fotoMakananBaru = $targetDir . basename($_FILES["fotoMakanan"]["name"]);
        move_uploaded_file($_FILES["fotoMakanan"]["tmp_name"], $fotoMakananBaru);

        // Hapus file lama jika ada
        if (file_exists($fotoMakananLama)) {
            unlink($fotoMakananLama);
        }
    } else {
        $fotoMakananBaru = $fotoMakananLama; // Jika tidak ada file baru, gunakan file lama
    }

    // Update data di database
    $sql = "UPDATE makanan SET 
                nama_restoran = '$namaRestoran', 
                alamat_restoran = '$alamatRestoran', 
                nama_makanan = '$namaMakanan', 
                jumlah_kalori = '$jumlahKalori', 
                deskripsi_makanan = '$deskripsiMakanan', 
                foto_makanan = '$fotoMakananBaru'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect ke halaman utama setelah edit berhasil
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data - Healty Bites</title>
    <link rel="stylesheet" href="css/edit.css">
    
</head>
<body>
    <div class="container">
        <h1>Edit Data Makanan</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="namaRestoran">Nama Restoran</label>
                <input type="text" id="namaRestoran" name="namaRestoran" value="<?= htmlspecialchars($data['nama_restoran']); ?>" required>
            </div>
            <div class="form-group">
                <label for="alamatRestoran">Alamat Restoran</label>
                <input type="text" id="alamatRestoran" name="alamatRestoran" value="<?= htmlspecialchars($data['alamat_restoran']); ?>">
            </div>
            <div class="form-group">
                <label for="namaMakanan">Nama Makanan</label>
                <input type="text" id="namaMakanan" name="namaMakanan" value="<?= htmlspecialchars($data['nama_makanan']); ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlahKalori">Jumlah Kalori</label>
                <input type="number" id="jumlahKalori" name="jumlahKalori" value="<?= htmlspecialchars($data['jumlah_kalori']); ?>">
            </div>
            <div class="form-group">
                <label for="deskripsiMakanan">Deskripsi Makanan</label>
                <textarea id="deskripsiMakanan" name="deskripsiMakanan" rows="5"><?= htmlspecialchars($data['deskripsi_makanan']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="fotoMakanan">Foto Makanan</label>
                <input type="file" id="fotoMakanan" name="fotoMakanan">
                <p>Foto Saat Ini:</p>
                <img src="<?= htmlspecialchars($data['foto_makanan']); ?>" alt="Foto Makanan" style="max-width: 100px; border-radius: 5px;">
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-button">Simpan</button>
                <a href="restoran.php" class="cancel-button">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
