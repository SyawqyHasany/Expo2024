<?php
// Hubungkan ke database
include 'config.php';

// Ambil data dari tabel makanan
$sql = "SELECT * FROM makanan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Healthy Bites</title>

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />

    <!-- icon -->
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="css/index.css">
  </head>
  <body>
    <!-- Navbar start -->
    <nav class="navbar">
      <a href="#" class="navbar-logo">Healthy<span>Bites</span></a>

      <div class="navbar-nav">
        <a href="#home">Home</a>
        <a href="#about">About Us</a>
        <a href="#recommendation">Healthy Food</a>
      </div>

      <div class="navbar-extra">
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
    </nav>
    <!-- Navbar end -->

    <section class="hero" id="home">
      <main class="content">
        <h1>Healthy Food Healthy Life</h1>
        <a href="#recommendation" class="cta">Lihat Rekomendasi</a>
      </main>
    </section>

    <section id="about" class="about">
      <h2>About Us</h2>
      <div class="row">
        <div class="about-img">
          <img src="img/about-us.jpg" alt="About Us" />
        </div>
        <div class="content">
          <h3>Kenapa Makanan Sehat?</h3>
          <p>
          Karena kami percaya bahwa makanan sehat bukan hanya tentang menjaga berat badan, tetapi juga tentang menjaga kebahagiaan, energi, dan kesehatan Anda. Healthy Bites adalah mitra terbaik Anda dalam menjalani gaya hidup yang lebih sehat dan lebih bahagia!
          </p>
        </div>
      </div>
    </section>

    <section class="recommendation" id="recommendation">
      <h2>Healthy Food</h2>
      <p>
        Temukan makanan sehat terbaik yang direkomendasikan untuk Anda.
      </p>

      <div class="row">
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <div class="recommendation-card">
              <div class="recommendation-icons">
                <a href="#" class="item-detail-button" 
                   data-nama="<?= htmlspecialchars($row['nama_makanan']); ?>" 
                   data-restoran="<?= htmlspecialchars($row['nama_restoran']); ?>" 
                   data-alamat="<?= htmlspecialchars($row['alamat_restoran']); ?>" 
                   data-deskripsi="<?= htmlspecialchars($row['deskripsi_makanan']); ?>" 
                   data-kalori="<?= htmlspecialchars($row['jumlah_kalori']); ?>" 
                   data-image="<?= htmlspecialchars($row['foto_makanan']); ?>">
                  <i data-feather="eye"></i>
                </a>
              </div>
              <div class="recommendation-image">
                <img src="<?= htmlspecialchars($row['foto_makanan']); ?>" alt="<?= htmlspecialchars($row['nama_makanan']); ?>" />
              </div>
              <div class="recommendation-content">
                <h3><?= htmlspecialchars($row['nama_makanan']); ?></h3>
                <p><strong>Restoran:</strong> <?= htmlspecialchars($row['nama_restoran']); ?></p>
                <p><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat_restoran']); ?></p>
                <div class="recommendation-price">
                  <strong>Kalori:</strong> <?= htmlspecialchars($row['jumlah_kalori']); ?> kal
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>Belum ada data makanan yang diunggah.</p>
        <?php endif; ?>
      </div>
    </section>

    <div class="modal" id="item-detail-modal">
      <div class="modal-container">
        <a href="#" class="close-icon"><i data-feather="x"></i></a>
        <div class="modal-content">
          <img src="" alt="" id="modal-image" />
          <div class="product-content">
            <h3 id="modal-nama-makanan"></h3>
            <p><strong>Restoran:</strong> <span id="modal-nama-restoran"></span></p>
            <p><strong>Alamat:</strong> <span id="modal-alamat-restoran"></span></p>
            <p><strong>Deskripsi:</strong> <span id="modal-deskripsi"></span></p>
            <p><strong>Jumlah Kalori:</strong> <span id="modal-kalori"></span> kal</p>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <div class="links">
        <a href="#home">Home</a>
        <a href="#about">About Us</a>
        <a href="#recommendation">Healthy Food</a>
      </div>

      <div class="credit">
        <p>Created by Manutz &copy; 2024.</p>
      </div>
    </footer>

    <!-- icon -->
    <script>
      feather.replace();

      document.addEventListener("DOMContentLoaded", function () {
        const detailButtons = document.querySelectorAll(".item-detail-button");
        const modal = document.getElementById("item-detail-modal");
        const modalImage = document.getElementById("modal-image");
        const modalNamaMakanan = document.getElementById("modal-nama-makanan");
        const modalNamaRestoran = document.getElementById("modal-nama-restoran");
        const modalAlamatRestoran = document.getElementById("modal-alamat-restoran");
        const modalDeskripsi = document.getElementById("modal-deskripsi");
        const modalKalori = document.getElementById("modal-kalori");
        const closeIcon = modal.querySelector(".close-icon");

        detailButtons.forEach(button => {
          button.addEventListener("click", function (e) {
            e.preventDefault();

            // Ambil data dari atribut data-*
            const nama = this.getAttribute("data-nama");
            const restoran = this.getAttribute("data-restoran");
            const alamat = this.getAttribute("data-alamat");
            const deskripsi = this.getAttribute("data-deskripsi");
            const kalori = this.getAttribute("data-kalori");
            const image = this.getAttribute("data-image");

            // Isi modal dengan data
            modalImage.src = image;
            modalImage.alt = nama;
            modalNamaMakanan.textContent = nama;
            modalNamaRestoran.textContent = restoran;
            modalAlamatRestoran.textContent = alamat;
            modalDeskripsi.textContent = deskripsi;
            modalKalori.textContent = kalori;

            // Tampilkan modal
            modal.classList.add("open");
          });
        });

        // Tutup modal
        closeIcon.addEventListener("click", function (e) {
          e.preventDefault();
          modal.classList.remove("open");
        });
      });
    </script>

    <!-- javascript -->
    <script src="js/script.js"></script>
  </body>
</html>
