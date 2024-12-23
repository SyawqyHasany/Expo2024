<?php
// Hubungkan ke database
include 'config.php';

// Proses hapus data jika tombol hapus diklik
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Sanitasi input

    // Ambil nama file dari database sebelum menghapus data
    $sql = "SELECT foto_makanan FROM makanan WHERE id = $delete_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['foto_makanan']; // Ambil path file

        // Hapus file jika ada di direktori uploads
        if (file_exists($file_path)) {
            unlink($file_path); // Hapus file dari server
        }

        // Setelah file terhapus, hapus data dari database
        $sql = "DELETE FROM makanan WHERE id = $delete_id";
        if ($conn->query($sql) === TRUE) {
            // Redirect untuk merefresh halaman setelah data dihapus
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error menghapus data: " . $conn->error;
        }
    } else {
        echo "Data tidak ditemukan.";
    }
}


// Ambil data dari tabel makanan
$sql = "SELECT * FROM makanan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Healthy Bites</title>
    <link rel="stylesheet" href="css/restoran.css">

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
            <h2>Dashboard</h2>
        </div>

        <!-- Dashboard -->
        <div>
            <a href="tambahMenu.php" class="add-button">Tambah Menu</a>
        </div>

        <!-- Tabel Data -->
        <div class="data-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="data-item">
                        <div class="data-left">
                            <div class="form-group">
                                <label>Nama Restoran</label>
                                <input type="text" value="<?= htmlspecialchars($row['nama_restoran']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat Restoran</label>
                                <input type="text" value="<?= htmlspecialchars($row['alamat_restoran']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Makanan</label>
                                <input type="text" value="<?= htmlspecialchars($row['nama_makanan']); ?>" readonly>
                            </div>
                        </div>
                        <div class="data-right">
                            <div class="form-group">
                                <label>Deskripsi Makanan</label>
                                <textarea readonly><?= htmlspecialchars($row['deskripsi_makanan']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Kalori</label>
                                <input type="text" value="<?= htmlspecialchars($row['jumlah_kalori']); ?> kal" readonly>
                            </div>
                            <div class="form-group foto-makanan">
                                <label>Foto Makanan</label>
                                <img src="<?= htmlspecialchars($row['foto_makanan']); ?>" alt="Foto Makanan" class="foto-makanan-img">
                            </div>
                            <div class="form-group">
                                <a href="editMenu.php?id=<?= $row['id']; ?>" class="edit-button">Edit</a>
                                <a href="?delete_id=<?= $row['id']; ?>" class="delete-button" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="empty-message">Tidak ada data makanan yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
