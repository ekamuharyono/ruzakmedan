<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu | Rujak Medan</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="./scripts/script.js"></script>

    <script>
      // Fungsi untuk menambahkan barang ke keranjang
      function tambahKeranjang(nama, harga) {
        // Ambil data keranjang yang sudah ada di Local Storage
        let listPesanan = JSON.parse(localStorage.getItem('keranjang')) || [];

        // Cari apakah produk sudah ada dalam keranjang
        let produkAda = listPesanan.find(pesanan => pesanan.nama === nama);

        if (produkAda) {
          // Jika produk ada, tambah jumlahnya
          produkAda.jumlah += 1;
        } else {
          // Jika produk belum ada, tambahkan produk baru
          let pesananBaru = {
            nama: nama,
            harga: harga,
            jumlah: 1
          };
          
          listPesanan.push(pesananBaru);
        }

        // Simpan kembali data keranjang ke Local Storage
        localStorage.setItem('keranjang', JSON.stringify(listPesanan));
      }

      // FUNGSI UNTUK MENAMPILKAN KERANJANG
      function tampilkanKeranjang() {
        const container = document.getElementById('keranjang-container');
        container.innerHTML = ''; // Bersihkan kontainer sebelum menampilkan ulang

        // Ambil data keranjang dari Local Storage
        let listPesanan = JSON.parse(localStorage.getItem('keranjang')) || [];

        if (listPesanan.length === 0) {
          container.innerHTML = '<p>Keranjang Anda kosong.</p>';
        } else {
          listPesanan.forEach(pesanan => {
            const pesananElement = document.createElement('div');
            pesananElement.classList.add('pesanan-item');

            pesananElement.innerHTML = `
              <div class="d-flex justify-content-between align-items-center">
                <div class="ms-2 me-auto">
                  <div class="fw-bold">${pesanan.nama}</div>
                  <div>Rp. ${pesanan.harga}</div>
                </div>
                <span class="badge text-bg-primary rounded-pill">${pesanan.jumlah}</span>
              </div>
            `;

            container.appendChild(pesananElement);
          });
        }

        container.style.display = 'block'; // Menampilkan keranjang setelah diisi
      }
    </script>
  </head>
  <body class="">
    <section id="header" class="py-2 bg-primary">
      <div class="container d-flex justify-content-between">
        <div id="kiri">
          <h1 class="fs-3 text-white">RUZAK MEDAN</h1>
        </div>
        <div id="kanan" class="d-flex justify-content-center align-items-center">
          <div class="mx-auto">

            <!-- Button trigger keranjang -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
              <i onclick=tampilkanKeranjang() class="fs-4 text-warning fa-solid fa-cart-shopping"></i>
            </button>

            <!-- MENU KERANJANG -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Keranjang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div id="keranjang-container" class="list-group list-group-numbered">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <a href="checkout.php" type="button" class="btn btn-primary">Pesan Sekarang</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="container mt-3 px-3">
      <div id="Menu">
        <div class="">
          <div class="row row-gap-2  justify-content-arround">
            <!-- MENGAMBIL DATA DARI DATABASE -->
            <?php
              $jsonData = file_get_contents('./databases/menu.json');
              $menuItems = json_decode($jsonData, true);
              
              // LOOPING UNTUK TAMPILKAN MENU
              foreach ($menuItems as $menu) {
                echo '<div class="col-6 col-md-3">';
                echo '<div class="card">';
                echo '<img src="' . htmlspecialchars($menu['image']) . '" class="card-img-top" alt="' . htmlspecialchars($menu['nama_product']) . '" />';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($menu['nama_product']) . '</h5>';
                echo '<p class="card-text">Rp. ' . htmlspecialchars($menu['harga']) . '</p>';
                echo '<p href="" id="tombol-pesan" class="btn btn-primary" ';
                echo 'onclick="tambahKeranjang(\'' . htmlspecialchars($menu['nama_product']) . '\', \'' . htmlspecialchars($menu['harga']) . '\')">Tambah Pesanan</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';                 
              }
            ?>
        </div>
      </div>
    </section>

    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>