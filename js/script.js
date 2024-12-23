// Toggle class active untuk menu navbar
const navbarNav = document.querySelector(".navbar-nav");
const hamburgerMenu = document.querySelector("#hamburger-menu");

if (hamburgerMenu) {
  hamburgerMenu.onclick = () => {
    navbarNav.classList.toggle("active");
  };
}

// Referensi elemen modal dan tombol detail
const itemDetailModal = document.querySelector("#item-detail-modal");
const itemDetailButtons = document.querySelectorAll(".item-detail-button");

// Fungsi untuk membuka modal dan menampilkan detail makanan
if (itemDetailButtons.length > 0) {
  itemDetailButtons.forEach((btn) => {
    btn.onclick = (e) => {
      e.preventDefault();

      // Ambil data dari atribut data-*
      const nama = btn.getAttribute("data-nama");
      const restoran = btn.getAttribute("data-restoran");
      const alamat = btn.getAttribute("data-alamat");
      const deskripsi = btn.getAttribute("data-deskripsi");
      const kalori = btn.getAttribute("data-kalori");
      const image = btn.getAttribute("data-image");

      // Update isi modal
      document.querySelector("#modal-nama-makanan").textContent = nama;
      document.querySelector("#modal-nama-restoran").textContent = restoran;
      document.querySelector("#modal-alamat-restoran").textContent = alamat;
      document.querySelector("#modal-deskripsi").textContent = deskripsi;
      document.querySelector("#modal-kalori").textContent = kalori;
      document.querySelector("#modal-image").src = image;
      document.querySelector("#modal-image").alt = nama;

      // Tampilkan modal
      itemDetailModal.style.display = "flex";
    };
  });
}

// Klik tombol close pada modal
const closeIcon = document.querySelector(".modal .close-icon");
if (closeIcon) {
  closeIcon.onclick = (e) => {
    e.preventDefault();
    itemDetailModal.style.display = "none";
  };
}

// Klik di luar modal untuk menutup modal
window.onclick = (e) => {
  if (e.target === itemDetailModal) {
    itemDetailModal.style.display = "none";
  }
};
